<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Quote;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $notonegoroSeries = Product::where('category', 'novel')
            ->where('subcategory', 'notonegoro')
            ->orderBy('order_index')
            ->get();

        $standaloneNovel = Product::where('subcategory', 'standalone')->first();

        $newArrivals = Product::where('is_preorder', true)
            ->orWhere('is_featured', true)
            ->take(4)
            ->get();

        $quotes = Quote::orderBy('order_index')->get();
        $reviews = Review::latest()->take(6)->get();

        return view('home', compact(
            'notonegoroSeries',
            'standaloneNovel',
            'newArrivals',
            'quotes',
            'reviews'
        ));
    }
}
