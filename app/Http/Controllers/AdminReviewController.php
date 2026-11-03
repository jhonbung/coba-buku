<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['product', 'user'])->latest();

        if ($request->filled('rating')) {
            $query->where('rating', (int) $request->input('rating'));
        }

        if ($request->filled('status')) {
            if ($request->input('status') === 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->input('status') === 'pending') {
                $query->where('is_approved', false);
            }
        }

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('reviewer_name', 'like', "%{$s}%")
                  ->orWhere('book_title', 'like', "%{$s}%")
                  ->orWhere('comment', 'like', "%{$s}%")
                  ->orWhere('review_title', 'like', "%{$s}%");
            });
        }

        $reviews = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => Review::count(),
            'avg_rating' => round(Review::avg('rating') ?: 5.0, 1),
            'verified' => Review::where('is_verified_buyer', true)->count(),
            'with_replies' => Review::whereNotNull('admin_reply')->count(),
        ];

        return view('admin.reviews.index', compact('reviews', 'stats'));
    }

    public function reply(Request $request, int $id)
    {
        $review = Review::findOrFail($id);

        $validated = $request->validate([
            'admin_reply' => 'required|string|max:1000',
        ]);

        $review->update([
            'admin_reply' => $validated['admin_reply'],
            'admin_replied_at' => now(),
        ]);

        return back()->with('success', 'Balasan resmi penulis berhasil disimpan dan ditampilkan ke pembeli!');
    }

    public function toggleApproval(int $id)
    {
        $review = Review::findOrFail($id);
        $review->update([
            'is_approved' => !$review->is_approved,
        ]);

        $statusText = $review->is_approved ? 'ditampilkan ke publik' : 'disembunyikan dari publik';
        return back()->with('success', "Status ulasan berhasil {$statusText}.");
    }

    public function destroy(int $id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}

