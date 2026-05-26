@extends('layouts.app', ['title' => 'Admin Order Detail - Sora Jewelry'])

@section('content')
<h1>Admin Order Detail</h1>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

@if($errors->any())
    <p style="color:red;">{{ $errors->first() }}</p>
@endif

<div style="background:white;padding:25px;">
    <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
    <p><strong>Customer:</strong> {{ $order->user->name ?? '-' }}</p>
    <p><strong>Email:</strong> {{ $order->user->email ?? '-' }}</p>
    <p><strong>Receiver:</strong> {{ $order->receiver_name }}</p>
    <p><strong>Phone:</strong> {{ $order->receiver_phone }}</p>
    <p><strong>Address:</strong> {{ $order->shipping_address }}</p>

    <p><strong>Order Status:</strong> {{ ucfirst($order->order_status) }}</p>
    <p><strong>Payment Status:</strong> {{ ucfirst($order->payment->payment_status ?? 'pending') }}</p>

    <hr>

    <h3>Items</h3>

    @foreach($order->items as $item)
        <p>
            {{ $item->product_name }} x {{ $item->quantity }}<br>
            Rp {{ number_format($item->total, 0, ',', '.') }}
        </p>
    @endforeach

    <hr>

    <h3>Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</h3>

    <a href="{{ route('admin.orders.checkPayment', $order) }}">
        <button>Check Payment from Midtrans</button>
    </a>

    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" style="margin-top:20px;">
        @csrf
        @method('PATCH')

        <label>Update Order Status</label>
        <select name="order_status">
            <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>Processing</option>
            <option value="shipped" {{ $order->order_status === 'shipped' ? 'selected' : '' }}>Shipped</option>
            <option value="completed" {{ $order->order_status === 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>

        <button type="submit">Update</button>
    </form>
</div>
@endsection