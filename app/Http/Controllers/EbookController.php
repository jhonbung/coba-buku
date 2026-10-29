<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class EbookController extends Controller
{
    public function index()
    {
        // 1 judul tampilan luar (Mantra, Hierarchy, Fate, Serenity)
        $ebookTitles = Product::with('ebookParts')
            ->whereNull('parent_id')
            ->where('category', 'novel')
            ->where('subcategory', 'notonegoro')
            ->orderBy('order_index')
            ->get();

        return view('ebooks.index', compact('ebookTitles'));
    }

    public function show(string $slug)
    {
        // 1. Cari produk berdasarkan slug
        $item = Product::where('slug', $slug)->firstOrFail();

        // 2. Jika slug yang diakses adalah bagian digital dari sebuah buku, gunakan parent-nya sebagai fokus utama
        if ($item->parent_id) {
            $book = Product::with('ebookParts')->findOrFail($item->parent_id);
        } else {
            $book = $item->load('ebookParts');
        }

        // 3. Pisahkan antara Full E-Book Complete Edition dan Serial Bab Digital (Parts)
        $allParts = $book->ebookParts;
        $fullEdition = $allParts->first(function ($p) {
            return $p->subcategory === 'ebook' || empty($p->part_number);
        });

        $chapterParts = $allParts->filter(function ($p) {
            return $p->subcategory === 'chapter' || !empty($p->part_number);
        })->sortBy('part_number');

        // 4. Koleksi judul e-book lainnya di Bianca Veana Universe
        $otherEbooks = Product::whereNull('parent_id')
            ->where('category', 'novel')
            ->where('subcategory', 'notonegoro')
            ->where('id', '!=', $book->id)
            ->orderBy('order_index')
            ->get();

        return view('ebooks.show', compact('book', 'fullEdition', 'chapterParts', 'otherEbooks', 'item'));
    }

    public function downloadDemo(int $id)
    {
        $ebook = Product::where('category', 'ebook')->findOrFail($id);

        if ($ebook->digital_file_url) {
            return redirect()->away($ebook->digital_file_url);
        }

        return back()->with('success', 'Akses unduhan digital dikirimkan ke email Anda!');
    }

    /**
     * Web Novel Reader (Opsi B: Baca Langsung di Web)
     */
    public function reader(Request $request, string $slug)
    {
        // 1. Cari part atau novel berdasarkan slug
        $part = Product::where('slug', $slug)->firstOrFail();

        // 2. Tentukan buku induk (parent novel)
        if ($part->parent_id) {
            $parent = Product::with('ebookParts')->findOrFail($part->parent_id);
        } else {
            $parent = $part->load('ebookParts');
        }

        // Semua part terkait untuk navigasi bab
        $allParts = $parent->ebookParts->sortBy('part_number')->values();
        
        $currentPartNumber = $part->part_number;
        $prevPart = null;
        $nextPart = null;

        if ($currentPartNumber) {
            $prevPart = $allParts->filter(function($p) use ($currentPartNumber) {
                return $p->part_number && $p->part_number < $currentPartNumber;
            })->last();

            $nextPart = $allParts->filter(function($p) use ($currentPartNumber) {
                return $p->part_number && $p->part_number > $currentPartNumber;
            })->first();
        }

        // 3. Verifikasi Hak Akses Membaca
        $hasAccess = false;
        $order = null;

        // Admin selalu punya akses baca (mode preview)
        if (auth()->guard('admin')->check()) {
            $hasAccess = true;
        }

        // Cek jika ada parameter nomor pesanan (?order=BV-...) yang sudah lunas (paid)
        $orderNumber = $request->query('order');
        if (!$hasAccess && $orderNumber) {
            $matchedOrder = \App\Models\Order::with('items')
                ->where('order_number', $orderNumber)
                ->where('payment_status', 'paid')
                ->first();

            if ($matchedOrder) {
                $itemMatches = $matchedOrder->items->contains(function($item) use ($part, $parent) {
                    return $item->product_id === $part->id || $item->product_id === $parent->id;
                });
                if ($itemMatches) {
                    $hasAccess = true;
                    $order = $matchedOrder;
                }
            }
        }

        // Cek jika customer login memiliki pesanan berstatus paid untuk part ini atau buku induknya
        if (!$hasAccess && auth()->check()) {
            $userOrders = \App\Models\Order::with('items')
                ->where('user_id', auth()->id())
                ->where('payment_status', 'paid')
                ->get();

            foreach ($userOrders as $uOrder) {
                if ($uOrder->items->contains(function($item) use ($part, $parent) {
                    return $item->product_id === $part->id || $item->product_id === $parent->id;
                })) {
                    $hasAccess = true;
                    $order = $uOrder;
                    break;
                }
            }
        }

        return view('reader.show', compact('part', 'parent', 'allParts', 'prevPart', 'nextPart', 'hasAccess', 'order'));
    }
}
