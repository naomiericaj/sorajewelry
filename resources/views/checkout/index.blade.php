@extends('layouts.app', ['title' => 'Checkout - Sora Jewelry'])

@section('styles')
<style>
    .checkout-page {
        display: grid;
        grid-template-columns: 54% 46%;
        min-height: calc(100vh - 70px);
    }

    .checkout-form-side {
        background: #f8f8f6;
        padding: 48px 70px;
    }

    .checkout-summary-side {
        background: #a7ad98;
        color: white;
        padding: 48px 70px;
    }

    .checkout-logo {
        font-family: Georgia, serif;
        font-style: italic;
        font-size: 34px;
        text-align: center;
        margin-bottom: 42px;
    }

    .section-title {
        font-family: Georgia, serif;
        font-size: 28px;
        font-weight: 700;
        margin: 30px 0 16px;
    }

    .input {
        width: 100%;
        height: 58px;
        border: 1px solid #d8d8d4;
        background: transparent;
        padding: 0 16px;
        font-size: 15px;
        margin-bottom: 14px;
        border-radius: 6px;
    }

    .textarea {
        width: 100%;
        height: 96px;
        border: 1px solid #d8d8d4;
        background: transparent;
        padding: 16px;
        font-size: 15px;
        margin-bottom: 14px;
        border-radius: 6px;
        resize: vertical;
    }

    .two-col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .shipping-placeholder {
        background: #efefed;
        color: #666;
        text-align: center;
        padding: 22px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    .payment-note {
        color: #555;
        line-height: 1.6;
        margin-bottom: 16px;
    }

    .place-order-btn {
        width: 100%;
        height: 58px;
        border: none;
        background: black;
        color: white;
        font-size: 15px;
        cursor: pointer;
        margin-top: 16px;
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

    .summary-name {
        font-size: 16px;
        margin-bottom: 4px;
    }

    .summary-meta {
        font-size: 13px;
        opacity: .8;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 16px;
        font-size: 16px;
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
        .checkout-page {
            grid-template-columns: 1fr;
        }

        .checkout-form-side,
        .checkout-summary-side {
            padding: 32px 22px;
        }

        .two-col {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

<section class="checkout-page">
    <div class="checkout-form-side">
        <div class="checkout-logo">Sora</div>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf

            <h2 class="section-title">Contact</h2>
            <input class="input" type="email" placeholder="Email or mobile phone number" value="{{ Auth::user()->email }}" disabled>

            <h2 class="section-title">Delivery</h2>

            <select class="input" name="country" disabled>
                <option>Indonesia</option>
            </select>

            <div class="two-col">
                <input class="input" type="text" name="receiver_name" value="{{ old('receiver_name') }}" placeholder="First name / Receiver name" required>
                <input class="input" type="text" name="receiver_phone" value="{{ old('receiver_phone') }}" placeholder="Phone number" required>
            </div>

            <textarea class="textarea" name="shipping_address" placeholder="Address" required>{{ old('shipping_address') }}</textarea>

            <div class="two-col">
                <input class="input" type="text" name="city" placeholder="City">
                <input class="input" type="text" name="postal_code" placeholder="Postal code">
            </div>

            <select class="input" name="province">
                <option value="">Province</option>
                <option>East Java</option>
                <option>West Java</option>
                <option>Central Java</option>
                <option>Jakarta</option>
                <option>Bali</option>
            </select>

            <h2 class="section-title">Shipping method</h2>
            <div class="shipping-placeholder">
                Standard shipping will be calculated at checkout.
            </div>

            <h2 class="section-title">Discount Code</h2>

            <input  
                class="input"
                 type="text"
                name="discount_code"
                 placeholder="Enter your voucher code">
                 @error('discount_code')
    <p style="
        color:#dc2626;
        margin-top:-8px;
        margin-bottom:15px;
        font-size:14px;
    ">
        {{ $message }}
    </p>
@enderror

            <h2 class="section-title">Payment</h2>

            <p class="payment-note">
                After placing your order, you will be redirected to Midtrans payment. Choose QRIS or GoPay to show the QR payment simulation.
            </p>

            <button type="submit" class="place-order-btn">Place Order</button>
        </form>
    </div>

    <aside class="checkout-summary-side">
        @foreach($cartItems as $item)
            @php
                $product = $item->product;
                $image = $product->images->where('is_main', 1)->first() ?? $product->images->first();
                $price = $product->discount_price ?? $product->price;
                $variantPrice = $item->variant->additional_price ?? 0;
                $finalPrice = $price + $variantPrice;
            @endphp

            <div class="summary-item">
                <div class="summary-img-wrap">
                    @if($image)
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="summary-img" alt="{{ $product->name }}">
                    @else
                        <img src="{{ asset('storage/products/default-jewelry.jpg') }}" class="summary-img" alt="{{ $product->name }}">
                    @endif
                    <span class="summary-qty">{{ $item->quantity }}</span>
                </div>

                <div>
                    <div class="summary-name">{{ $product->name }}</div>
                    <div class="summary-meta">
                        {{ $product->color ?? 'Silver' }}
                        @if($item->variant)
                            / {{ $item->variant->variant_name ?? $item->variant->size }}
                        @endif
                    </div>
                </div>

                <div>Rp {{ number_format($finalPrice * $item->quantity, 0, ',', '.') }}</div>
            </div>
        @endforeach

        <div class="summary-row">
            <span>Subtotal</span>
            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>

        <div class="summary-row">
            <span>Shipping</span>
            <span>Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
        </div>

        <div class="summary-total">
            <span>Total</span>
            <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
        </div>
    </aside>
</section>

@endsection