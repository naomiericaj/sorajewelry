@extends('layouts.app', ['title' => 'Admin Orders - Sora Jewelry'])

@section('content')
<h1>Admin Orders</h1>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

@if($errors->any())
    <p style="color:red;">{{ $errors->first() }}</p>
@endif

<table style="width:100%;background:white;border-collapse:collapse;">
    <tr>
        <th style="padding:12px;text-align:left;">Order</th>
        <th style="padding:12px;text-align:left;">Customer</th>
        <th style="padding:12px;text-align:left;">Total</th>
        <th style="padding:12px;text-align:left;">Order Status</th>
        <th style="padding:12px;text-align:left;">Payment</th>
        <th style="padding:12px;text-align:left;">Action</th>
    </tr>

    @foreach($orders as $order)
        <tr>
            <td style="padding:12px;">{{ $order->order_number }}</td>
            <td style="padding:12px;">{{ $order->user->name ?? '-' }}</td>
            <td style="padding:12px;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            <td style="padding:12px;">{{ ucfirst($order->order_status) }}</td>
            <td style="padding:12px;">{{ ucfirst($order->payment->payment_status ?? 'pending') }}</td>
            <td style="padding:12px;">
                <a href="{{ route('admin.orders.show', $order) }}">View</a>
            </td>
        </tr>
    @endforeach
</table>
@endsection