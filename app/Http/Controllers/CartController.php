<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    /** Build the session key for the current viewer (guest or user) */
    private function cartKey(): string
    {
        return auth()->check() ? 'cart_user_'.auth()->id() : 'cart_guest';
    }

    /** Recalculate cart total */
    private function recompute(array $cart): array
    {
        $total = 0;
        foreach ($cart['items'] as $row) {
            $total += (float) $row['total'];
        }
        $cart['total'] = $total;
        return $cart;
    }

    public function index(Request $request)
    {
        $key  = $this->cartKey();
        $cart = $request->session()->get($key, ['items' => [], 'total' => 0]);

        $cart = $this->recompute($cart);

        // persist normalized cart (keeps numbers consistent)
        $request->session()->put($key, $cart);

        return view('frontend.cartview', compact('cart'));
    }


    // app/Http/Controllers/CartController.php

public function destroy(Request $request, $productId)
{
    $cartKey = auth()->check() ? 'cart_user_'.auth()->id() : 'cart_guest';
    $cart = $request->session()->get($cartKey, ['items'=>[], 'total'=>0]);

    if (isset($cart['items'][$productId])) {
        unset($cart['items'][$productId]);
    }

    // recompute total
    $total = 0;
    foreach ($cart['items'] as $row) {
        $total += (float)$row['total'];
    }
    $cart['total'] = $total;

    $request->session()->put($cartKey, $cart);

    return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
}


    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
            'qty'        => ['required','integer','min:1'],
        ]);

        $product = Product::findOrFail($data['product_id']);
        $qty     = (int) $data['qty'];

        $key  = $this->cartKey();
        $cart = $request->session()->get($key, ['items' => [], 'total' => 0]);

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

        $cart = $this->recompute($cart);
        $request->session()->put($key, $cart);

        return redirect()->route('cart.index')->with('success', 'Added to cart.');
    }
}
