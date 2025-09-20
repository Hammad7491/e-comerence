<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'name', 'price', 'qty', 'total',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // ✅ This is the relationship your view/controller expect
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
