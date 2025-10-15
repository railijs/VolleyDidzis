<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'image', // either "news/foo.jpg" (uploaded) OR "https://..."
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        $img = $this->image;
        if (!$img) return null;

        // External URL? return as-is
        if (Str::startsWith($img, ['http://', 'https://', '//'])) {
            return $img;
        }

        // Local public-disk path → "/storage/..."
        return asset('storage/' . ltrim($img, '/'));
    }
}
