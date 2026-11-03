<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'reviewer_name',
        'reviewer_email',
        'book_title',
        'variant_name',
        'rating',
        'review_title',
        'comment',
        'photo_url',
        'is_verified_buyer',
        'is_approved',
        'admin_reply',
        'admin_replied_at',
        'helpful_count',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_verified_buyer' => 'boolean',
        'is_approved' => 'boolean',
        'helpful_count' => 'integer',
        'admin_replied_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->created_at ? $this->created_at->translatedFormat('d M Y') : '';
    }
}
