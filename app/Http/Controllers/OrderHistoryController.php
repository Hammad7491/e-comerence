<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderHistoryController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['items'])   // assumes relation items() in Order model
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('frontend.myorder', compact('orders'));
    }
}
