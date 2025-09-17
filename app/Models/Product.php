<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // ← add this

class Product extends Model
{
    protected $fillable = [
        'name','description','images','original_price','final_price',
        'stock','is_active','pieces','collection',
    ];

    protected $casts = [
        'images'         => 'array',
        'original_price' => 'decimal:2',
        'final_price'    => 'decimal:2',
        'is_active'      => 'boolean',
    ];

    protected $attributes = ['images' => '[]'];

    // optional: you can keep your accessor; 'casts' already handles arrays
    public function getImagesAttribute($value): array
    {
        if (is_array($value)) return $value;
        if (is_string($value) && $value !== '') {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        return [];
    }

    public function firstImageUrl(): ?string
    {
        $first = $this->images[0] ?? null;
        if (!$first) return null;

        // absolute or already-public path
        if (Str::startsWith($first, ['http://','https://','/'])) {
            return $first;
        }

        // public disk file (requires storage:link)
        return Storage::disk('public')->exists($first)
            ? Storage::disk('public')->url($first)
            : null;
    }

    public function imageUrls(int $limit = 3): array
    {
        return collect($this->images)
            ->take($limit)
            ->map(function ($rel) {
                if (Str::startsWith($rel, ['http://','https://','/'])) return $rel;
                return Storage::disk('public')->exists($rel)
                    ? Storage::disk('public')->url($rel)
                    : null;
            })
            ->filter()
            ->values()
            ->all();
    }
}
