<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class EbookController extends Controller
{
    public function index()
    {
        $fullEbooks = Product::where('category', 'ebook')
            ->where('subcategory', 'ebook')
            ->orderBy('order_index')
            ->get();

        $chapterEbooks = Product::where('category', 'ebook')
            ->where('subcategory', 'chapter')
            ->orderBy('order_index')
            ->get();

        return view('ebooks.index', compact('fullEbooks', 'chapterEbooks'));
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
