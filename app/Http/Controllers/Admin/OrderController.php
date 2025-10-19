<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::query()
            ->with(['user'])
            ->where('status', 'approved')
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = trim($request->get('q'));
                $q->where(function ($x) use ($term) {
                    $x->where('name', 'like', "%{$term}%")
                      ->orWhere('phone', 'like', "%{$term}%")
                      ->orWhere('address', 'like', "%{$term}%")
                      ->orWhere('payment_method', 'like', "%{$term}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->appends($request->only('q'));

        return view('admin.order.index', compact('orders'));
    }

    public function check(Request $request)
    {
        $allowed = ['pending', 'rejected'];
        $status  = $request->get('status');

        if (!in_array($status, $allowed, true)) {
            $status = 'pending';
        }

        $orders = Order::query()
            ->with(['user'])
            ->where('status', $status)
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = trim($request->get('q'));
                $q->where(function ($x) use ($term) {
                    $x->where('name', 'like', "%{$term}%")
                      ->orWhere('phone', 'like', "%{$term}%")
                      ->orWhere('address', 'like', "%{$term}%")
                      ->orWhere('payment_method', 'like', "%{$term}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->appends($request->only('q', 'status'));

        return view('admin.order.check', compact('orders', 'status'));
    }

    public function approve(Order $order)
    {
        if ($order->status !== 'approved') {
            $order->status = 'approved';
            $order->save();
        }

        return back()->with('success', 'Order approved.');
    }

    public function reject(Order $order)
    {
        if ($order->status !== 'rejected') {
            $order->status = 'rejected';
            $order->save();
        }

        return back()->with('success', 'Order rejected.');
    }

    public function downloadProof(Order $order)
    {
        if (!$order->payment_proof || !Storage::disk('public')->exists($order->payment_proof)) {
            abort(404, 'Proof not found.');
        }

        return Storage::disk('public')->download(
            $order->payment_proof,
            'payment_proof_' . $order->id . '.' . pathinfo($order->payment_proof, PATHINFO_EXTENSION)
        );
    }

    public function destroy(Order $order)
    {
        // Delete payment proof if exists
        if ($order->payment_proof && Storage::disk('public')->exists($order->payment_proof)) {
            Storage::disk('public')->delete($order->payment_proof);
        }

        $order->delete();

        return back()->with('success', 'Order deleted.');
    }
}