<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;
use Midtrans\Transaction;
use App\Mail\OrderReceiptMail;
use Illuminate\Support\Facades\Mail;

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

        $order->load(['items.product', 'payment', 'user']);

        if (!$order->payment) {
            return redirect()
                ->route('customer.orders.index')
                ->withErrors([
                    'payment' => 'Payment record was not found for this order.',
                ]);
        }

        if ($order->payment->payment_status === 'success') {
            return redirect()
                ->route('customer.orders.index')
                ->with('success', 'This order has already been paid.');
        }

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number . '-' . time(),
                'gross_amount' => (int) $order->total_amount,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->user->phone ?? '',
            ],
            'item_details' => $order->items->map(function ($item) {
                return [
                    'id' => (string) $item->product_id,
                    'price' => (int) $item->price,
                    'quantity' => (int) $item->quantity,
                    'name' => substr($item->product->name ?? 'Product', 0, 50),
                ];
            })->values()->toArray(),
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('payment.show', compact('order', 'snapToken'));
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

            // ✅ SEND RECEIPT EMAIL
            $this->sendReceiptEmail($order);

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

                // ✅ SEND RECEIPT EMAIL
                $this->sendReceiptEmail($order);

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

    public function finish(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $result = $request->input('result', []);

        $transactionStatus = $result['transaction_status'] ?? null;
        $paymentType = $result['payment_type'] ?? null;
        $transactionId = $result['transaction_id'] ?? null;

        $messageType = 'pending';

        if ($transactionStatus === 'settlement' || $transactionStatus === 'capture') {
            $order->update([
                'order_status' => 'processing',
            ]);

            $order->payment()->update([
                'payment_method' => $paymentType,
                'payment_status' => 'success',
                'transaction_id' => $transactionId,
                'payment_response' => $result,
                'paid_at' => now(),
            ]);

            // ✅ SEND RECEIPT EMAIL
            $this->sendReceiptEmail($order);

            $messageType = 'success';
        } elseif ($transactionStatus === 'pending') {
            $order->payment()->update([
                'payment_method' => $paymentType,
                'payment_status' => 'pending',
                'transaction_id' => $transactionId,
                'payment_response' => $result,
            ]);

            $messageType = 'pending';
        } elseif (
            $transactionStatus === 'deny' ||
            $transactionStatus === 'cancel' ||
            $transactionStatus === 'failure'
        ) {
            $order->payment()->update([
                'payment_method' => $paymentType,
                'payment_status' => 'failed',
                'transaction_id' => $transactionId,
                'payment_response' => $result,
            ]);

            $messageType = 'failed';
        } elseif ($transactionStatus === 'expire') {
            $order->update([
                'order_status' => 'cancelled',
            ]);

            $order->payment()->update([
                'payment_method' => $paymentType,
                'payment_status' => 'expired',
                'transaction_id' => $transactionId,
                'payment_response' => $result,
            ]);

            $messageType = 'expired';
        }

        return response()->json([
            'success' => true,
            'redirect_url' => route('customer.orders.index', [
                'payment' => $messageType,
                'order' => $order->order_number,
            ]),
        ]);
    }

    /**
     * Send order receipt email to customer
     */
    private function sendReceiptEmail(Order $order): void
    {
        try {
            Mail::to($order->user->email)->send(new OrderReceiptMail($order));
        } catch (\Exception $e) {
            // Log error but don't fail the order
            \Log::error('Failed to send receipt email for order ' . $order->order_number . ': ' . $e->getMessage());
        }
    }
}