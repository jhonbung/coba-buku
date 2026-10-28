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
}
