@extends('layouts.app', ['title' => $product->name . ' - Sora Jewelry'])

@section('styles')
<style>
    .product-page {
        display: grid;
        grid-template-columns: 64% 36%;
        min-height: calc(100vh - 70px);
    }

    .product-gallery {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1px;
        background: #fff;
    }

    .product-image-box {
        background: #f0f0ee;
        min-height: 620px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .product-image-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-info {
        padding: 30px 44px;
        position: sticky;
        top: 70px;
        height: calc(100vh - 70px);
        overflow-y: auto;
        background: #f8f8f6;
    }

    .product-title {
        font-family: Georgia, serif;
        font-size: 34px;
        font-weight: 400;
        margin: 0 0 14px;
        letter-spacing: .3px;
    }

    .product-price {
        font-size: 17px;
        margin-bottom: 30px;
    }

    .divider {
        border-top: 1px solid #e1e1dd;
        margin: 24px 0;
    }

    .field-label {
        display: block;
        margin-bottom: 10px;
        color: #333;
    }

    .select-box {
        width: 100%;
        height: 58px;
        border: 1px solid #ddd;
        background: transparent;
        padding: 0 18px;
        font-size: 15px;
        margin-bottom: 22px;
    }

    .cart-row {
        display: grid;
        grid-template-columns: 140px 1fr;
        gap: 12px;
        margin-bottom: 22px;
    }

    .quantity-box {
        height: 58px;
        border: 1px solid #ddd;
        display: grid;
        grid-template-columns: 40px 1fr 40px;
        align-items: center;
        text-align: center;
    }

    .quantity-box button {
        border: none;
        background: transparent;
        font-size: 20px;
        cursor: pointer;
    }

    .quantity-box input {
        border: none;
        background: transparent;
        text-align: center;
        width: 100%;
        font-size: 15px;
    }

    .btn {
        height: 58px;
        border: 1px solid #111;
        background: transparent;
        cursor: pointer;
        font-size: 15px;
        width: 100%;
        transition: 0.25s ease;
    }

    .btn:hover {
        background: #111;
        color: white;
    }

    .btn-dark {
        background: #111;
        color: white;
    }

    .wishlist-form {
        margin-top: 12px;
    }

    .ajax-main-btn.added {
        background: #d7c3a3;
        border-color: #d7c3a3;
        color: #4e443a;
    }

    .ajax-loading {
        opacity: 0.7;
        pointer-events: none;
    }

    .accordion {
        border-top: 1px solid #e1e1dd;
    }

    .accordion-item {
        border-bottom: 1px solid #e1e1dd;
        padding: 18px 0;
    }

    .accordion-title {
        display: flex;
        justify-content: space-between;
        cursor: pointer;
        font-size: 16px;
    }

    .accordion-content {
        margin-top: 14px;
        color: #555;
        line-height: 1.7;
        font-size: 14px;
    }

    @media (max-width: 950px) {
        .product-page {
            grid-template-columns: 1fr;
        }

        .product-gallery {
            grid-template-columns: 1fr;
        }

        .product-image-box {
            min-height: 430px;
        }

        .product-info {
            position: static;
            height: auto;
            padding: 28px 22px;
        }

        .cart-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

<section class="product-page">
    <div class="product-gallery">
        @if($product->images->isNotEmpty())
            @foreach($product->images as $image)
                <div class="product-image-box">
                    <img src="{{ asset('images/' . $image->image_path) }}" alt="{{ $product->name }}">
                </div>
            @endforeach
        @else
            <div class="product-image-box">
                <div style="color:#999;">No Image</div>
            </div>
        @endif
    </div>

    <aside class="product-info">
        <h1 class="product-title">{{ $product->name }}</h1>

        <div class="product-price">
            @if($product->discount_price)
                Rp {{ number_format($product->discount_price, 0, ',', '.') }}
            @else
                Rp {{ number_format($product->price, 0, ',', '.') }}
            @endif
        </div>

        <div class="divider"></div>

        <form action="{{ route('cart.store', $product) }}" method="POST" class="ajax-cart-form">
            @csrf

            <label class="field-label">Color</label>
            <select class="select-box" name="color">
                <option>{{ $product->color ?? 'Silver' }}</option>
            </select>

            @if(isset($product->variants) && $product->variants->count() > 0)
                <label class="field-label">Size</label>
                <select class="select-box" name="product_variant_id">
                    @foreach($product->variants as $variant)
                        <option value="{{ $variant->id }}">
                            {{ $variant->variant_name ?? $variant->size }}
                        </option>
                    @endforeach
                </select>
            @endif

            <div class="cart-row">
                <div class="quantity-box">
                    <button type="button" onclick="changeQty(-1)">−</button>
                    <input id="qty" type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}">
                    <button type="button" onclick="changeQty(1)">+</button>
                </div>

                <button type="submit" class="btn ajax-main-btn" data-original-text="🛍 &nbsp; Add to cart">
                    🛍 &nbsp; Add to cart
                </button>
            </div>
        </form>

        <form action="{{ route('wishlist.store', $product) }}" method="POST" class="wishlist-form ajax-wishlist-form">
            @csrf

            <button type="submit" class="btn ajax-main-btn" data-original-text="♡ Add to wishlist">
                ♡ Add to wishlist
            </button>
        </form>

        <div class="accordion" style="margin-top: 28px;">
            <div class="accordion-item">
                <div class="accordion-title">
                    <span>Description</span>
                    <span>⌄</span>
                </div>
                <div class="accordion-content">
                    {{ $product->description ?? 'A minimal jewelry piece designed for everyday styling.' }}
                </div>
            </div>

            <div class="accordion-item">
                <div class="accordion-title">
                    <span>Contact</span>
                    <span>⌄</span>
                </div>
                <div class="accordion-content">
                    For product questions, please contact our customer service.
                </div>
            </div>

            <div class="accordion-item">
                <div class="accordion-title">
                    <span>Care Instruction</span>
                    <span>⌄</span>
                </div>
                <div class="accordion-content">
                    Keep away from water, perfume, and harsh chemicals. Store separately after use.
                </div>
            </div>
        </div>
    </aside>
</section>

<script>
    function changeQty(amount) {
        const input = document.getElementById('qty');
        const current = parseInt(input.value || 1);
        const min = parseInt(input.min || 1);
        const max = parseInt(input.max || 999);

        let next = current + amount;

        if (next < min) next = min;
        if (next > max) next = max;

        input.value = next;
    }
</script>

@endsection