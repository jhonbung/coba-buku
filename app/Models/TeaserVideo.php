<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeaserVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'tagline',
        'subtitle',
        'video_type',
        'video_path',
        'youtube_url',
        'thumbnail_path',
        'badge_1',
        'badge_2',
        'badge_3',
        'cta_text',
        'cta_link',
        'is_active',
        'order_index',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get clean YouTube Embed URL if video_type is youtube
     */
    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        if (empty($this->youtube_url)) {
            return null;
        }

        $url = trim($this->youtube_url);

        // Already embed URL
        if (str_contains($url, 'youtube.com/embed/')) {
            return $url;
        }

        // youtu.be/<id>
        if (preg_match('/youtu\.be\/([a-zA-Z0-9_\-]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1] . '?rel=0&modestbranding=1';
        }

        // youtube.com/watch?v=<id>
        if (preg_match('/[?&]v=([a-zA-Z0-9_\-]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1] . '?rel=0&modestbranding=1';
        }

        // youtube.com/shorts/<id>
        if (preg_match('/youtube\.com\/shorts\/([a-zA-Z0-9_\-]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1] . '?rel=0&modestbranding=1';
        }

        return $url;
    }
}

