@extends('layouts.app', ['title' => 'Cart - Sora Jewelry'])

@section('styles')
<style>
    .cart-page {
        display: grid;
        grid-template-columns: 1fr 430px;
        min-height: calc(100vh - 70px);
        background: #f8f8f6;
    }

    .cart-left {
        padding: 44px 50px;
    }

    .cart-title {
        font-family: Georgia, serif;
        font-size: 38px;
        font-weight: 400;
        margin-bottom: 30px;
    }

    .cart-item {
        display: grid;
        grid-template-columns: 115px 1fr 150px;
        gap: 22px;
        padding: 22px 0;
        border-bottom: 1px solid #e1e1dd;
        align-items: start;
    }

    .cart-img,
    .cart-no-image {
        width: 115px;
        height: 130px;
        object-fit: cover;
        background: #efefed;
        border: 1px solid #eee;
    }

    .cart-no-image {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        font-size: 12px;
    }

    .cart-name {
        font-size: 18px;
        margin-bottom: 8px;
    }

    .cart-meta {
        color: #666;
        font-size: 14px;
        line-height: 1.7;
    }

    .qty-box {
        width: 125px;
        height: 42px;
        display: grid;
        grid-template-columns: 35px 1fr 35px;
        border: 1px solid #ddd;
        align-items: center;
        text-align: center;
    }

    .qty-box button {
        border: none;
        background: transparent;
        cursor: pointer;
        font-size: 18px;
    }

    .qty-box input {
        border: none;
        background: transparent;
        text-align: center;
        width: 100%;
    }

    .remove-btn {
        border: none;
        background: transparent;
        color: #777;
        cursor: pointer;
        margin-top: 12px;
        padding: 0;
        font-size: 13px;
        text-decoration: underline;
    }

    .saving {
        font-size: 12px;
        color: #777;
        margin-top: 8px;
        display: none;
    }

    .cart-summary {
        background: #a7ad98;
        color: white;
        padding: 44px 50px;
    }

    .summary-box {
        position: sticky;
        top: 100px;
    }

    .summary-title {
        font-family: Georgia, serif;
        font-size: 30px;
        font-weight: 400;
        margin-bottom: 30px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 18px;
        font-size: 16px;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid rgba(255,255,255,.35);
        font-size: 24px;
        font-weight: 700;
    }

    .checkout-btn {
        width: 100%;
        height: 58px;
        border: none;
        background: black;
        color: white;
        margin-top: 30px;
        font-size: 15px;
        cursor: pointer;
    }

    .continue-link {
        display: inline-block;
        margin-top: 20px;
        text-decoration: underline;
        font-size: 14px;
    }

    .empty-cart {
        background: white;
        padding: 40px;
        color: #666;
    }

    @media (max-width: 900px) {
        .cart-page {
            grid-template-columns: 1fr;
        }

        .cart-left,
        .cart-summary {
            padding: 28px 22px;
        }

        .cart-item {
            grid-template-columns: 95px 1fr;
        }

        .cart-img,
        .cart-no-image {
            width: 95px;
            height: 110px;
        }

        .cart-actions {
            grid-column: 2;
        }
    }
</style>
@endsection

@section('content')

