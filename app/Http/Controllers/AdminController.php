<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        $totalSales = Order::where('payment_status', 'paid')->sum('total_amount');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $lowStockCount = Product::where('stock', '<', 20)->where('category', '!=', 'ebook')->count();

        $recentOrders = Order::with('items')->latest()->take(10)->get();

        return view('admin.index', compact(
            'totalSales',
            'totalOrders',
            'totalProducts',
            'lowStockCount',
            'recentOrders'
        ));
    }

    public function orders()
    {
        $orders = Order::with('items')->latest()->paginate(15);
        return view('admin.orders', compact('orders'));
    }

    public function printResi(string $order_number)
    {
        $order = Order::with('items.product')->where('order_number', $order_number)->firstOrFail();
        return view('admin.resi', compact('order'));
    }

    public function updateOrderStatus(Request $request, string $order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();

        $order->update([
            'order_status' => $request->input('order_status', $order->order_status),
            'tracking_number' => $request->input('tracking_number', $order->tracking_number),
        ]);

        return back()->with('success', 'Status pesanan dan resi berhasil diperbarui!');
    }

    public function products()
    {
        $products = Product::orderBy('category')->orderBy('order_index')->get();
        return view('admin.products', compact('products'));
    }

    public function createProduct()
    {
        return view('admin.products_create');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:novel,ebook,merchandise',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'cover_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        $data = $request->except(['_token', 'cover_image_file', 'cover_image_url', 'collectors_items_text']);
        $data['author'] = $request->input('author', 'Bianca Veana') ?: 'Bianca Veana';
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_preorder'] = $request->boolean('is_preorder');

        // Generate Unique Slug
        $slug = Str::slug($request->input('title'));
        if (Product::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }
        $data['slug'] = $slug;

        // Handle Image
        if ($request->hasFile('cover_image_file')) {
            $file = $request->file('cover_image_file');
            $fileName = time() . '_' . Str::slug($request->input('title')) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);
            $data['cover_image'] = '/images/' . $fileName;
        } elseif ($request->filled('cover_image_url')) {
            $data['cover_image'] = $request->input('cover_image_url');
        } else {
            $data['cover_image'] = '/images/mantra.svg';
        }

        // Handle Collectors Items array
        if ($request->filled('collectors_items_text')) {
            $items = preg_split('/[\r\n,]+/', $request->input('collectors_items_text'));
            $data['collectors_items'] = array_values(array_filter(array_map('trim', $items)));
        } else {
            $data['collectors_items'] = null;
        }

        Product::create($data);

        return redirect()->route('admin.products')->with('success', 'Produk baru "' . $request->title . '" berhasil ditambahkan ke katalog!');
    }

    public function editProduct(int $id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products_edit', compact('product'));
    }

    public function updateProduct(Request $request, int $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:novel,ebook,merchandise',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'cover_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        $data = $request->except(['_token', '_method', 'cover_image_file', 'cover_image_url', 'collectors_items_text']);
        $data['author'] = $request->input('author', 'Bianca Veana') ?: 'Bianca Veana';
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_preorder'] = $request->boolean('is_preorder');

        // Update Slug if title changed
        if ($request->input('title') !== $product->title) {
            $slug = Str::slug($request->input('title'));
            if (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug .= '-' . time();
            }
            $data['slug'] = $slug;
        }

        // Handle Image update
        if ($request->hasFile('cover_image_file')) {
            $file = $request->file('cover_image_file');
            $fileName = time() . '_' . Str::slug($request->input('title')) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);
            $data['cover_image'] = '/images/' . $fileName;
        } elseif ($request->filled('cover_image_url')) {
            $data['cover_image'] = $request->input('cover_image_url');
        }

        // Handle Collectors Items array
        if ($request->filled('collectors_items_text')) {
            $items = preg_split('/[\r\n,]+/', $request->input('collectors_items_text'));
            $data['collectors_items'] = array_values(array_filter(array_map('trim', $items)));
        } else {
            $data['collectors_items'] = null;
        }

        $product->update($data);

        return redirect()->route('admin.products')->with('success', 'Produk "' . $product->title . '" berhasil diperbarui!');
    }

    public function destroyProduct(int $id)
    {
        $product = Product::findOrFail($id);
        $title = $product->title;
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Produk "' . $title . '" berhasil dihapus dari sistem.');
    }

    public function updateStock(Request $request, int $id)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'stock' => max(0, (int) $request->input('stock')),
            'price' => max(0, (int) $request->input('price')),
        ]);

        return back()->with('success', "Stok & harga {$product->title} berhasil diperbarui.");
    }
}
