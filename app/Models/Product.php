<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'images',          // JSON (array of relative paths)
        'original_price',
        'final_price',
        'stock',
        'is_active',
    ];

    protected $casts = [
        'images'         => 'array',     // json <-> array
        'original_price' => 'decimal:2',
        'final_price'    => 'decimal:2',
        'is_active'      => 'boolean',
    ];

    // Default JSON so it's never null at DB/read time
    protected $attributes = [
        'images' => '[]',
    ];

    /**
     * Always return an array for images (never null).
     */
    public function getImagesAttribute($value): array
    {
        if (is_array($value)) return $value;
        if (is_string($value) && $value !== '') {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        return [];
    }

    /**
     * First image absolute URL (or null).
     */
    public function firstImageUrl(): ?string
    {
        $first = $this->images[0] ?? null;
        return $first ? Storage::disk('public')->url($first) : null;
    }

    /**
     * Up to $limit absolute URLs of images (default 3).
     */
    public function imageUrls(int $limit = 3): array
    {
        return collect($this->images)
            ->take($limit)
            ->map(fn ($rel) => Storage::disk('public')->url($rel))
            ->all();
    }
}
