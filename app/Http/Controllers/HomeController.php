<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $tab = request()->get('tab', 'popular'); // 'popular' | 'new'

        // Popular: newest active products
        $popularProducts = Product::query()
            ->where('is_active', true)
            ->latest('id')
            ->take(12)
            ->get();

        // New Arrivals: created within last 30 days (auto rotates out)
        $newArrivals = Product::query()
            ->where('is_active', true)
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->latest('id')
            ->take(12)
            ->get();

        return view('frontend.home', compact('tab', 'popularProducts', 'newArrivals'));
    }
}
