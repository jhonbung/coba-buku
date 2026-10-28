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

    public function downloadDemo(int $id)
    {
        $ebook = Product::where('category', 'ebook')->findOrFail($id);

        if ($ebook->digital_file_url) {
            return redirect()->away($ebook->digital_file_url);
        }

        return back()->with('success', 'Akses unduhan digital dikirimkan ke email Anda!');
    }
}
