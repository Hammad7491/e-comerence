<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', ['items' => [], 'total' => 0]);

        // recompute total
        $total = 0;
        foreach ($cart['items'] as $row) {
            $total += $row['total'];
        }
        $cart['total'] = $total;

        return view('frontend.cartview', compact('cart'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
            'qty'        => ['required','integer','min:1'],
        ]);

        $product = Product::findOrFail($data['product_id']);
        $qty     = (int) $data['qty'];

        $cart = $request->session()->get('cart', ['items' => [], 'total' => 0]);

        if (isset($cart['items'][$product->id])) {
            $cart['items'][$product->id]['qty']   += $qty;
            $cart['items'][$product->id]['total']  = (float)$product->final_price * $cart['items'][$product->id]['qty'];
        } else {
            $cart['items'][$product->id] = [
                'product_id' => $product->id,
                'name'       => $product->name,
                'price'      => (float)$product->final_price,
                'qty'        => $qty,
                'total'      => (float)$product->final_price * $qty,
                'image'      => $product->firstImageUrl(),
            ];
        }

        $total = 0;
        foreach ($cart['items'] as $row) {
            $total += $row['total'];
        }
        $cart['total'] = $total;

        $request->session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Added to cart.');
    }
}
