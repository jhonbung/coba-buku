<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    /**
     * Batas waktu pembayaran sebelum kedaluwarsa (dalam jam)
     */
    public const EXPIRY_HOURS = 24;

    protected $fillable = [
        'user_id',
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'city',
        'postal_code',
        'courier',
        'coupon_code',
        'discount_amount',
        'shipping_cost',
        'subtotal',
        'total_amount',
        'payment_method',
        'snap_token',
        'payment_status',
        'order_status',
        'tracking_number',
        'digital_delivered',
        'notes',
    ];

    protected $casts = [
        'shipping_cost' => 'integer',
        'discount_amount' => 'integer',
        'subtotal' => 'integer',
        'total_amount' => 'integer',
        'digital_delivered' => 'boolean',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    /**
     * Waktu batas pembayaran (created_at + 24 jam)
     */
    public function getExpiresAtAttribute(): ?Carbon
    {
        return $this->created_at ? $this->created_at->copy()->addHours(self::EXPIRY_HOURS) : null;
    }

    /**
     * Cek apakah pesanan telah melewati batas waktu pembayaran
     */
    public function getIsExpiredAttribute(): bool
    {
        if ($this->payment_status === 'paid' || $this->order_status === 'cancelled' || $this->payment_status === 'cancelled') {
            return false;
        }

        if ($this->payment_status === 'expired') {
            return true;
        }

        return $this->payment_status === 'pending' && $this->expires_at && now()->greaterThan($this->expires_at);
    }

    /**
     * Format string batas waktu pembayaran (WIB)
     */
    public function getFormattedExpiresAtAttribute(): string
    {
        return $this->expires_at ? $this->expires_at->timezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB' : '-';
    }

    /**
     * Sisa waktu pembayaran dalam format human-readable (misal: "23 jam 45 menit")
     */
    public function getRemainingTimeAttribute(): ?string
    {
        if ($this->is_expired || $this->payment_status !== 'pending') {
            return null;
        }

        $now = now();
        if ($now->greaterThanOrEqualTo($this->expires_at)) {
            return 'Waktu habis';
        }

        $diffMinutes = $now->diffInMinutes($this->expires_at);
        $hours = intdiv($diffMinutes, 60);
        $minutes = $diffMinutes % 60;

        if ($hours > 0) {
            return "{$hours} jam {$minutes} menit";
        }
        return "{$minutes} menit";
    }

    /**
     * Batalkan pesanan dan lakukan pemulihan stok serta voucher
     *
     * @param string $reason 'customer', 'admin', 'expired'
     */
    public function cancelOrder(string $reason = 'expired'): bool
    {
        if ($this->payment_status === 'paid') {
            return false;
        }

        if ($this->order_status === 'cancelled' && in_array($this->payment_status, ['cancelled', 'expired'])) {
            return false;
        }

        if (in_array($this->order_status, ['shipped', 'completed'])) {
            return false;
        }

        // 1. Kembalikan stok produk fisik
        foreach ($this->items as $item) {
            if ($item->product && $item->product->category !== 'ebook') {
                $item->product->increment('stock', $item->quantity);
            }
        }

        // 2. Kembalikan kuota voucher kupon jika digunakan
        if ($this->coupon_code) {
            $coupon = Coupon::where('code', $this->coupon_code)->first();
            if ($coupon && $coupon->usage_count > 0) {
                $coupon->decrement('usage_count');
            }
        }

        // 3. Batalkan di Midtrans jika ada token transaksi aktif
        try {
            $serverKey = config('services.midtrans.server_key') ?: env('MIDTRANS_SERVER_KEY');
            if ($serverKey) {
                \Midtrans\Config::$serverKey = $serverKey;
                \Midtrans\Config::$isProduction = (bool) (config('services.midtrans.is_production') ?? env('MIDTRANS_IS_PRODUCTION', false));
                \Midtrans\Transaction::cancel($this->order_number);
            }
        } catch (\Throwable $e) {
            // Midtrans cancel bisa gagal jika belum ada transaksi di Midtrans; abaikan
        }

        // 4. Update status pesanan
        $statusLabels = [
            'customer' => 'Dibatalkan oleh customer',
            'admin' => 'Dibatalkan oleh admin',
            'expired' => 'Dibatalkan otomatis oleh sistem (Waktu pembayaran kedaluwarsa)',
        ];
        $label = $statusLabels[$reason] ?? "Dibatalkan ({$reason})";
        $paymentStatus = $reason === 'expired' ? 'expired' : 'cancelled';

        $this->update([
            'order_status' => 'cancelled',
            'payment_status' => $paymentStatus,
            'notes' => trim(($this->notes ? $this->notes . "\n" : '') . "[{$label} pada " . now()->timezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB]'),
        ]);

        return true;
    }

    /**
     * Batalkan seluruh pesanan pending yang telah melewati batas 24 jam
     */
    public static function cancelAllExpired(): int
    {
        $expiredOrders = self::with('items.product')
            ->where('payment_status', 'pending')
            ->where('order_status', '!=', 'cancelled')
            ->where('created_at', '<=', now()->subHours(self::EXPIRY_HOURS))
            ->get();

        $count = 0;
        foreach ($expiredOrders as $order) {
            if ($order->cancelOrder('expired')) {
                $count++;
            }
        }

        return $count;
    }
}
