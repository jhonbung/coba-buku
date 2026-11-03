<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class NovelController extends Controller
{
    public function index(Request $request)
    {
        // STRICTLY PHYSICAL NOVELS ONLY (No e-books or merchandise mixed in)
        $query = Product::where('category', 'novel');

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

        // Preload grouped physical series for seamless browsing
        $notonegoroNovels = Product::where('category', 'novel')
            ->where(function ($q) {
                $q->where('subcategory', 'notonegoro')
                  ->orWhere('series_name', 'like', '%Notonegoro%');
            })
            ->orderBy('order_index')
            ->get();

        $standaloneNovels = Product::where('category', 'novel')
            ->where(function ($q) {
                $q->where('subcategory', 'standalone')
                  ->orWhere('series_name', 'like', '%Standalone%');
            })
            ->orderBy('order_index')
            ->get();

        $limitedNovels = Product::where('category', 'novel')
            ->where(function ($q) {
                $q->where('subcategory', 'limited')
                  ->orWhere('series_name', 'like', '%Limited%');
            })
            ->orderBy('order_index')
            ->get();

        $novels = $query->paginate(12)->withQueryString();

        return view('novels.index', compact(
            'novels', 'isGroupedView',
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

        // 1. Ambil ulasan produk terverifikasi
        $targetIds = [$novel->id];
        if ($novel->parent_id) {
            $targetIds[] = $novel->parent_id;
        } else {
            $childIds = $novel->ebookParts()->pluck('id')->toArray();
            $targetIds = array_merge($targetIds, $childIds);
        }

        $reviews = \App\Models\Review::whereIn('product_id', $targetIds)
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

        // 2. Verifikasi hak mengulas: HANYA customer yang sudah login & memiliki order lunas (paid)
        $userCanReview = false;
        $userExistingReview = null;

        if (auth()->guard('web')->check()) {
            $userId = auth()->guard('web')->id();

            $userExistingReview = \App\Models\Review::where('product_id', $novel->id)
                ->where('user_id', $userId)
                ->first();

            $hasPaid = \App\Models\OrderItem::whereHas('order', function ($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->where('payment_status', 'paid');
            })->whereIn('product_id', $targetIds)->exists();

            $userCanReview = $hasPaid;
        }

        return view('novels.show', compact(
            'novel', 'otherEditions', 'seriesSiblings', 'relatedNovels',
            'reviews', 'avgRating', 'totalReviews', 'starBreakdown', 'userCanReview', 'userExistingReview'
        ));
    }
}