<section class="cart-page">
    <div class="cart-left">
        <h1 class="cart-title">
            Cart <span id="cart-count-label" style="color:#999;">{{ $cartCount ?? 0 }}</span>
        </h1>

        @if($cartItems->isEmpty())
            <div class="empty-cart">
                Your cart is empty.<br><br>
                <a href="{{ route('products.index') }}" style="text-decoration:underline;">Continue shopping</a>
            </div>
        @else
            @foreach($cartItems as $item)
                @php
                    $product = $item->product;
                    $image = $product->images->where('is_main', 1)->first() ?? $product->images->first();

                    $price = $product->discount_price ?? $product->price;
                    $variantPrice = $item->variant->additional_price ?? 0;
                    $finalPrice = $price + $variantPrice;
                @endphp

                <div class="cart-item"
                     data-item-id="{{ $item->id }}"
                     data-price="{{ $finalPrice }}">

                    <a href="{{ route('products.show', $product->slug) }}">
                        @if($image)
                            <img src="{{ asset('images/' . $image->image_path) }}" class="cart-img" alt="{{ $product->name }}">
                        @else
                            <div class="cart-no-image">No Image</div>
                        @endif
                    </a>

                    <div>
                        <a href="{{ route('products.show', $product->slug) }}">
                            <div class="cart-name">{{ $product->name }}</div>
                        </a>

                        <div class="cart-meta">
                            {{ $product->color ?? 'No color selected' }}
                            @if($item->variant)
                                / {{ $item->variant->variant_name ?? $item->variant->size }}
                            @endif
                        </div>

                        <div class="cart-meta">
                            Rp {{ number_format($finalPrice, 0, ',', '.') }}
                        </div>

                        <div class="cart-meta item-total">
                            Item total: Rp {{ number_format($finalPrice * $item->quantity, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="cart-actions">
                        <div class="qty-box">
                            <button type="button" onclick="changeCartQty(this, -1)">−</button>
                            <input type="number" value="{{ $item->quantity }}" min="1" onchange="manualQtyChange(this)">
                            <button type="button" onclick="changeCartQty(this, 1)">+</button>
                        </div>

                        <div class="saving">Updating...</div>

                        <form action="{{ route('cart.destroy', $item) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="remove-btn" type="submit">Remove</button>
                        </form>
                    </div>
                </div>
            @endforeach

            <a href="{{ route('products.index') }}" class="continue-link">Continue shopping</a>
        @endif
    </div>

    <aside class="cart-summary">
        <div class="summary-box">
            <h2 class="summary-title">Order Summary</h2>

            <div class="summary-row">
                <span>Subtotal</span>
                <span id="subtotal-text">Rp {{ number_format($subtotal ?? 0, 0, ',', '.') }}</span>
            </div>

            <div class="summary-row">
                <span>Shipping</span>
                <span>Calculated at checkout</span>
            </div>

            <div class="summary-total">
                <span>Total</span>
                <span id="total-text">Rp {{ number_format($subtotal ?? 0, 0, ',', '.') }}</span>
            </div>

            @if(!$cartItems->isEmpty())
                <a href="{{ route('checkout.index') }}">
                    <button class="checkout-btn">Check out</button>
                </a>
            @endif
        </div>
    </aside>
</section>

<script>
    function formatRupiah(number) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
    }

    function recalculateCart() {
        let subtotal = 0;
        let cartCount = 0;

        document.querySelectorAll('.cart-item').forEach(function(item) {
            const price = parseFloat(item.dataset.price);
            const quantity = parseInt(item.querySelector('input').value || 1);
            const itemTotal = price * quantity;

            subtotal += itemTotal;
            cartCount += quantity;

            item.querySelector('.item-total').innerText = 'Item total: ' + formatRupiah(itemTotal);
        });

        document.getElementById('subtotal-text').innerText = formatRupiah(subtotal);
        document.getElementById('total-text').innerText = formatRupiah(subtotal);
        document.getElementById('cart-count-label').innerText = cartCount;

        const navbarCartCount = document.querySelector('.cart-count');
        if (navbarCartCount) {
            navbarCartCount.innerText = cartCount;
        }
    }

    function changeCartQty(button, amount) {
        const cartItem = button.closest('.cart-item');
        const input = cartItem.querySelector('input');

        let quantity = parseInt(input.value || 1);
        quantity += amount;

        if (quantity < 1) {
            quantity = 1;
        }

        input.value = quantity;

        updateCartQuantity(cartItem, quantity);
        recalculateCart();
    }

    function manualQtyChange(input) {
        const cartItem = input.closest('.cart-item');

        let quantity = parseInt(input.value || 1);

        if (quantity < 1) {
            quantity = 1;
            input.value = 1;
        }

        updateCartQuantity(cartItem, quantity);
        recalculateCart();
    }

    function updateCartQuantity(cartItem, quantity) {
        const itemId = cartItem.dataset.itemId;
        const savingText = cartItem.querySelector('.saving');

        savingText.style.display = 'block';

        fetch(`/cart/item/${itemId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            savingText.style.display = 'none';
        })
        .catch(error => {
            savingText.style.display = 'none';
            alert('Cart could not be updated. Please refresh and try again.');
            console.error(error);
        });
    }
</script>

@endsection