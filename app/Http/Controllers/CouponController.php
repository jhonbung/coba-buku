<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    /**
     * Terapkan kode kupon / voucher
     */
    public function apply(Request $request)
    {
        $code = strtoupper(trim($request->input('code', '')));
        if (empty($code)) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan masukkan kode voucher terlebih dahulu.',
            ], 422);
        }

        $coupon = Coupon::where('code', $code)->first();
        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => "Kode promo [{$code}] tidak ditemukan atau tidak valid.",
            ], 404);
        }

        // Hitung subtotal keranjang saat ini
        $subtotal = $this->getCurrentSubtotal();
        if ($subtotal <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang belanja Anda masih kosong.',
            ], 422);
        }

        $shippingCost = (int) $request->input('shipping_cost', 0);

        // Validasi aturan kupon
        $check = $coupon->checkValidity($subtotal, $shippingCost);
        if (!$check['valid']) {
            return response()->json([
                'success' => false,
                'message' => $check['message'],
            ], 422);
        }

        $discountAmount = $coupon->calculateDiscount($subtotal, $shippingCost);
        $totalAmount = max(0, ($subtotal + $shippingCost) - $discountAmount);

        // Simpan ke sesi
        session()->put('applied_coupon', [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'name' => $coupon->name,
            'type' => $coupon->type,
            'value' => (float) $coupon->value,
            'discount_amount' => $discountAmount,
        ]);

        return response()->json([
            'success' => true,
            'message' => "Voucher [{$coupon->code}] berhasil digunakan! Hemat Rp " . number_format($discountAmount, 0, ',', '.'),
            'coupon' => [
                'code' => $coupon->code,
                'name' => $coupon->name,
                'type' => $coupon->type,
                'value_formatted' => $coupon->formatted_value,
            ],
            'discount_amount' => $discountAmount,
            'discount_formatted' => '-Rp ' . number_format($discountAmount, 0, ',', '.'),
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'total_amount' => $totalAmount,
            'total_formatted' => 'Rp ' . number_format($totalAmount, 0, ',', '.'),
        ]);
    }

    /**
     * Hapus kupon yang sedang aktif
     */
    public function remove(Request $request)
    {
        session()->forget('applied_coupon');

        $subtotal = $this->getCurrentSubtotal();
        $shippingCost = (int) $request->input('shipping_cost', 0);
        $totalAmount = $subtotal + $shippingCost;

        return response()->json([
            'success' => true,
            'message' => 'Kupon berhasil dihapus.',
            'discount_amount' => 0,
            'discount_formatted' => 'Rp 0',
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'total_amount' => $totalAmount,
            'total_formatted' => 'Rp ' . number_format($totalAmount, 0, ',', '.'),
        ]);
    }

    /**
     * List voucher yang aktif & public untuk ditampilkan di panel
     */
    public function available()
    {
        $coupons = Coupon::public()->get()->map(function ($c) {
            return [
                'code' => $c->code,
                'name' => $c->name,
                'description' => $c->description,
                'type' => $c->type,
                'value' => $c->value,
                'formatted_value' => $c->formatted_value,
                'min_spend' => $c->min_spend,
                'formatted_min_spend' => $c->formatted_min_spend,
                'expires_at' => $c->expires_at ? $c->expires_at->translatedFormat('d M Y') : null,
            ];
        });

        return response()->json([
            'success' => true,
            'coupons' => $coupons,
        ]);
    }

    private function getCurrentSubtotal(): int
    {
        $subtotal = 0;
        if (Auth::guard('web')->check()) {
            $items = CartItem::with('product')->where('user_id', Auth::guard('web')->id())->get();
            foreach ($items as $item) {
                if ($item->product) {
                    $subtotal += $item->product->price * $item->quantity;
                }
            }
        }

        if ($subtotal === 0) {
            $cart = session()->get('cart', []);
            foreach ($cart as $item) {
                $subtotal += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
            }
        }

        return $subtotal;
    }
}
