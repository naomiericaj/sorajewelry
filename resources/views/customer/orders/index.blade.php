@extends('layouts.app', ['title' => 'My Orders - Sora Jewelry'])

@section('content')
<h1>My Orders</h1>

@if($orders->isEmpty())
    <p>You have no orders yet.</p>
@else
    <table style="width:100%;background:white;border-collapse:collapse;">
        <tr>
            <th style="padding:12px;text-align:left;">Order Number</th>
            <th style="padding:12px;text-align:left;">Total</th>
            <th style="padding:12px;text-align:left;">Order Status</th>
            <th style="padding:12px;text-align:left;">Payment</th>
            <th style="padding:12px;text-align:left;">Action</th>
        </tr>

        @foreach($orders as $order)
            <tr>
                <td style="padding:12px;">{{ $order->order_number }}</td>
                <td style="padding:12px;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td style="padding:12px;">{{ ucfirst($order->order_status) }}</td>
                <td style="padding:12px;">{{ ucfirst($order->payment->payment_status ?? 'pending') }}</td>
                <td style="padding:12px;">
                    <a href="{{ route('customer.orders.show', $order) }}">View</a>

                    @if(($order->payment->payment_status ?? 'pending') === 'pending')
                        |
                        <a href="{{ route('payment.show', $order) }}">Pay</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
@endif
@endsection