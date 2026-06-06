@extends('layouts.app', ['title' => 'Admin Order Detail - Sora Jewelry'])

@section('styles')
<style>
    .admin-order-page {
        display: grid;
        grid-template-columns: 1fr 430px;
        min-height: calc(100vh - 70px);
    }

    .admin-left {
        padding: 48px 60px;
    }

    .admin-right {
        background: #a7ad98;
        color: white;
        padding: 48px 50px;
    }

    .title {
        font-family: Georgia, serif;
        font-size: 38px;
        font-weight: 400;
        margin-bottom: 28px;
    }

    .box {
        background: white;
        padding: 26px;
        margin-bottom: 22px;
    }

    .row {
        display: flex;
        justify-content: space-between;
        padding: 14px 0;
        border-bottom: 1px solid #eee;
        gap: 20px;
    }

    .row:last-child {
        border-bottom: none;
    }

    .badge {
        display: inline-block;
        padding: 7px 12px;
        border-radius: 30px;
        background: #efefed;
        font-size: 13px;
    }

    .btn {
        width: 100%;
        height: 54px;
        border: none;
        background: #111;
        color: white;
        cursor: pointer;
        margin-top: 14px;
    }

    .btn-outline {
        background: transparent;
        color: #111;
        border: 1px solid #111;
    }

    select {
        width: 100%;
        height: 54px;
        border: 1px solid #d8d8d4;
        background: transparent;
        padding: 0 14px;
        margin-top: 10px;
    }

    .summary-item {
        display: grid;
        grid-template-columns: 80px 1fr auto;
        gap: 16px;
        align-items: center;
        margin-bottom: 24px;
    }

    .summary-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        background: #eee;
        border-radius: 8px;
        border: 2px solid rgba(255,255,255,.6);
    }

    .summary-row,
    .summary-total {
        display: flex;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .summary-total {
        padding-top: 22px;
        margin-top: 22px;
        border-top: 1px solid rgba(255,255,255,.35);
        font-size: 24px;
        font-weight: 700;
    }

    @media (max-width: 900px) {
        .admin-order-page {
            grid-template-columns: 1fr;
        }

        .admin-left,
        .admin-right {
            padding: 32px 22px;
        }
    }
</style>
@endsection

@section('content')

<section class="admin-order-page">
    <div class="admin-left">
        <h1 class="title">Manage Order</h1>

        <div class="box">
            <div class="row">
                <span>Order Number</span>
                <strong>{{ $order->order_number }}</strong>
            </div>

            <div class="row">
                <span>Customer</span>
                <strong>{{ $order->user->name ?? '-' }}</strong>
            </div>

            <div class="row">
                <span>Email</span>
                <strong>{{ $order->user->email ?? '-' }}</strong>
            </div>

            <div class="row">
                <span>Payment Status</span>
                <strong><span class="badge">{{ ucfirst($order->payment->payment_status ?? 'pending') }}</span></strong>
            </div>

            <div class="row">
                <span>Order Status</span>
                <strong><span class="badge">{{ ucfirst($order->order_status) }}</span></strong>
            </div>

            <a href="{{ route('admin.orders.checkPayment', $order) }}">
                <button class="btn btn-outline">Check Payment from Midtrans</button>
            </a>
        </div>

        <div class="box">
            <h3>Shipping Details</h3>

            <div class="row">
                <span>Receiver</span>
                <strong>{{ $order->receiver_name }}</strong>
            </div>

            <div class="row">
                <span>Phone</span>
                <strong>{{ $order->receiver_phone }}</strong>
            </div>

            <div class="row">
                <span>Address</span>
                <strong style="text-align:right;">{{ $order->shipping_address }}</strong>
            </div>
        </div>

        <div class="box">
            <h3>Update Order Status</h3>

            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                @csrf
                @method('PATCH')

                <select name="order_status">
                    <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ $order->order_status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="completed" {{ $order->order_status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>

                <button type="submit" class="btn">Update Status</button>
            </form>
        </div>
    </div>

    <aside class="admin-right">
        @foreach($order->items as $item)
            @php
                $image = $item->product?->images?->where('is_main', 1)->first() ?? $item->product?->images?->first();
            @endphp

            <div class="summary-item">
                @if($image)
                    <img src="{{ asset('images/' . $image->image_path) }}" class="summary-img">
                @else
                    <img src="{{ asset('images/default-jewelry.jpg') }}" class="summary-img">
                @endif

                <div>
                    <div>{{ $item->product_name }}</div>
                    <div style="font-size:13px;opacity:.8;">Qty: {{ $item->quantity }}</div>
                </div>

                <div>Rp {{ number_format($item->total, 0, ',', '.') }}</div>
            </div>
        @endforeach

        <div class="summary-row">
            <span>Subtotal</span>
            <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
        </div>

        <div class="summary-row">
            <span>Shipping</span>
            <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
        </div>

        <div class="summary-total">
            <span>Total</span>
            <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
        </div>
    </aside>
</section>

@endsection