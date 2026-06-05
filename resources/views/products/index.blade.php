@extends('layouts.app', ['title' => 'Catalogue - Sora Jewelry'])

@section('styles')
<style>
    .catalogue-page {
        padding: 42px 38px 80px;
        background: #f8f8f6;
        min-height: calc(100vh - 70px);
    }

    .catalogue-header {
        margin-bottom: 36px;
    }

    .catalogue-title {
        font-family: Georgia, serif;
        font-size: 42px;
        font-weight: 400;
        margin: 0;
    }

    .catalogue-subtitle {
        color: #666;
        margin-top: 8px;
        font-size: 15px;
    }

    .product-count {
        margin-top: 18px;
        color: #777;
        font-size: 14px;
    }

    .search-result-text {
        margin-top: 12px;
        color: #666;
        font-size: 14px;
    }

    .search-result-text a {
        margin-left: 10px;
        text-decoration: underline;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 22px;
    }

    .product-card {
        display: block;
        color: inherit;
        text-decoration: none;
        position: relative;
        z-index: 1;
    }

    .product-card-link {
        display: block;
        color: inherit;
        text-decoration: none;
    }

    .product-image-wrap {
        width: 100%;
        aspect-ratio: 1 / 1.25;
        background: #efefed;
        overflow: hidden;
        position: relative;
    }

    .product-image-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.6s ease;
    }

    .product-card:hover .product-image-wrap img {
        transform: scale(1.08);
    }

    .no-image-box {
        width: 100%;
        height: 100%;
        background: #efefed;
        color: #999;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }

    .featured-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(6px);
        color: #4e443a;
        font-family: 'Cormorant Garamond', serif;
        font-size: 15px;
        font-weight: 600;
        letter-spacing: 1px;
        padding: 6px 14px;
        border-radius: 30px;
        z-index: 2;
    }

    .product-info {
        padding-top: 13px;
        display: flex;
        justify-content: space-between;
        gap: 16px;
        align-items: flex-start;
    }

    .product-name {
        font-size: 15px;
        line-height: 1.5;
    }

    .product-price {
        font-size: 14px;
        color: #555;
        white-space: nowrap;
        text-align: right;
    }

    .discount-price {
        color: #111;
    }

    .old-price {
        display: block;
        color: #999;
        text-decoration: line-through;
        font-size: 13px;
        margin-top: 3px;
    }

    .catalogue-cart-form {
        margin-top: 12px;
    }

    .catalogue-cart-btn {
        width: 100%;
        height: 42px;
        border: 1px solid #111;
        background: transparent;
        color: #111;
        cursor: pointer;
        font-size: 14px;
        transition: 0.3s ease;
    }

    .catalogue-cart-btn:hover {
        background: #111;
        color: white;
    }

    .catalogue-cart-btn.added {
        background: #d7c3a3;
        border-color: #d7c3a3;
        color: #4e443a;
    }

    .ajax-loading {
        opacity: 0.6;
        pointer-events: none;
    }

    .floating-toast {
        position: fixed;
        top: 95px;
        right: 28px;
        background: #111;
        color: white;
        padding: 14px 20px;
        font-size: 14px;
        z-index: 99999;
        opacity: 0;
        transform: translateY(-15px);
        pointer-events: none;
        transition: 0.3s ease;
    }

    .floating-toast.show {
        opacity: 1;
        transform: translateY(0);
    }

    .empty-box {
        background: white;
        padding: 40px;
        color: #666;
    }

    .pagination-box {
        margin-top: 40px;
    }

    @media (max-width: 1100px) {
        .product-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 750px) {
        .catalogue-page {
            padding: 30px 18px 60px;
        }

        .catalogue-title {
            font-size: 34px;
        }

        .product-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .product-info {
            display: block;
        }

        .product-price {
            text-align: left;
            margin-top: 5px;
        }

        .catalogue-cart-btn {
            height: 40px;
            font-size: 13px;
        }
    }
</style>
@endsection

@section('content')

<section class="catalogue-page">
    <div class="catalogue-header">
        <h1 class="catalogue-title">Catalogue</h1>
        <div class="catalogue-subtitle">Minimal jewelry pieces for everyday styling.</div>

        <div class="product-count">
            @if(method_exists($products, 'total'))
                {{ $products->total() }} items
            @else
                {{ $products->count() }} items
            @endif

            @if(request('search'))
                <div class="search-result-text">
                    Search results for: <strong>{{ request('search') }}</strong>

                    <a href="{{ route('products.index') }}">
                        Clear
                    </a>
                </div>
            @endif
        </div>
    </div>

    @if($products->isEmpty())
        <div class="empty-box">
            No products available yet.
        </div>
    @else
        <div class="product-grid">
            @foreach($products as $product)
                @php
                    $image = $product->images->where('is_main', 1)->first() ?? $product->images->first();
                    $price = $product->discount_price ?? $product->price;
                @endphp

                <div class="product-card">
                    <a href="{{ route('products.show', $product->slug) }}" class="product-card-link">
                        <div class="product-image-wrap">
                            @if($product->is_featured)
                                <span class="featured-badge">✦ Featured</span>
                            @endif

                            @if($image)
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}">
                            @else
                                <div class="no-image-box">No Image</div>
                            @endif
                        </div>

                        <div class="product-info">
                            <div class="product-name">
                                {{ $product->name }}
                            </div>

                            <div class="product-price">
                                @if($product->discount_price)
                                    <span class="discount-price">
                                        Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                                    </span>

                                    <span class="old-price">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                @else
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                @endif
                            </div>
                        </div>
                    </a>

                    <form action="{{ route('cart.store', $product) }}" method="POST" class="ajax-cart-form catalogue-cart-form">
                        @csrf

                        <input type="hidden" name="quantity" value="1">

                        <button type="submit" class="catalogue-cart-btn">
                            🛍 Add to Cart
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        @if(method_exists($products, 'links'))
            <div class="pagination-box">
                {{ $products->links() }}
            </div>
        @endif
    @endif
</section>

<div id="floating-toast" class="floating-toast"></div>

<script>
    function showFloatingToast(message) {
        const toast = document.getElementById('floating-toast');

        if (!toast) return;

        toast.textContent = message;
        toast.classList.add('show');

        setTimeout(() => {
            toast.classList.remove('show');
        }, 1800);
    }

    document.addEventListener('submit', function (event) {
        const form = event.target;

        if (!form.classList.contains('ajax-cart-form')) {
            return;
        }

        event.preventDefault();

        const button = form.querySelector('button[type="submit"]');
        const originalText = button ? button.innerHTML : '';

        form.classList.add('ajax-loading');

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: new FormData(form)
        })
        .then(response => {
            if (response.status === 401 || response.status === 419) {
                throw new Error('auth');
            }

            return response.json();
        })
        .then(data => {
            form.classList.remove('ajax-loading');

            if (data.success) {
                showFloatingToast(data.message || 'Added to cart.');

                if (button) {
                    button.classList.add('added');
                    button.innerHTML = '✓ Added';

                    setTimeout(() => {
                        button.classList.remove('added');
                        button.innerHTML = originalText;
                    }, 1400);
                }

                const cartCount = document.querySelector('.cart-count');

                if (cartCount && data.cart_count !== undefined) {
                    cartCount.textContent = data.cart_count;
                }
            } else {
                showFloatingToast(data.message || 'Could not add to cart.');
            }
        })
        .catch(error => {
            form.classList.remove('ajax-loading');

            if (error.message === 'auth') {
                showFloatingToast('Please login first.');
            } else {
                showFloatingToast('Something went wrong.');
            }

            console.error(error);
        });
    });
</script>

@endsection