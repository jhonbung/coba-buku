<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class NovelController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('category', 'novel');

        if ($request->filled('category')) {
            $cat = $request->input('category');
            if ($cat === 'notonegoro') {
                $query->where('subcategory', 'notonegoro');
            } elseif ($cat === 'standalone') {
                $query->where('subcategory', 'standalone');
            } elseif ($cat === 'limited') {
                $query->where('subcategory', 'limited');
            }
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('synopsis', 'like', "%{$search}%")
                  ->orWhere('genre', 'like', "%{$search}%");
            });
        }

        if ($request->input('sort') === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->input('sort') === 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('order_index', 'asc');
        }

        $novels = $query->paginate(12)->withQueryString();

        return view('novels.index', compact('novels'));
    }

    public function show(string $slug)
    {
        $novel = Product::where('slug', $slug)->firstOrFail();
        
        $relatedNovels = Product::where('category', 'novel')
            ->where('id', '!=', $novel->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('novels.show', compact('novel', 'relatedNovels'));
    }
}
