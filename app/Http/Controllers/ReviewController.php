<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ReviewController extends Controller
{
    /**
     * Simpan ulasan baru dari customer yang sudah membeli produk (Verified Buyer Only)
     */
    public function store(Request $request)
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('login')->with('warning', 'Silakan masuk ke akun Anda terlebih dahulu untuk memberikan ulasan.');
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review_title' => 'nullable|string|max:120',
            'comment' => 'required|string|min:8|max:2000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ], [
            'rating.required' => 'Silakan pilih bintang ulasan Anda (1-5 bintang).',
            'comment.required' => 'Kesan atau ulasan Anda wajib diisi.',
            'comment.min' => 'Ulasan minimal 8 karakter.',
            'photo.max' => 'Ukuran foto maksimal 3MB.',
        ]);

        $user = Auth::guard('web')->user();
        $product = Product::findOrFail($validated['product_id']);

        // 1. Verifikasi Pembelian Sesuai Kategori Produk (Novel Fisik vs E-Book vs Merchandise)
        if ($product->category === 'ebook') {
            // E-Book: hanya berlaku untuk edisi e-book dan serial part digital (bukan buku cetak fisik)
            $parentId = $product->parent_id ?: $product->id;
            $targetIds = Product::where('category', 'ebook')
                ->where(function ($q) use ($parentId, $product) {
                    $q->where('parent_id', $parentId)
                      ->orWhere('id', $product->id);
                })->pluck('id')->toArray();
        } elseif ($product->category === 'novel') {
            // Novel Fisik: hanya berlaku untuk edisi cetak fisik (bukan e-book digital)
            $targetIds = Product::where('category', 'novel')
                ->where(function ($q) use ($product) {
                    $q->where('id', $product->id)
                      ->orWhere('title', 'like', "%{$product->title}%");
                })->pluck('id')->toArray();
        } else {
            // Merchandise
            $targetIds = [$product->id];
        }

        $paidOrderItem = OrderItem::whereHas('order', function ($q) use ($user) {
            $q->where('user_id', $user->id)
              ->where('payment_status', 'paid');
        })->whereIn('product_id', $targetIds)->latest()->first();

        if (!$paidOrderItem) {
            $catLabel = $product->category === 'ebook' ? 'E-Book Digital' : ($product->category === 'novel' ? 'Buku Cetak Fisik' : 'Merchandise');
            return back()->with('error', "Akses Ulasan Terproteksi: Hanya pembeli yang telah memesan dan menyelesaikan pembayaran untuk {$catLabel} ini yang berhak memberikan ulasan.");
        }

        // 2. Upload foto unboxing jika ada
        $photoUrl = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = 'review_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $targetDir = public_path('images/reviews');
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            $file->move($targetDir, $fileName);
            $photoUrl = 'images/reviews/' . $fileName;
        }

        // 3. Simpan atau perbarui ulasan (1 customer = 1 review per produk)
        $review = Review::updateOrCreate(
            [
                'user_id' => $user->id,
                'product_id' => $product->id,
            ],
            [
                'order_id' => $paidOrderItem->order_id,
                'reviewer_name' => $user->name,
                'reviewer_email' => $user->email,
                'book_title' => $product->title,
                'variant_name' => $paidOrderItem->product_title ?? $product->title,
                'rating' => $validated['rating'],
                'review_title' => $validated['review_title'] ?: null,
                'comment' => $validated['comment'],
                'photo_url' => $photoUrl ?: null,
                'is_verified_buyer' => true,
                'is_approved' => true,
            ]
        );

        return back()->with('success', 'Terima kasih! Ulasan pembeli terverifikasi Anda telah berhasil diterbitkan.');
    }

    /**
     * Tandai ulasan sebagai Membantu (Helpful Vote)
     */
    public function voteHelpful(Request $request, int $id)
    {
        $review = Review::findOrFail($id);

        $votedKey = 'helpful_voted_review_' . $review->id;
        if (session()->has($votedKey)) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memberikan apresiasi untuk ulasan ini.',
                'count' => $review->helpful_count,
            ]);
        }

        $review->increment('helpful_count');
        session()->put($votedKey, true);

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih atas penilaian Anda!',
            'count' => $review->helpful_count,
        ]);
    }

    /**
     * Hapus ulasan milik customer yang sedang login
     */
    public function destroy(int $id)
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('login')->with('warning', 'Silakan login terlebih dahulu.');
        }

        $review = Review::where('id', $id)
            ->where('user_id', Auth::guard('web')->id())
            ->firstOrFail();

        $review->delete();

        return back()->with('success', 'Ulasan Anda berhasil dihapus.');
    }
}

