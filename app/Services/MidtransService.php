<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    protected string $serverKey;
    protected string $clientKey;
    protected bool $isProduction;
    protected string $snapApiUrl;
    protected string $snapJsUrl;

    public function __construct()
    {
        $this->serverKey = env('MIDTRANS_SERVER_KEY', '');
        $this->clientKey = env('MIDTRANS_CLIENT_KEY', '');
        
        $envProd = env('MIDTRANS_IS_PRODUCTION', false);
        $this->isProduction = filter_var($envProd, FILTER_VALIDATE_BOOLEAN);

        if ($this->isProduction) {
            $this->snapApiUrl = 'https://app.midtrans.com/snap/v1';
            $this->snapJsUrl = 'https://app.midtrans.com/snap/snap.js';
        } else {
            $this->snapApiUrl = 'https://app.sandbox.midtrans.com/snap/v1';
            $this->snapJsUrl = 'https://app.sandbox.midtrans.com/snap/snap.js';
        }
    }

    public function isConfigured(): bool
    {
        return !empty($this->serverKey) && !empty($this->clientKey);
    }

    public function getClientKey(): string
    {
        return $this->clientKey ?: 'SB-Mid-client-demo-bv';
    }

    public function getSnapJsUrl(): string
    {
        return $this->snapJsUrl;
    }

    public function isProduction(): bool
    {
        return $this->isProduction;
    }

    /**
     * Create Midtrans Snap Token for an Order
     */
    public function createSnapToken(Order $order): ?string
    {
        // 1. Prepare item details
        $items = [];
        $calculatedGross = 0;

        foreach ($order->items as $item) {
            $price = (int) $item->price;
            $qty = (int) $item->quantity;
            $calculatedGross += $price * $qty;

            $items[] = [
                'id' => (string) ($item->product_id ?: 'item-' . $item->id),
                'price' => $price,
                'quantity' => $qty,
                'name' => mb_substr($item->product_title, 0, 48, 'UTF-8'),
            ];
        }

        // Add shipping cost if exists
        if ((int) $order->shipping_cost > 0) {
            $shippingPrice = (int) $order->shipping_cost;
            $calculatedGross += $shippingPrice;

            $items[] = [
                'id' => 'SHIPPING',
                'price' => $shippingPrice,
                'quantity' => 1,
                'name' => mb_substr('Ongkir: ' . $order->courier, 0, 48, 'UTF-8'),
            ];
        }

        // Fallback safety if item details sum differs from total amount
        $grossAmount = (int) $order->total_amount;
        if ($calculatedGross !== $grossAmount) {
            $items = [
                [
                    'id' => 'ORDER-TOTAL',
                    'price' => $grossAmount,
                    'quantity' => 1,
                    'name' => mb_substr('Total Pesanan #' . $order->order_number, 0, 48, 'UTF-8'),
                ]
            ];
        }

        $payload = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $order->customer_name,
                'email' => $order->customer_email,
                'phone' => $order->customer_phone,
                'billing_address' => [
                    'first_name' => $order->customer_name,
                    'phone' => $order->customer_phone,
                    'address' => mb_substr($order->shipping_address, 0, 190, 'UTF-8'),
                    'city' => mb_substr($order->city, 0, 50, 'UTF-8'),
                    'postal_code' => $order->postal_code,
                ],
                'shipping_address' => [
                    'first_name' => $order->customer_name,
                    'phone' => $order->customer_phone,
                    'address' => mb_substr($order->shipping_address, 0, 190, 'UTF-8'),
                    'city' => mb_substr($order->city, 0, 50, 'UTF-8'),
                    'postal_code' => $order->postal_code,
                ],
            ],
            'item_details' => $items,
            'enabled_payments' => [
                'gopay', 'shopeepay', 'qris',
                'bca_va', 'bni_va', 'bri_va', 'mandiri_va', 'permata_va', 'other_va',
                'credit_card'
            ],
        ];

        // 2. If Midtrans credentials are set, call real API
        if ($this->isConfigured()) {
            try {
                $authHeader = 'Basic ' . base64_encode($this->serverKey . ':');
                $response = Http::withHeaders([
                    'Authorization' => $authHeader,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])->timeout(12)->post("{$this->snapApiUrl}/transactions", $payload);

                if ($response->successful()) {
                    $token = $response->json('token');
                    if ($token) {
                        return $token;
                    }
                } else {
                    Log::warning('Midtrans createSnapToken failed: ' . $response->body());
                }
            } catch (\Throwable $e) {
                Log::error('Midtrans Exception: ' . $e->getMessage());
            }
        }

        // 3. Fallback simulation token if Midtrans key is not set or failed in sandbox
        return 'demo-snap-token-' . md5($order->order_number . time());
    }

    /**
     * Verify Midtrans Webhook Signature
     */
    public function verifySignature(string $orderId, string $statusCode, string $grossAmount, string $signatureKey): bool
    {
        if (empty($this->serverKey)) {
            return true;
        }

        $expected = hash('sha512', $orderId . $statusCode . $grossAmount . $this->serverKey);
        return hash_equals($expected, $signatureKey);
    }
}

