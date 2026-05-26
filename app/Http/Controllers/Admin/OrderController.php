<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Transaction;

class OrderController extends Controller
{
    private function checkAdmin()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
    }

    private function setupMidtrans()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function index()
    {
        $this->checkAdmin();

        $orders = Order::with(['user', 'payment', 'items'])
            ->latest()
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->checkAdmin();

        $order->load(['user', 'items.product.images', 'payment']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $this->checkAdmin();

        $request->validate([
            'order_status' => 'required|in:pending,processing,shipped,completed,cancelled',
        ]);

        $order->update([
            'order_status' => $request->order_status,
        ]);

        return back()->with('success', 'Order status updated successfully.');
    }

    public function checkPayment(Order $order)
    {
        $this->checkAdmin();

        try {
            $this->setupMidtrans();

            $status = Transaction::status($order->order_number);

            $transactionStatus = $status->transaction_status ?? null;
            $paymentType = $status->payment_type ?? null;
            $transactionId = $status->transaction_id ?? null;

            if ($transactionStatus === 'settlement' || $transactionStatus === 'capture') {
                $order->update([
                    'order_status' => 'processing',
                ]);

                $order->payment()->update([
                    'payment_method' => $paymentType,
                    'payment_status' => 'success',
                    'transaction_id' => $transactionId,
                    'payment_response' => json_decode(json_encode($status), true),
                    'paid_at' => now(),
                ]);
            } elseif ($transactionStatus === 'pending') {
                $order->payment()->update([
                    'payment_method' => $paymentType,
                    'payment_status' => 'pending',
                    'transaction_id' => $transactionId,
                    'payment_response' => json_decode(json_encode($status), true),
                ]);
            } elseif ($transactionStatus === 'expire') {
                $order->update([
                    'order_status' => 'cancelled',
                ]);

                $order->payment()->update([
                    'payment_status' => 'expired',
                    'payment_response' => json_decode(json_encode($status), true),
                ]);
            }

            return back()->with('success', 'Payment status checked from Midtrans.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'midtrans' => $e->getMessage(),
            ]);
        }
    }
}