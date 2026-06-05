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
    }

    .product-card-link,
    .product-image-link {
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
        background: rgba(255, 255, 255, 0.9);
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

    .product-action-icons {
        position: absolute;
        right: 14px;
        bottom: 14px;
        display: flex;
        gap: 8px;
        z-index: 30;
    }

    .circle-action-btn {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        border: 1px solid rgba(17, 17, 17, 0.16);
        background: rgba(255, 255, 255, 0.94);
        color: #111;
        cursor: pointer;
        font-size: 17px;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(8px);
        transition: 0.25s ease;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        padding: 0;
    }

    .circle-action-btn:hover {
        background: #111;
        color: white;
        transform: translateY(-2px);
    }

    .circle-action-btn.added {
        background: #d7c3a3;
        border-color: #d7c3a3;
        color: #4e443a;
    }

    .circle-action-btn.ajax-loading {
        opacity: 0.7;
        pointer-events: none;
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

        .product-action-icons {
            right: 10px;
            bottom: 10px;
            gap: 6px;
        }

        .circle-action-btn {
            width: 36px;
            height: 36px;
            font-size: 15px;
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
                    <div class="product-image-wrap">
                        <a href="{{ route('products.show', $product->slug) }}" class="product-image-link">
                            @if($product->is_featured)
                                <span class="featured-badge">✦ Featured</span>
                            @endif

                            @if($image)
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}">
                            @else
                                <div class="no-image-box">No Image</div>
                            @endif
                        </a>

                        <div class="product-action-icons">
                            <button
                                type="button"
                                class="circle-action-btn ajax-wishlist-btn"
                                data-url="{{ route('wishlist.store', $product) }}"
                                data-original-text="♡"
                                title="Add to wishlist"
                            >
                                ♡
                            </button>

                            <button
                                type="button"
                                class="circle-action-btn ajax-cart-btn"
                                data-url="{{ route('cart.store', $product) }}"
                                data-original-text="🛍"
                                title="Add to cart"
                            >
                                🛍
                            </button>
                        </div>
                    </div>

                    <a href="{{ route('products.show', $product->slug) }}" class="product-card-link">
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

<script>
    document.addEventListener('click', function (event) {
        const button = event.target.closest('.ajax-cart-btn, .ajax-wishlist-btn');

        if (!button) {
            return;
        }

        event.preventDefault();
        event.stopPropagation();

        const isCart = button.classList.contains('ajax-cart-btn');
        const isWishlist = button.classList.contains('ajax-wishlist-btn');
        const originalText = button.dataset.originalText || button.innerHTML;
        const url = button.dataset.url;

        button.classList.add('ajax-loading');

        const formData = new FormData();

        if (isCart) {
            formData.append('quantity', '1');
        }

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(async response => {
            if (response.status === 401 || response.status === 419) {
                window.location.href = "{{ route('login') }}";
                return null;
            }

            if (!response.ok) {
                console.error(await response.text());
                return null;
            }

            return await response.json();
        })
        .then(data => {
            button.classList.remove('ajax-loading');

            if (!data || !data.success) {
                button.innerHTML = '!';
                setTimeout(() => {
                    button.innerHTML = originalText;
                }, 1200);
                return;
            }

            button.classList.add('added');
            button.innerHTML = '✓';

            setTimeout(() => {
                button.classList.remove('added');
                button.innerHTML = originalText;
            }, 1400);

            if (isCart && data.cart_count !== undefined) {
                const cartCount = document.querySelector('.cart-count');

                if (cartCount) {
                    cartCount.textContent = data.cart_count;
                }
            }

            if (isWishlist && data.wishlist_count !== undefined) {
                const wishlistCount = document.querySelector('.wishlist-count');

                if (wishlistCount) {
                    wishlistCount.textContent = data.wishlist_count;
                }
            }
        })
        .catch(error => {
            button.classList.remove('ajax-loading');

            button.innerHTML = '!';
            setTimeout(() => {
                button.innerHTML = originalText;
            }, 1200);

            console.error(error);
        });
    });
</script>

@endsection