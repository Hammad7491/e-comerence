<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderHistoryController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::query()
            ->with([
                // keep the slim select for order items (these columns exist)
                'items:id,order_id,product_id,name,price,qty,total',

                // ❌ remove the column list that referenced a non-existent field
                // 'items.product:id,name,image,images',

                // ✅ just load the product relation with all columns
                'items.product',
            ])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('frontend.myorder', compact('orders'));
    }
}
