<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\MidtransService;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(ShippingService $shippingService)
    {
        if (!Auth::guard('web')->check()) {
            session()->put('url.intended', route('checkout.index'));
            return redirect()->route('login')->with('warning', 'Silakan masuk ke akun Anda terlebih dahulu sebelum melanjutkan ke checkout.');
        }

        $userId = Auth::guard('web')->id();
        $dbCartItems = CartItem::with('product')->where('user_id', $userId)->get();

        $cart = [];
        foreach ($dbCartItems as $item) {
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

        if (empty($cart)) {
            // Fallback ke session cart jika database kosong
            $cart = session()->get('cart', []);
        }

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

        $weightInKg = (int) ceil(max(1000, $totalWeight) / 1000);
        $originDesc = $shippingService->getOriginDescription();
        $isLiveApi = $shippingService->isApiKeySet();

        // Provinces and Cities dictionary
        $provincesAndCities = $hasPhysicalItems ? $shippingService->getProvincesAndCities() : [];
        $defaultDestinationId = 17589; // Jakarta Selatan
        $initialCourierRates = $hasPhysicalItems ? $shippingService->calculateCost($defaultDestinationId, $totalWeight) : [];

        return view('checkout.index', compact(
            'cart',
            'subtotal',
            'totalWeight',
            'weightInKg',
            'hasPhysicalItems',
            'hasDigitalItems',
            'originDesc',
            'isLiveApi',
            'provincesAndCities',
            'initialCourierRates'
        ));
    }

    /**
     * AJAX endpoint: Calculate real-time shipping costs based on destination ID and cart weight
     */
    public function calculateShipping(Request $request, ShippingService $shippingService)
    {
        $destinationId = (int) $request->input('destination_id');
        if (!$destinationId) {
            return response()->json(['error' => 'Destination ID required'], 422);
        }

        $cart = session()->get('cart', []);
        $totalWeight = 0;

        foreach ($cart as $item) {
            if ($item['category'] === 'novel' || $item['category'] === 'merchandise') {
                $totalWeight += ($item['weight_grams'] ?? 350) * $item['quantity'];
            }
        }

        $weight = max(1000, $totalWeight);
        $rates = $shippingService->calculateCost($destinationId, $weight);

        return response()->json([
            'weight_grams' => $weight,
            'weight_kg' => ceil($weight / 1000),
            'rates' => $rates,
            'is_live_api' => $shippingService->isApiKeySet(),
        ]);
    }

    public function store(Request $request, MidtransService $midtransService)
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('login')->with('warning', 'Sesi login telah berakhir. Silakan login kembali.');
        }

        $userId = Auth::guard('web')->id();
        $dbCartItems = CartItem::with('product')->where('user_id', $userId)->get();

        $cart = [];
        foreach ($dbCartItems as $item) {
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

        if (empty($cart)) {
            $cart = session()->get('cart', []);
        }

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
            $rules['province'] = 'required|string|max:100';
            $rules['city'] = 'required|string|max:100';
            $rules['district'] = 'nullable|string|max:100';
            $rules['postal_code'] = 'required|string|max:10';
            $rules['courier'] = 'required|string';
            $rules['shipping_cost'] = 'required|numeric|min:0';
        }

        $request->validate($rules);

        $courierName = $hasPhysicalItems ? $request->input('courier') : 'Digital Delivery (Email Langsung)';
        $shippingCost = $hasPhysicalItems ? (int) $request->input('shipping_cost', 10000) : 0;
        $totalAmount = $subtotal + $shippingCost;

        $orderNumber = 'BV-' . date('Ymd') . '-' . strtoupper(Str::random(5));
        
        $prov = $request->input('province', '');
        $rawCity = $request->input('city', '');
        $cityParts = explode('|', $rawCity);
        $cityName = count($cityParts) > 1 ? $cityParts[1] : $rawCity;
        $dist = $request->input('district', '');
        $fullLocation = $dist ? "{$cityName}, {$prov} (Kec. {$dist})" : "{$cityName}, {$prov}";

        $order = Order::create([
            'user_id' => $userId,
            'order_number' => $orderNumber,
            'customer_name' => $request->input('customer_name'),
            'customer_email' => $request->input('customer_email'),
            'customer_phone' => $request->input('customer_phone'),
            'shipping_address' => $hasPhysicalItems 
                ? $request->input('shipping_address') 
                : 'Pengiriman Digital (Akses dikirim via Email & WhatsApp)',
            'city' => $hasPhysicalItems ? $fullLocation : 'Online / Digital Delivery',
            'postal_code' => $hasPhysicalItems ? $request->input('postal_code') : '-',
            'courier' => $courierName,
            'shipping_cost' => $shippingCost,
            'subtotal' => $subtotal,
            'total_amount' => $totalAmount,
            'payment_method' => $request->input('payment_method', 'Midtrans Snap (QRIS / VA / E-Wallet)'),
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'tracking_number' => $hasPhysicalItems ? ('BV-' . strtoupper(Str::random(8))) : 'DIGITAL-ACCESS',
            'digital_delivered' => false,
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

        // Generate Snap Token via Midtrans
        $snapToken = $midtransService->createSnapToken($order);
        $order->update(['snap_token' => $snapToken]);

        CartItem::where('user_id', $userId)->delete();
        session()->forget('cart');

        return redirect()->route('checkout.payment', ['order_number' => $order->order_number]);
    }

    /**
     * Midtrans Snap Payment Gateway Page
     */
    public function payment(string $order_number, MidtransService $midtransService)
    {
        $order = Order::with('items.product')->where('order_number', $order_number)->firstOrFail();

        // If already paid, redirect straight to invoice success
        if ($order->payment_status === 'paid') {
            return redirect()->route('checkout.success', ['order_number' => $order->order_number]);
        }

        if (empty($order->snap_token)) {
            $snapToken = $midtransService->createSnapToken($order);
            $order->update(['snap_token' => $snapToken]);
        }

        $snapToken = $order->snap_token;
        $clientKey = $midtransService->getClientKey();
        $snapJsUrl = $midtransService->getSnapJsUrl();
        $isProduction = $midtransService->isProduction();
        $isConfigured = $midtransService->isConfigured();

        return view('checkout.payment', compact(
            'order',
            'snapToken',
            'clientKey',
            'snapJsUrl',
            'isProduction',
            'isConfigured'
        ));
    }

    /**
     * Finish / Confirm Payment (Called on Snap onSuccess or simulation test)
     */
    public function finishPayment(Request $request, string $order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();

        $isDigital = str_contains($order->shipping_address, 'Digital') || $order->courier === 'Digital Delivery (Email Langsung)';

        $order->update([
            'payment_status' => 'paid',
            'order_status' => $isDigital ? 'completed' : 'processing',
            'digital_delivered' => true,
        ]);

        if ($request->wantsJson() || $request->isJson()) {
            return response()->json(['success' => true, 'redirect' => route('checkout.success', $order->order_number)]);
        }

        return redirect()->route('checkout.success', ['order_number' => $order->order_number])
            ->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }

    /**
     * Midtrans Asynchronous Webhook Notification Handler
     */
    public function handleNotification(Request $request, MidtransService $midtransService)
    {
        $payload = $request->all();
        $orderNumber = $payload['order_id'] ?? null;
        $statusCode = (string) ($payload['status_code'] ?? '');
        $grossAmount = (string) ($payload['gross_amount'] ?? '');
        $signatureKey = (string) ($payload['signature_key'] ?? '');
        $transactionStatus = $payload['transaction_status'] ?? '';
        $fraudStatus = $payload['fraud_status'] ?? 'accept';

        if (!$orderNumber) {
            return response()->json(['error' => 'Missing order_id'], 400);
        }

        $order = Order::where('order_number', $orderNumber)->first();
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        if (!$midtransService->verifySignature($orderNumber, $statusCode, $grossAmount, $signatureKey)) {
            Log::warning("Midtrans Invalid Signature for Order {$orderNumber}");
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        $isDigital = str_contains($order->shipping_address, 'Digital') || $order->courier === 'Digital Delivery (Email Langsung)';

        if ($transactionStatus === 'capture') {
            if ($fraudStatus === 'accept') {
                $order->update([
                    'payment_status' => 'paid',
                    'order_status' => $isDigital ? 'completed' : 'processing',
                    'digital_delivered' => true,
                ]);
            }
        } elseif ($transactionStatus === 'settlement') {
            $order->update([
                'payment_status' => 'paid',
                'order_status' => $isDigital ? 'completed' : 'processing',
                'digital_delivered' => true,
            ]);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $order->update([
                'payment_status' => 'failed',
                'order_status' => 'cancelled',
            ]);
        } elseif ($transactionStatus === 'pending') {
            $order->update(['payment_status' => 'pending']);
        }

        return response()->json(['status' => 'ok']);
    }

    public function success(string $order_number)
    {
        $order = Order::with('items.product')->where('order_number', $order_number)->firstOrFail();
        return view('checkout.success', compact('order'));
    }

    public function resi(string $order_number)
    {
        $order = Order::with('items.product')->where('order_number', $order_number)->firstOrFail();
        return view('admin.resi', compact('order'));
    }
}
