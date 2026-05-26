@extends('layouts.app', ['title' => 'Admin Orders - Sora Jewelry'])

@section('styles')
<style>
    .admin-orders-page {
        padding: 48px 38px 80px;
    }

    .title {
        font-family: Georgia, serif;
        font-size: 38px;
        font-weight: 400;
        margin-bottom: 30px;
    }

    .admin-actions {
        margin-bottom: 24px;
    }

    .admin-actions a {
        margin-right: 18px;
        text-decoration: underline;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    th,
    td {
        padding: 17px;
        border-bottom: 1px solid #e8e8e5;
        text-align: left;
        font-size: 14px;
    }

    th {
        background: #f1f1ee;
        font-weight: 500;
        color: #555;
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
    }

    @media (max-width: 900px) {
        table {
            display: block;
            overflow-x: auto;
        }
    }
</style>
@endsection

@section('content')

<section class="admin-orders-page">
    <h1 class="title">Admin Orders</h1>

    <div class="admin-actions">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.products.index') }}">Products</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Order</th>
                <th>Customer</th>
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
                    <td>{{ $order->user->name ?? '-' }}</td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                    <td>{{ $order->items->sum('quantity') }}</td>
                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td><span class="badge">{{ ucfirst($order->order_status) }}</span></td>
                    <td>
                        <span class="badge {{ $paymentClass }}">
                            {{ ucfirst($paymentStatus) }}
                        </span>
                    </td>
                    <td>
                        <a class="action-link" href="{{ route('admin.orders.show', $order) }}">Manage</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</section>

@endsection