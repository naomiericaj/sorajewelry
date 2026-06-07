<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['payment', 'items'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('customer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ((int) $order->user_id !== (int) Auth::id()) {
    \Log::warning('Customer order view forbidden', [
        'order_id' => $order->id,
        'order_user_id' => $order->user_id,
        'auth_id' => Auth::id(),
    ]);

    abort(403);
}

        $order->load(['items.product.images', 'payment']);

        return view('customer.orders.show', compact('order'));
    }
}