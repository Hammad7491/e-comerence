<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Approved orders list (finalized orders).
     * Route: admin.orders.index
     */
    public function index(Request $request)
    {
        // Search & pagination for approved orders
        $orders = Order::query()
            ->with(['user'])                 // eager load customer
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

    /**
     * Moderation screen (Pending / Rejected by filter, pending by default).
     * Route: admin.orders.check
     */
    public function check(Request $request)
    {
        // allowed statuses for the moderation screen
        $allowed = ['pending', 'rejected'];
        $status  = $request->get('status');

        if (! in_array($status, $allowed, true)) {
            $status = 'pending'; // default
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

    /**
     * Approve a pending/rejected order.
     * Route: admin.orders.approve
     */
    public function approve(Order $order)
    {
        // no-op if already approved
        if ($order->status !== 'approved') {
            $order->status = 'approved';
            $order->save();
        }

        return back()->with('success', 'Order approved.');
    }


    public function downloadProof(\App\Models\Order $order)
{
    if (!$order->payment_proof || !\Storage::disk('public')->exists($order->payment_proof)) {
        abort(404, 'Proof not found.');
    }

    return response()->download(
        storage_path('app/public/'.$order->payment_proof),
        'payment_proof_'.$order->id.'.'.pathinfo($order->payment_proof, PATHINFO_EXTENSION)
    );
}


 public function destroy(Order $order)
    {
        // delete the proof file if present
        if ($order->payment_proof && Storage::disk('public')->exists($order->payment_proof)) {
            Storage::disk('public')->delete($order->payment_proof);
        }

        // if you have a relation for items, this cascade is typical:
        // $order->items()->delete(); // only if NOT using DB cascade

        $order->delete();

        return back()->with('success', 'Order deleted.');
    }

    /**
     * Reject a pending/approved order.
     * Route: admin.orders.reject
     */
    public function reject(Order $order)
    {
        if ($order->status !== 'rejected') {
            $order->status = 'rejected';
            $order->save();
        }

        return back()->with('success', 'Order rejected.');
    }
}
