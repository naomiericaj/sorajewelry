@extends('layouts.app', ['title' => 'My Orders - Sora Jewelry'])

@section('styles')
<style>
    .orders-page {
        padding: 48px 38px 80px;
    }

    .orders-header {
        display: flex;
        justify-content: space-between;
        align-items: end;
        margin-bottom: 35px;
    }

    .orders-title {
        font-family: Georgia, serif;
        font-size: 38px;
        font-weight: 400;
        margin: 0;
    }

    .orders-subtitle {
        color: #666;
        margin-top: 8px;
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    .orders-table th,
    .orders-table td {
        padding: 18px;
        border-bottom: 1px solid #e8e8e5;
        text-align: left;
        font-size: 14px;
    }

    .orders-table th {
        font-weight: 500;
        color: #555;
        background: #f1f1ee;
    }

    .badge {
        display: inline-block;
        padding: 7px 12px;
        border-radius: 30px;
        background: #efefed;
        font-size: 13px;
    }

    .badge-success {
        background: #d9ead3;
        color: #2f5d31;
    }

    .badge-pending {
        background: #fff2cc;
        color: #7a5a00;
    }

    .badge-failed {
        background: #f4cccc;
        color: #8b0000;
    }

    .action-link {
        text-decoration: underline;
        margin-right: 12px;
    }

    .empty {
        background: white;
        padding: 40px;
        color: #666;
    }

    @media (max-width: 800px) {
        .orders-table {
            display: block;
            overflow-x: auto;
        }
    }

    .pay-now-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    height: 42px;
    padding: 0 18px;
    background: #111;
    color: white;
    text-decoration: none;
    font-size: 14px;
    border: 1px solid #111;
}

.pay-now-btn:hover {
    background: transparent;
    color: #111;
}
</style>
@endsection

@section('content')

<section class="orders-page">
    <div class="orders-header">
        <div>
            <h1 class="orders-title">My Orders</h1>
            <div class="orders-subtitle">Track your orders and payment status.</div>
        </div>
    </div>

    @if(request('payment') === 'success')
    <div class="payment-alert success">
        Payment successful for order {{ request('order') }}. Your order is now being processed.
    </div>
@elseif(request('payment') === 'pending')
    <div class="payment-alert pending">
        Payment for order {{ request('order') }} is still pending. Please complete the payment if needed.
    </div>
@elseif(request('payment') === 'failed')
    <div class="payment-alert failed">
        Payment failed for order {{ request('order') }}. Please try again.
    </div>
@elseif(request('payment') === 'expired')
    <div class="payment-alert failed">
        Payment expired for order {{ request('order') }}.
    </div>
@elseif(request('payment') === 'closed')
    <div class="payment-alert pending">
        Payment popup was closed before completion for order {{ request('order') }}.
    </div>
@elseif(request('payment') === 'error')
    <div class="payment-alert failed">
        Payment result could not be saved. Please contact admin.
    </div>
@endif

    @if($orders->isEmpty())
        <div class="empty">
            You have no orders yet.
        </div>
    @else
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Date</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Order Status</th>
                    <th>Payment</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($orders as $order)
                    @php
                        $paymentStatus = $order->payment->payment_status ?? 'pending';

                        $paymentClass = 'badge-pending';

                        if ($paymentStatus === 'success') {
                            $paymentClass = 'badge-success';
                        } elseif (in_array($paymentStatus, ['failed', 'expired'])) {
                            $paymentClass = 'badge-failed';
                        }
                    @endphp

                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>{{ $order->items->sum('quantity') }}</td>
                        <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge">{{ ucfirst($order->order_status) }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $paymentClass }}">
                                {{ ucfirst($paymentStatus) }}
                            </span>
                        </td>
                        <td>
                            <a class="action-link" href="{{ route('customer.orders.show', $order) }}">View</a>

                            @if($paymentStatus === 'pending')
                                <a class="action-link" href="{{ route('payment.show', $order) }}">Pay</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</section>

@endsection