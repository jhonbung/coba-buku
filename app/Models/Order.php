<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

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
}
