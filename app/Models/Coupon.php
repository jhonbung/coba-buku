<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type', // 'percent', 'fixed', 'shipping'
        'value',
        'min_spend',
        'max_discount',
        'usage_limit',
        'usage_count',
        'is_active',
        'is_public',
        'starts_at',
        'expires_at',
    ];

    protected $casts = [
        'value' => 'float',
        'min_spend' => 'integer',
        'max_discount' => 'integer',
        'usage_limit' => 'integer',
        'usage_count' => 'integer',
        'is_active' => 'boolean',
        'is_public' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        $now = Carbon::now();
        return $query->where('is_active', true)
            ->where(function ($q) use ($now) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', $now);
            })
            ->where(function ($q) {
                $q->whereNull('usage_limit')->orWhereRaw('usage_count < usage_limit');
            });
    }

    public function scopePublic($query)
    {
        return $query->active()->where('is_public', true);
    }

    /**
     * Cek validitas kupon untuk subtotal dan ongkir tertentu
     */
    public function checkValidity(int $subtotal, int $shippingCost = 0): array
    {
        $now = Carbon::now();

        if (!$this->is_active) {
            return ['valid' => false, 'message' => "Kupon [{$this->code}] saat ini tidak aktif."];
        }

        if ($this->starts_at && $this->starts_at->isFuture()) {
            return ['valid' => false, 'message' => "Kupon [{$this->code}] belum berlaku (mulai {$this->starts_at->translatedFormat('d M Y')})."];
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return ['valid' => false, 'message' => "Kupon [{$this->code}] telah kedaluwarsa pada {$this->expires_at->translatedFormat('d M Y') }."];
        }

        if ($this->usage_limit !== null && $this->usage_count >= $this->usage_limit) {
            return ['valid' => false, 'message' => "Kuota penggunaan kupon [{$this->code}] telah habis."];
        }

        if ($this->min_spend > 0 && $subtotal < $this->min_spend) {
            $diff = 'Rp ' . number_format($this->min_spend - $subtotal, 0, ',', '.');
            $minFormatted = 'Rp ' . number_format($this->min_spend, 0, ',', '.');
            return [
                'valid' => false,
                'message' => "Minimal belanja untuk kupon [{$this->code}] adalah {$minFormatted}. Tambahkan {$diff} lagi untuk memakai kupon ini."
            ];
        }

        if ($this->type === 'shipping' && $shippingCost <= 0) {
            return [
                'valid' => false,
                'message' => "Kupon [{$this->code}] adalah subsidi ongkir dan memerlukan pilihan ekspedisi fisik."
            ];
        }

        return ['valid' => true, 'message' => 'Kupon berhasil digunakan.'];
    }

    /**
     * Hitung besaran diskon dalam rupiah
     */
    public function calculateDiscount(int $subtotal, int $shippingCost = 0): int
    {
        $discount = 0;

        if ($this->type === 'percent') {
            $discount = (int) round(($subtotal * $this->value) / 100);
            if ($this->max_discount !== null && $this->max_discount > 0) {
                $discount = min($discount, $this->max_discount);
            }
        } elseif ($this->type === 'fixed') {
            $discount = (int) $this->value;
        } elseif ($this->type === 'shipping') {
            $discount = (int) min($this->value, $shippingCost);
        }

        // Diskon tidak boleh melebihi subtotal (atau total jika shipping)
        if ($this->type === 'shipping') {
            $discount = min($discount, $shippingCost);
        } else {
            $discount = min($discount, $subtotal);
        }

        return max(0, $discount);
    }

    public function getFormattedValueAttribute(): string
    {
        if ($this->type === 'percent') {
            return (int)$this->value . '%';
        }
        return 'Rp ' . number_format($this->value, 0, ',', '.');
    }

    public function getFormattedMinSpendAttribute(): string
    {
        if ($this->min_spend <= 0) {
            return 'Tanpa Min. Belanja';
        }
        return 'Min. Belanja Rp ' . number_format($this->min_spend, 0, ',', '.');
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'percent' => 'Diskon Persen',
            'fixed' => 'Potongan Langsung',
            'shipping' => 'Subsidi Ongkir',
            default => 'Diskon',
        };
    }
}
