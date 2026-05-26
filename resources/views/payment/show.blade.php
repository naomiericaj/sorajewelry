@extends('layouts.app', ['title' => 'Payment - Sora Jewelry'])

@section('styles')
<style>
    .payment-page {
        display: grid;
        grid-template-columns: 54% 46%;
        min-height: calc(100vh - 70px);
    }

    .payment-left {
        padding: 56px 70px;
        background: #f8f8f6;
    }

    .payment-right {
        background: #a7ad98;
        color: white;
        padding: 56px 70px;
    }

    .payment-logo {
        font-family: Georgia, serif;
        font-style: italic;
        font-size: 34px;
        text-align: center;
        margin-bottom: 45px;
    }

    .payment-box {
        max-width: 620px;
        margin: 0 auto;
    }

    .title {
        font-family: Georgia, serif;
        font-size: 32px;
        margin-bottom: 20px;
    }

    .payment-status {
        display: inline-block;
        padding: 8px 14px;
        background: #efefed;
        margin-bottom: 24px;
        border-radius: 30px;
        font-size: 14px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 16px 0;
        border-bottom: 1px solid #e1e1dd;
    }

    .pay-btn {
        width: 100%;
        height: 58px;
        border: none;
        background: black;
        color: white;
        font-size: 15px;
        margin-top: 28px;
        cursor: pointer;
    }

    .secondary-btn {
        width: 100%;
        height: 54px;
        border: 1px solid #111;
        background: transparent;
        color: #111;
        font-size: 15px;
        margin-top: 12px;
        cursor: pointer;
    }

    .note {
        margin-top: 24px;
        background: #efefed;
        padding: 20px;
        color: #555;
        line-height: 1.7;
        font-size: 14px;
    }

    .error {
        color: #8b0000;
        background: #f8d7da;
        padding: 14px;
        margin-top: 20px;
    }

    .summary-item {
        display: grid;
        grid-template-columns: 75px 1fr auto;
        gap: 16px;
        align-items: center;
        margin-bottom: 26px;
    }

    .summary-img-wrap {
        position: relative;
    }

    .summary-img {
        width: 75px;
        height: 75px;
        object-fit: cover;
        background: #eee;
        border: 2px solid rgba(255,255,255,.75);
        border-radius: 10px;
    }

    .summary-qty {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #777;
        color: white;
        width: 23px;
        height: 23px;
        border-radius: 50%;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid rgba(255,255,255,.35);
    }

    .summary-total strong {
        font-size: 28px;
    }

    @media (max-width: 950px) {
        .payment-page {
            grid-template-columns: 1fr;
        }

        .payment-left,
        .payment-right {
            padding: 32px 22px;
        }
    }
</style>
@endsection

@section('content')

<section class="payment-page">
    <div class="payment-left">
        <div class="payment-logo">Sora</div>

        <div class="payment-box">
            <h1 class="title">Complete Payment</h1>

            <div class="payment-status">
                Payment Status: {{ ucfirst($order->payment->payment_status ?? 'pending') }}
            </div>

            <div class="detail-row">
                <span>Order Number</span>
                <strong>{{ $order->order_number }}</strong>
            </div>

            <div class="detail-row">
                <span>Receiver</span>
                <strong>{{ $order->receiver_name }}</strong>
            </div>

            <div class="detail-row">
                <span>Shipping Address</span>
                <strong style="text-align:right;">{{ $order->shipping_address }}</strong>
            </div>

            <div class="detail-row">
                <span>Total</span>
                <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
            </div>

            @if($snapToken)
                <button id="pay-button" class="pay-btn">
                    Show QR / Pay with Midtrans
                </button>

                <a href="{{ route('payment.check', $order) }}">
                    <button class="secondary-btn">
                        Check Payment Status
                    </button>
                </a>

                <div class="note">
                    <strong>Payment simulation steps:</strong><br>
                    1. Click “Show QR / Pay with Midtrans”.<br>
                    2. Choose QRIS or GoPay in the Midtrans popup.<br>
                    3. Midtrans will show a QR/payment screen.<br>
                    4. Complete the simulation through Midtrans Sandbox.<br>
                    5. Click “Check Payment Status” to update your local database.
                </div>
            @else
                <div class="error">
                    Midtrans Snap token is not available.

                    @if($midtransError)
                        <br><br>
                        <strong>Error:</strong> {{ $midtransError }}
                    @endif
                </div>
            @endif
        </div>
    </div>

    <aside class="payment-right">
        @foreach($order->items as $item)
            @php
                $image = $item->product?->images?->where('is_main', 1)->first() ?? $item->product?->images?->first();
            @endphp

            <div class="summary-item">
                <div class="summary-img-wrap">
                    @if($image)
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="summary-img">
                    @else
                        <img src="{{ asset('storage/products/default-jewelry.jpg') }}" class="summary-img">
                    @endif

                    <span class="summary-qty">{{ $item->quantity }}</span>
                </div>

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
            <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
        </div>
    </aside>
</section>

@if($snapToken)
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        document.getElementById('pay-button').onclick = function () {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    alert('Payment success. Click Check Payment Status to update the order.');
                    console.log(result);
                },
                onPending: function(result) {
                    alert('Payment pending. Complete the simulation in Midtrans Sandbox.');
                    console.log(result);
                },
                onError: function(result) {
                    alert('Payment failed.');
                    console.log(result);
                },
                onClose: function() {
                    alert('Payment popup closed.');
                }
            });
        };
    </script>
@endif

@endsection