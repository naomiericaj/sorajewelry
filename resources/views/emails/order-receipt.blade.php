<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt - SORA Jewelry</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: #3D3D3D;
            background-color: #FAFAF8;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #FFFFFF;
            padding: 40px;
            border: 1px solid #E5E5E5;
            border-radius: 4px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #E8DDD2;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 2px;
            color: #3D3D3D;
            text-decoration: none;
        }
        .success-badge {
            display: inline-block;
            background-color: #C4B5A8;
            color: #FFFFFF;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            margin-top: 10px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #3D3D3D;
            margin-bottom: 15px;
            border-bottom: 1px solid #E5E5E5;
            padding-bottom: 10px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #F5F3F0;
        }
        .info-label {
            color: #8A8A8A;
            font-weight: 600;
        }
        .info-value {
            color: #3D3D3D;
            font-weight: 500;
        }
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .product-table th {
            background-color: #F5F3F0;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #3D3D3D;
            border-bottom: 2px solid #E8DDD2;
        }
        .product-table td {
            padding: 12px;
            border-bottom: 1px solid #F5F3F0;
            color: #3D3D3D;
        }
        .product-table tr:last-child td {
            border-bottom: none;
        }
        .total-section {
            background-color: #F5F3F0;
            padding: 20px;
            border-radius: 4px;
            margin-top: 20px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .total-row.final {
            font-size: 18px;
            font-weight: bold;
            border-top: 2px solid #E8DDD2;
            padding-top: 10px;
            color: #3D3D3D;
        }
        .shipping-info {
            background-color: #F0EDE8;
            padding: 15px;
            border-left: 4px solid #D4A574;
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #E5E5E5;
            color: #8A8A8A;
            font-size: 12px;
        }
        .footer a {
            color: #D4A574;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .thank-you {
            font-size: 16px;
            color: #3D3D3D;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            background-color: #3D3D3D;
            color: #FFFFFF;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            font-weight: 600;
        }
        .button:hover {
            background-color: #4A4A4A;
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- Header --}}
        <div class="header">
            <div class="logo">SORA</div>
            <div class="success-badge">✓ Payment Successful</div>
        </div>

        {{-- Thank You Message --}}
        <div class="thank-you">
            <p>Dear {{ $user->name }},</p>
            <p>Thank you for your order! We're delighted to have you as a SORA Jewelry customer. Your payment has been received and your order is now being processed.</p>
        </div>

        {{-- Order Details --}}
        <div class="section">
            <div class="section-title">Order Information</div>
            <div class="info-row">
                <span class="info-label">Order Number:</span>
                <span class="info-value">{{ $order->order_number }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Order Date:</span>
                <span class="info-value">{{ $order->created_at->format('d M Y, H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Order Status:</span>
                <span class="info-value">{{ ucfirst($order->order_status) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Payment Status:</span>
                <span class="info-value">{{ ucfirst($payment->payment_status) }}</span>
            </div>
        </div>

        {{-- Items Ordered --}}
        <div class="section">
            <div class="section-title">Items Ordered</div>
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: right;">Price</th>
                        <th style="text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td>{{ $item->product->name ?? 'Product' }}</td>
                            <td style="text-align: center;">{{ $item->quantity }}</td>
                            <td style="text-align: right;">Rp {{ number_format($item->price) }}</td>
                            <td style="text-align: right;">Rp {{ number_format($item->price * $item->quantity) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: #8A8A8A;">No items in this order</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Order Summary --}}
        <div class="total-section">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($order->subtotal) }}</span>
            </div>
            <div class="total-row">
                <span>Shipping:</span>
                <span>Rp {{ number_format($order->shipping_cost) }}</span>
            </div>
            <div class="total-row final">
                <span>Total:</span>
                <span>Rp {{ number_format($order->total_price) }}</span>
            </div>
        </div>

        {{-- Shipping Details --}}
        <div class="section">
            <div class="section-title">Shipping Details</div>
            <div class="shipping-info">
                <div class="info-row" style="border-bottom: none;">
                    <span class="info-label">Recipient:</span>
                    <span class="info-value">{{ $order->receiver_name }}</span>
                </div>
                <div class="info-row" style="border-bottom: none;">
                    <span class="info-label">Phone:</span>
                    <span class="info-value">{{ $order->receiver_phone }}</span>
                </div>
                <div class="info-row" style="border-bottom: none;">
                    <span class="info-label">Address:</span>
                    <span class="info-value">{{ $order->shipping_address }}</span>
                </div>
            </div>
        </div>

        {{-- Payment Method --}}
        @if($payment)
            <div class="section">
                <div class="section-title">Payment Information</div>
                <div class="info-row">
                    <span class="info-label">Payment Method:</span>
                    <span class="info-value">{{ ucfirst(str_replace('_', ' ', $payment->payment_method ?? 'N/A')) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Transaction ID:</span>
                    <span class="info-value">{{ $payment->transaction_id ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Paid At:</span>
                    <span class="info-value">{{ $payment->paid_at ? $payment->paid_at->format('d M Y, H:i') : 'Pending' }}</span>
                </div>
            </div>
        @endif

        {{-- Call to Action --}}
        <div style="text-align: center; margin-top: 30px;">
            <p style="color: #8A8A8A; margin-bottom: 15px;">
                You can track your order status anytime from your account dashboard.
            </p>
            <a href="{{ route('customer.orders.show', $order->id) }}" class="button">
                View Order Details
            </a>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <p>If you have any questions about your order, please don't hesitate to <a href="mailto:{{ config('mail.from.address') }}">contact us</a>.</p>
            <p style="margin-top: 15px;">
                <strong>SORA Jewelry</strong> | Minimal jewelry pieces for everyday elegance<br>
                <a href="{{ config('app.url') }}">{{ config('app.url') }}</a>
            </p>
            <p style="margin-top: 15px; color: #C0C0C0;">
                © {{ now()->year }} SORA Jewelry. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>