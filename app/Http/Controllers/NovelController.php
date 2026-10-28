<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class NovelController extends Controller
{
    public function index(Request $request)
    {
        $format = $request->input('format', 'all');
        
        $query = Product::query();
        if ($format === 'novel') {
            $query->where('category', 'novel');
        } elseif ($format === 'ebook') {
            $query->where('category', 'ebook');
        } else {
            $query->whereIn('category', ['novel', 'ebook']);
        }

        if ($request->filled('category')) {
            $cat = $request->input('category');
            if ($cat === 'notonegoro') {
                $query->where(function ($q) {
                    $q->where('subcategory', 'notonegoro')
                      ->orWhere('series_name', 'like', '%Notonegoro%');
                });
            } elseif ($cat === 'standalone') {
                $query->where(function ($q) {
                    $q->where('subcategory', 'standalone')
                      ->orWhere('series_name', 'like', '%Standalone%');
                });
            } elseif ($cat === 'limited') {
                $query->where(function ($q) {
                    $q->where('subcategory', 'limited')
                      ->orWhere('series_name', 'like', '%Limited%');
                });
            }
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('synopsis', 'like', "%{$search}%")
                  ->orWhere('genre', 'like', "%{$search}%")
                  ->orWhere('series_name', 'like', "%{$search}%");
            });
        }

        if ($request->input('sort') === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->input('sort') === 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('order_index', 'asc');
        }

        $isGroupedView = !$request->filled('category') && !$request->filled('search') && !$request->filled('sort');

        // Preload grouped series for seamless browsing
        $notonegoroNovels = Product::whereIn('category', ['novel', 'ebook'])
            ->where(function ($q) {
                $q->where('subcategory', 'notonegoro')
                  ->orWhere('series_name', 'like', '%Notonegoro%');
            })
            ->when($format === 'novel', fn($q) => $q->where('category', 'novel'))
            ->when($format === 'ebook', fn($q) => $q->where('category', 'ebook'))
            ->orderBy('order_index')
            ->get();

        $standaloneNovels = Product::whereIn('category', ['novel', 'ebook'])
            ->where(function ($q) {
                $q->where('subcategory', 'standalone')
                  ->orWhere('series_name', 'like', '%Standalone%');
            })
            ->when($format === 'novel', fn($q) => $q->where('category', 'novel'))
            ->when($format === 'ebook', fn($q) => $q->where('category', 'ebook'))
            ->orderBy('order_index')
            ->get();

        $limitedNovels = Product::whereIn('category', ['novel', 'ebook'])
            ->where(function ($q) {
                $q->where('subcategory', 'limited')
                  ->orWhere('series_name', 'like', '%Limited%');
            })
            ->when($format === 'novel', fn($q) => $q->where('category', 'novel'))
            ->when($format === 'ebook', fn($q) => $q->where('category', 'ebook'))
            ->orderBy('order_index')
            ->get();

        $novels = $query->paginate(12)->withQueryString();

        return view('novels.index', compact(
            'novels', 'isGroupedView', 'format',
            'notonegoroNovels', 'standaloneNovels', 'limitedNovels'
        ));
    }

    public function show(string $slug)
    {
        $novel = Product::where('slug', $slug)->firstOrFail();
        
        // Other formats/editions of this title (Novel, E-Book, Chapter, Boxset, Merch)
        $otherEditions = $novel->other_editions;

        // Chronological siblings in the same series (e.g. Notonegoro Series 1, 2, 3, 4)
        $seriesSiblings = $novel->series_siblings;

        $relatedNovels = Product::where('category', 'novel')
            ->where('id', '!=', $novel->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('novels.show', compact('novel', 'otherEditions', 'seriesSiblings', 'relatedNovels'));
    }
}
