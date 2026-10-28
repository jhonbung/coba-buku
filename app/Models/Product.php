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
        'parent_id',
        'part_number',
        'author',
        'price',
        'original_price',
        'stock',
        'cover_image',
        'gallery_images',
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
        'gallery_images' => 'array',
        'is_featured' => 'boolean',
        'is_preorder' => 'boolean',
        'price' => 'integer',
        'original_price' => 'integer',
    ];

    public function getAllImagesAttribute(): array
    {
        $images = [];
        if (!empty($this->cover_image)) {
            $images[] = $this->cover_image;
        }
        if (!empty($this->gallery_images) && is_array($this->gallery_images)) {
            foreach ($this->gallery_images as $img) {
                if (!empty($img) && !in_array($img, $images)) {
                    $images[] = $img;
                }
            }
        }
        return !empty($images) ? $images : ['/images/mantra.svg'];
    }

    public function parent()
    {
        return $this->belongsTo(Product::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Product::class, 'parent_id');
    }

    public function ebookParts()
    {
        return $this->hasMany(Product::class, 'parent_id')
            ->where('category', 'ebook')
            ->orderByRaw('CASE WHEN part_number IS NULL THEN 999 ELSE part_number END ASC')
            ->orderBy('order_index');
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedOriginalPriceAttribute(): ?string
    {
        return $this->original_price ? 'Rp ' . number_format($this->original_price, 0, ',', '.') : null;
    }

    public function getBaseTitleAttribute(): string
    {
        $title = $this->title;
        if (preg_match('/(Mantra|Hierarchy|Fate|Serenity|Beauty in Madness)/i', $title, $matches)) {
            return ucfirst(strtolower($matches[1]));
        }
        $clean = preg_replace('/^(E-Book|Merchandise)\s+/i', '', $title);
        $clean = explode('—', $clean)[0];
        $clean = explode('(', $clean)[0];
        return trim($clean);
    }

    public function getSeriesGroupAttribute(): string
    {
        if ($this->subcategory === 'notonegoro' || str_contains($this->series_name ?? '', 'Notonegoro')) {
            return 'The Seven Notonegoro Series';
        }
        if ($this->subcategory === 'standalone' || str_contains($this->series_name ?? '', 'Standalone')) {
            return 'Standalone Novels';
        }
        if ($this->subcategory === 'limited' || str_contains($this->series_name ?? '', 'Limited')) {
            return 'Limited Editions & Boxsets';
        }
        return $this->series_name ?: 'Koleksi Lainnya';
    }

    public function getSeriesNumberAttribute(): ?string
    {
        if (preg_match('/Series\s+([IVXLCDM\d]+)/i', $this->series_name ?? '', $matches)) {
            return 'Seri ' . $matches[1];
        }
        $t = strtolower($this->title);
        if (str_contains($t, 'mantra')) return 'Seri I';
        if (str_contains($t, 'hierarchy')) return 'Seri II';
        if (str_contains($t, 'fate')) return 'Seri III';
        if (str_contains($t, 'serenity')) return 'Seri IV';
        return null;
    }

    public function getOtherEditionsAttribute()
    {
        $base = $this->base_title;
        return Product::where('id', '!=', $this->id)
            ->where(function ($q) use ($base) {
                $q->where('title', 'like', "%{$base}%")
                  ->orWhere('series_name', 'like', "%{$base}%");
            })
            ->orderBy('category')
            ->orderBy('order_index')
            ->get();
    }

    public function getAllPartsAttribute()
    {
        $target = $this->parent_id ? $this->parent : $this;
        if (!$target) return collect();
        return $target->ebookParts;
    }

    public function getSeriesSiblingsAttribute()
    {
        if ($this->series_group === 'The Seven Notonegoro Series') {
            return Product::where('category', 'novel')
                ->where('subcategory', 'notonegoro')
                ->orderBy('order_index')
                ->get();
        }
        return collect();
    }
}
