<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $productCount   = Product::count();
        $activeCount    = Product::where('is_active', true)->count();
        $outOfStock     = Product::where('stock', '<=', 0)->count();
        $lowStockCount  = Product::where('stock', '>', 0)->where('stock', '<=', 5)->count();

        return view('admin.dashboard', compact(
            'productCount',
            'activeCount',
            'outOfStock',
            'lowStockCount'
        ));
    }
}
