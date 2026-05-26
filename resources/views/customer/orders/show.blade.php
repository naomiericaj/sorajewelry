@extends('layouts.app', ['title' => 'Order Detail - Sora Jewelry'])

@section('styles')
<style>
    .order-detail-page {
        display: grid;
        grid-template-columns: 1fr 430px;
        min-height: calc(100vh - 70px);
    }

    .order-left {
        padding: 48px 60px;
    }

    .order-right {
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

    .info-box {
        background: white;
        padding: 26px;
        margin-bottom: 22px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 14px 0;
        border-bottom: 1px solid #eee;
        gap: 20px;
    }

    .info-row:last-child {
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
        display: inline-block;
        width: 100%;
        height: 56px;
        background: #111;
        color: white;
        border: none;
        text-align: center;
        line-height: 56px;
        margin-top: 14px;
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
        .order-detail-page {
            grid-template-columns: 1fr;
        }

        .order-left,
        .order-right {
            padding: 32px 22px;
        }
    }
</style>
@endsection

@section('content')

<section class="order-detail-page">
    <div class="order-left">
        <h1 class="title">Order Detail</h1>

        <div class="info-box">
            <div class="info-row">
                <span>Order Number</span>
                <strong>{{ $order->order_number }}</strong>
            </div>

            <div class="info-row">
                <span>Order Date</span>
                <strong>{{ $order->created_at->format('d M Y, H:i') }}</strong>
            </div>

            <div class="info-row">
                <span>Order Status</span>
                <strong><span class="badge">{{ ucfirst($order->order_status) }}</span></strong>
            </div>

            <div class="info-row">
                <span>Payment Status</span>
                <strong><span class="badge">{{ ucfirst($order->payment->payment_status ?? 'pending') }}</span></strong>
            </div>
        </div>

        <div class="info-box">
            <h3>Shipping Details</h3>

            <div class="info-row">
                <span>Receiver</span>
                <strong>{{ $order->receiver_name }}</strong>
            </div>

            <div class="info-row">
                <span>Phone</span>
                <strong>{{ $order->receiver_phone }}</strong>
            </div>

            <div class="info-row">
                <span>Address</span>
                <strong style="text-align:right;">{{ $order->shipping_address }}</strong>
            </div>
        </div>

        @if(($order->payment->payment_status ?? 'pending') === 'pending')
            <a href="{{ route('payment.show', $order) }}" class="btn">Pay Now</a>
        @endif
    </div>

    <aside class="order-right">
        @foreach($order->items as $item)
            @php
                $image = $item->product?->images?->where('is_main', 1)->first() ?? $item->product?->images?->first();
            @endphp

            <div class="summary-item">
                @if($image)
                    <img src="{{ asset('storage/' . $image->image_path) }}" class="summary-img">
                @else
                    <img src="{{ asset('storage/products/default-jewelry.jpg') }}" class="summary-img">
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