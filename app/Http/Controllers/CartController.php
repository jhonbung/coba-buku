<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'subtotal'));
    }

    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = max(1, (int) $request->input('quantity', 1));

        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'title' => $product->title,
                'series_name' => $product->series_name,
                'category' => $product->category,
                'price' => $product->price,
                'cover_image' => $product->cover_image,
                'quantity' => $quantity,
                'weight_grams' => $product->weight_grams ?? 300,
            ];
        }

        session()->put('cart', $cart);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Buku berhasil ditambahkan ke keranjang!',
                'cart_count' => array_sum(array_column($cart, 'quantity')),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Buku berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = (int) $request->input('quantity', 1);

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            if ($quantity > 0) {
                $cart[$productId]['quantity'] = $quantity;
            } else {
                unset($cart[$productId]);
            }
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Keranjang belanja berhasil diperbarui.');
    }

    public function remove(int $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Keranjang belanja dikosongkan.');
    }
}
