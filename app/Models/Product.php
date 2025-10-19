<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'images', 'original_price', 'final_price',
        'stock', 'is_active', 'pieces', 'collection',
    ];

    protected $casts = [
        'images'         => 'array',
        'original_price' => 'decimal:2',
        'final_price'    => 'decimal:2',
        'is_active'      => 'boolean',
    ];

    protected $attributes = [
        'images' => '[]'
    ];

    /**
     * Get first image URL
     */
    public function firstImageUrl(): string
    {
        $images = $this->images;
        
        if (empty($images) || !isset($images[0])) {
            return asset('images/placeholder.jpg');
        }

        return asset($images[0]);
    }

    /**
     * Get all image URLs
     */
    public function imageUrls(): array
    {
        if (empty($this->images)) {
            return [asset('images/placeholder.jpg')];
        }

        return array_map(function($path) {
            return asset($path);
        }, $this->images);
    }
}