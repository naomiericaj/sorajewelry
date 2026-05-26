@extends('layouts.app', ['title' => 'Order Detail - Sora Jewelry'])

@section('content')
<h1>Order Detail</h1>

<div style="background:white;padding:25px;">
    <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
    <p><strong>Order Status:</strong> {{ ucfirst($order->order_status) }}</p>
    <p><strong>Payment Status:</strong> {{ ucfirst($order->payment->payment_status ?? 'pending') }}</p>
    <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>

    <hr>

    @foreach($order->items as $item)
        <p>
            {{ $item->product_name }} x {{ $item->quantity }}<br>
            Rp {{ number_format($item->total, 0, ',', '.') }}
        </p>
    @endforeach

    <hr>

    <p><strong>Total:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>

    @if(($order->payment->payment_status ?? 'pending') === 'pending')
        <a href="{{ route('payment.show', $order) }}">
            <button>Pay Now</button>
        </a>
    @endif
</div>
@endsection