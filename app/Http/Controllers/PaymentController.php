<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;
use Midtrans\Transaction;

class PaymentController extends Controller
{
    private function setupMidtrans(): void
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['items', 'payment', 'user']);

        $snapToken = null;
        $midtransError = null;

        try {
            $this->setupMidtrans();

            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_number,
                    'gross_amount' => (int) $order->total_price,
                ],
                'customer_details' => [
                    'first_name' => $order->receiver_name,
                    'email' => $order->user->email,
                    'phone' => $order->receiver_phone,
                    'shipping_address' => [
                        'first_name' => $order->receiver_name,
                        'phone' => $order->receiver_phone,
                        'address' => $order->shipping_address,
                    ],
                ],
                'enabled_payments' => [
                    'gopay',
                    'qris',
                    'bank_transfer',
                ],
            ];

            $snapToken = Snap::getSnapToken($params);
        } catch (\Exception $e) {
            $midtransError = $e->getMessage();
        }

        return view('payment.show', compact('order', 'snapToken', 'midtransError'));
    }

    public function notification(Request $request)
    {
        $this->setupMidtrans();

        $notification = new Notification();

        $orderNumber = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $paymentType = $notification->payment_type;
        $transactionId = $notification->transaction_id ?? null;

        $order = Order::where('order_number', $orderNumber)->first();

        if (!$order) {
            return response()->json([
                'message' => 'Order not found',
            ], 404);
        }

        if ($transactionStatus === 'settlement' || $transactionStatus === 'capture') {
            $order->update([
                'order_status' => 'processing',
            ]);

            $order->payment()->update([
                'payment_method' => $paymentType,
                'payment_status' => 'success',
                'transaction_id' => $transactionId,
                'payment_response' => $request->all(),
                'paid_at' => now(),
            ]);
        } elseif ($transactionStatus === 'pending') {
            $order->payment()->update([
                'payment_method' => $paymentType,
                'payment_status' => 'pending',
                'transaction_id' => $transactionId,
                'payment_response' => $request->all(),
            ]);
        } elseif ($transactionStatus === 'expire') {
            $order->update([
                'order_status' => 'cancelled',
            ]);

            $order->payment()->update([
                'payment_method' => $paymentType,
                'payment_status' => 'expired',
                'transaction_id' => $transactionId,
                'payment_response' => $request->all(),
            ]);
        } elseif ($transactionStatus === 'cancel' || $transactionStatus === 'deny') {
            $order->update([
                'order_status' => 'cancelled',
            ]);

            $order->payment()->update([
                'payment_method' => $paymentType,
                'payment_status' => 'failed',
                'transaction_id' => $transactionId,
                'payment_response' => $request->all(),
            ]);
        }

        return response()->json([
            'message' => 'Notification handled',
        ]);
    }

    public function checkStatus(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

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

            return back()->with('success', 'Payment status checked.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'midtrans' => $e->getMessage(),
            ]);
        }
    }
}