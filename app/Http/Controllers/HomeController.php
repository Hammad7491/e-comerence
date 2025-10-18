<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // only allow 'popular' or 'new'
        $tab = request()->get('tab', 'popular');
        $tab = in_array($tab, ['popular', 'new'], true) ? $tab : 'popular';

        // Base query for active products
        $base = Product::query()
            ->where('is_active', true)
            ->latest('id');

        // Popular: newest active products
        $popularProducts = (clone $base)
            ->take(12)
            ->get();

        // New Arrivals: created within last 30 days
        $newArrivals = (clone $base)
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->take(12)
            ->get();

        return view('frontend.home', compact('tab', 'popularProducts', 'newArrivals'));
    }
}
