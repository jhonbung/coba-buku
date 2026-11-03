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

        $reviews = \App\Models\Review::where('product_id', $product->id)
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

            $userExistingReview = \App\Models\Review::where('product_id', $product->id)
                ->where('user_id', $userId)
                ->first();

            $userCanReview = \App\Models\OrderItem::whereHas('order', function ($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->where('payment_status', 'paid');
            })->where('product_id', $product->id)->exists();
        }

        return view('merchandise.show', compact('product', 'relatedProducts', 'reviews', 'avgRating', 'totalReviews', 'starBreakdown', 'userCanReview', 'userExistingReview'));
    }
}
