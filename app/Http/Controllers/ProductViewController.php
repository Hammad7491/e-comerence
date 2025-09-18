<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductViewController extends Controller
{
    public function show(Product $product)
    {
        // Uses route-model binding: /product/{product}
        return view('frontend.productview', compact('product'));
    }
}
