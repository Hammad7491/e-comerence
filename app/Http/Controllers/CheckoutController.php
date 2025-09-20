<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CheckoutController extends Controller
{
    public function create(Request $request)
    {
        $bank = [
            'title'    => 'Guley Threads',
            'account'  => '1234567890123',
            'provider' => 'Meezan Bank',
        ];

        $cartKey = 'cart_user_' . auth()->id();
        $cart    = $request->session()->get($cartKey, ['items' => [], 'total' => 0]);

        return view('frontend.checkout', compact('bank', 'cart'));
    }

    public function store(Request $request)
    {
        $userId  = auth()->id();
        $cartKey = 'cart_user_' . $userId;
        $cart    = $request->session()->get($cartKey, ['items' => [], 'total' => 0]);

        if (empty($cart['items'])) {
            return redirect()->route('cart.index')->with('success', 'Your cart is empty.');
        }

        $data = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'phone'          => ['required', 'string', 'max:50'],
            'address'        => ['required', 'string', 'max:2000'],
            'payment_method' => ['required', Rule::in(['cash', 'online'])],
            'payment_proof'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        // normalize strictly to 'cash' | 'online'
        $method = strtolower($data['payment_method']);
        if ($method === 'cod') { $method = 'cash'; } // just in case

        $proofPath = null;
        if ($method === 'online') {
            $request->validate([
                'payment_proof' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            ]);
            if ($request->hasFile('payment_proof')) {
                $proofPath = $request->file('payment_proof')->store('orders/proofs', 'public');
            }
        }

        $order = Order::create([
            'user_id'        => $userId,
            'name'           => $data['name'],
            'phone'          => $data['phone'],
            'address'        => $data['address'],
            'payment_method' => $method,      // 'cash' | 'online'
            'payment_proof'  => $proofPath,   // null for cash
            'total'          => (float)($cart['total'] ?? 0),
            'status'         => 'pending',
        ]);

        foreach ($cart['items'] as $row) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $row['product_id'] ?? null,
                'name'       => $row['name'] ?? '',
                'price'      => (float)($row['price'] ?? 0),
                'qty'        => (int)($row['qty'] ?? 1),
                'total'      => (float)($row['total'] ?? 0),
            ]);
        }

        $request->session()->forget($cartKey);

        return redirect()->route('home')->with('success', 'Order placed! We will review and update you soon.');
    }
}
