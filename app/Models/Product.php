<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'series_name',
        'category',
        'subcategory',
        'author',
        'price',
        'original_price',
        'stock',
        'cover_image',
        'synopsis',
        'genre',
        'pages',
        'weight_grams',
        'dimensions',
        'publisher',
        'isbn',
        'collectors_items',
        'digital_file_type',
        'digital_file_url',
        'is_featured',
        'is_preorder',
        'order_index',
    ];

    protected $casts = [
        'collectors_items' => 'array',
        'is_featured' => 'boolean',
        'is_preorder' => 'boolean',
        'price' => 'integer',
        'original_price' => 'integer',
    ];

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedOriginalPriceAttribute(): ?string
    {
        return $this->original_price ? 'Rp ' . number_format($this->original_price, 0, ',', '.') : null;
    }
}
