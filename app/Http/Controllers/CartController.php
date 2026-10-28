<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Tampilkan halaman keranjang belanja
     */
    public function index()
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('login')->with('warning', 'Silakan masuk ke akun Anda terlebih dahulu untuk melihat keranjang belanja.');
        }

        $cart = $this->getUserCartArray(Auth::guard('web')->id());
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'subtotal'));
    }

    /**
     * Tambahkan buku/produk ke keranjang belanja akun customer
     */
    public function add(Request $request)
    {
        if (!Auth::guard('web')->check()) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'redirect' => route('login'),
                    'message' => 'Silakan masuk ke akun Anda terlebih dahulu untuk berbelanja.',
                ], 401);
            }

            session()->put('url.intended', url()->previous());
            return redirect()->route('login')->with('warning', 'Silakan masuk ke akun Anda terlebih dahulu untuk menambahkan produk ke keranjang belanja.');
        }

        $productId = (int) $request->input('product_id');
        $quantity = max(1, (int) $request->input('quantity', 1));

        $product = Product::findOrFail($productId);
        $userId = Auth::guard('web')->id();

        // Cari atau buat item keranjang akun ini
        $cartItem = CartItem::firstOrNew([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);

        $cartItem->quantity = ($cartItem->exists ? $cartItem->quantity : 0) + $quantity;
        $cartItem->save();

        $cart = $this->getUserCartArray($userId);
        session()->put('cart', $cart);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Buku berhasil ditambahkan ke keranjang akun Anda!',
                'cart_count' => array_sum(array_column($cart, 'quantity')),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Buku berhasil ditambahkan ke keranjang akun Anda!');
    }

    /**
     * Perbarui jumlah item di keranjang
     */
    public function update(Request $request)
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('login');
        }

        $productId = (int) $request->input('product_id');
        $quantity = (int) $request->input('quantity', 1);
        $userId = Auth::guard('web')->id();

        if ($quantity > 0) {
            CartItem::updateOrCreate(
                ['user_id' => $userId, 'product_id' => $productId],
                ['quantity' => $quantity]
            );
        } else {
            CartItem::where('user_id', $userId)->where('product_id', $productId)->delete();
        }

        $cart = $this->getUserCartArray($userId);
        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Keranjang belanja berhasil diperbarui.');
    }

    /**
     * Hapus item dari keranjang
     */
    public function remove(int $id)
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('login');
        }

        $userId = Auth::guard('web')->id();
        CartItem::where('user_id', $userId)->where('product_id', $id)->delete();

        $cart = $this->getUserCartArray($userId);
        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    /**
     * Kosongkan seluruh isi keranjang belanja akun ini
     */
    public function clear()
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('login');
        }

        $userId = Auth::guard('web')->id();
        CartItem::where('user_id', $userId)->delete();
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Keranjang belanja Anda telah dikosongkan.');
    }

    /**
     * Helper untuk mengambil array keranjang belanja dari database
     */
    private function getUserCartArray(int $userId): array
    {
        $items = CartItem::with('product')->where('user_id', $userId)->get();
        $cart = [];

        foreach ($items as $item) {
            if (!$item->product) continue;
            $p = $item->product;
            $weight = ($p->category === 'ebook') ? 0 : ($p->weight_grams ?? 350);

            $cart[$p->id] = [
                'id' => $p->id,
                'title' => $p->title,
                'series_name' => $p->series_name,
                'category' => $p->category,
                'price' => $p->price,
                'cover_image' => $p->cover_image,
                'quantity' => $item->quantity,
                'weight_grams' => $weight,
            ];
        }

        return $cart;
    }
}
