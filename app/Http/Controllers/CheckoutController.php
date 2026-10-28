<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('novels.index')->with('warning', 'Keranjang belanja Anda masih kosong.');
        }

        $subtotal = 0;
        $totalWeight = 0;
        $hasPhysicalItems = false;
        $hasDigitalItems = false;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            if ($item['category'] === 'novel' || $item['category'] === 'merchandise') {
                $hasPhysicalItems = true;
                $totalWeight += ($item['weight_grams'] ?? 350) * $item['quantity'];
            } else {
                $hasDigitalItems = true;
            }
        }

        // Standard courier rates simulation
        $courierRates = [
            'jne_reg' => ['name' => 'JNE Regular (1-2 hari kerja)', 'cost' => $hasPhysicalItems ? 18000 : 0],
            'sicepat_best' => ['name' => 'SiCepat BEST (1 hari)', 'cost' => $hasPhysicalItems ? 22000 : 0],
            'jnt_express' => ['name' => 'J&T Express (1-3 hari)', 'cost' => $hasPhysicalItems ? 17000 : 0],
        ];

        return view('checkout.index', compact('cart', 'subtotal', 'totalWeight', 'hasPhysicalItems', 'hasDigitalItems', 'courierRates'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('novels.index');
        }

        $subtotal = 0;
        $hasPhysicalItems = false;
        $hasDigitalItems = false;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            if ($item['category'] === 'novel' || $item['category'] === 'merchandise') {
                $hasPhysicalItems = true;
            } else {
                $hasDigitalItems = true;
            }
        }

        // Base validation for essential customer data
        $rules = [
            'customer_name' => 'required|string|max:100',
            'customer_email' => 'required|email|max:100',
            'customer_phone' => 'required|string|max:25',
            'payment_method' => 'required|string',
        ];

        // Address & courier are ONLY required if there are physical items
        if ($hasPhysicalItems) {
            $rules['shipping_address'] = 'required|string|max:500';
            $rules['city'] = 'required|string|max:100';
            $rules['postal_code'] = 'required|string|max:10';
            $rules['courier'] = 'required|string';
        }

        $request->validate($rules);

        $shippingCosts = [
            'JNE Regular (1-2 hari kerja)' => 18000,
            'SiCepat BEST (1 hari)' => 22000,
            'J&T Express (1-3 hari)' => 17000,
            'Digital Delivery (Email Langsung)' => 0,
        ];

        $courierName = $hasPhysicalItems ? $request->input('courier') : 'Digital Delivery (Email Langsung)';
        $shippingCost = $hasPhysicalItems ? ($shippingCosts[$courierName] ?? 18000) : 0;
        $totalAmount = $subtotal + $shippingCost;

        $orderNumber = 'BV-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        $order = Order::create([
            'order_number' => $orderNumber,
            'customer_name' => $request->input('customer_name'),
            'customer_email' => $request->input('customer_email'),
            'customer_phone' => $request->input('customer_phone'),
            'shipping_address' => $hasPhysicalItems 
                ? $request->input('shipping_address') 
                : 'Pengiriman Digital (Akses dikirim via Email & WhatsApp)',
            'city' => $hasPhysicalItems ? $request->input('city') : 'Online / Digital Delivery',
            'postal_code' => $hasPhysicalItems ? $request->input('postal_code') : '-',
            'courier' => $courierName,
            'shipping_cost' => $shippingCost,
            'subtotal' => $subtotal,
            'total_amount' => $totalAmount,
            'payment_method' => $request->input('payment_method'),
            'payment_status' => 'paid', // Auto-verified payment simulation for instant delight
            'order_status' => $hasPhysicalItems ? 'processing' : 'completed',
            'tracking_number' => $hasPhysicalItems ? ('BV-' . strtoupper(Str::random(8))) : 'DIGITAL-ACCESS',
            'digital_delivered' => true,
            'notes' => $request->input('notes'),
        ]);

        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            $accessUrl = ($product && $product->category === 'ebook') ? $product->digital_file_url : null;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'product_title' => $item['title'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity'],
                'digital_access_url' => $accessUrl,
            ]);

            // Deduct stock if physical
            if ($product && $product->category !== 'ebook') {
                $product->decrement('stock', $item['quantity']);
            }
        }

        session()->forget('cart');

        return redirect()->route('checkout.success', ['order_number' => $order->order_number]);
    }

    public function success(string $order_number)
    {
        $order = Order::with('items.product')->where('order_number', $order_number)->firstOrFail();
        return view('checkout.success', compact('order'));
    }
}
