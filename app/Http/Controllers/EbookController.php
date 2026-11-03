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

    public function show(Request $request, string $slug)
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

        // 5. Cek kepemilikan part/e-book yang sudah DIBELI & LUNAS (payment_status = 'paid')
        $purchasedProductIds = [];
        if (auth()->guard('web')->check()) {
            $purchasedProductIds = \App\Models\OrderItem::whereHas('order', function ($q) {
                $q->where('user_id', auth()->guard('web')->id())
                  ->where('payment_status', 'paid');
            })->pluck('product_id')->toArray();
        }

        // Cek juga jika ada parameter ?order=BV-... yang sudah lunas
        if ($request->filled('order')) {
            $paidOrder = \App\Models\Order::with('items')
                ->where('order_number', $request->query('order'))
                ->where('payment_status', 'paid')
                ->first();
            if ($paidOrder) {
                $orderProductIds = $paidOrder->items->pluck('product_id')->toArray();
                $purchasedProductIds = array_unique(array_merge($purchasedProductIds, $orderProductIds));
            }
        }

        // 6. Ulasan KHUSUS E-Book & Serial Part (eksklusif category = ebook, bukan novel fisik)
        $ebookProductIds = $book->ebookParts()->pluck('id')->toArray();
        $reviewTargetProduct = $fullEdition ?: ($chapterParts->first() ?: $book);

        $reviews = \App\Models\Review::whereIn('product_id', $ebookProductIds)
            ->where('is_approved', true)
            ->latest()
            ->get();

        $avgRating = $reviews->count() > 0 ? round($reviews->avg('rating'), 1) : 5.0;
        $totalReviews = $reviews->count();
        $starBreakdown = [
            5 => $reviews->where('rating', 5)->count(),
            4 => $reviews->where('rating', 4)->count(),
            3 => $reviews->where('rating', 3)->count(),
            2 => $reviews->where('rating', 2)->count(),
            1 => $reviews->where('rating', 1)->count(),
        ];

        $userCanReview = false;
        $userExistingReview = null;

        if (auth()->guard('web')->check()) {
            $userId = auth()->guard('web')->id();

            $userExistingReview = \App\Models\Review::whereIn('product_id', $ebookProductIds)
                ->where('user_id', $userId)
                ->first();

            $userCanReview = \App\Models\OrderItem::whereHas('order', function ($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->where('payment_status', 'paid');
            })->whereIn('product_id', $ebookProductIds)->exists();
        }

        return view('ebooks.show', compact(
            'book', 'fullEdition', 'chapterParts', 'otherEbooks', 'item', 
            'purchasedProductIds', 'reviews', 'avgRating', 'totalReviews', 
            'starBreakdown', 'userCanReview', 'userExistingReview', 'reviewTargetProduct'
        ));
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

        // 3. Verifikasi Hak Akses Membaca (Wajib Payment Status Paid)
        $hasAccess = false;
        $order = null;

        // Admin mode preview: HANYA jika login sebagai admin DAN membuka tautan preview dari dashboard admin (?preview=admin)
        $isAdminPreview = auth()->guard('admin')->check() && $request->query('preview') === 'admin';
        if ($isAdminPreview) {
            $hasAccess = true;
        }

        // Cari ID e-book lengkap dari buku ini (jika user membeli e-book lengkap, semua part otomatis terbuka)
        $fullEditionPart = $allParts->first(function ($p) {
            return $p->subcategory === 'ebook' || empty($p->part_number);
        });
        $validProductIds = array_values(array_unique(array_filter([
            $part->id, 
            $parent->id, 
            $fullEditionPart ? $fullEditionPart->id : null
        ])));

        // Cek jika ada parameter nomor pesanan (?order=BV-...) yang sudah lunas (paid)
        $orderNumber = $request->query('order');
        if (!$hasAccess && $orderNumber) {
            $matchedOrder = \App\Models\Order::with('items')
                ->where('order_number', $orderNumber)
                ->where('payment_status', 'paid')
                ->first();

            if ($matchedOrder) {
                $itemMatches = $matchedOrder->items->contains(function ($item) use ($validProductIds) {
                    return in_array($item->product_id, $validProductIds);
                });
                if ($itemMatches) {
                    $hasAccess = true;
                    $order = $matchedOrder;
                }
            }
        }

        // Cek jika customer login memiliki pesanan berstatus paid untuk part ini, edisi lengkap, atau buku induknya
        if (!$hasAccess && auth()->guard('web')->check()) {
            $userOrders = \App\Models\Order::with('items')
                ->where('user_id', auth()->guard('web')->id())
                ->where('payment_status', 'paid')
                ->get();

            foreach ($userOrders as $uOrder) {
                if ($uOrder->items->contains(function ($item) use ($validProductIds) {
                    return in_array($item->product_id, $validProductIds);
                })) {
                    $hasAccess = true;
                    $order = $uOrder;
                    break;
                }
            }
        }

        return view('reader.show', compact('part', 'parent', 'allParts', 'prevPart', 'nextPart', 'hasAccess', 'order', 'isAdminPreview'));
    }
}
