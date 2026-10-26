<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class MerchandiseController extends Controller
{
    public function index()
    {
        $merchandise = Product::where('category', 'merchandise')
            ->orderBy('order_index')
            ->get();

        return view('merchandise.index', compact('merchandise'));
    }

    public function show(string $slug)
    {
        $product = Product::where('category', 'merchandise')
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedProducts = Product::where('category', 'merchandise')
            ->where('id', '!=', $product->id)
            ->take(3)
            ->get();

        return view('merchandise.show', compact('product', 'relatedProducts'));
    }
}
