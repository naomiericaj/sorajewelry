@extends('layouts.app', ['title' => 'Wishlist - Sora Jewelry'])

@section('styles')
<style>
    .wishlist-page {
        padding: 42px 38px 80px;
        background: #f8f8f6;
        min-height: calc(100vh - 70px);
    }

    .wishlist-header {
        margin-bottom: 36px;
    }

    .wishlist-title {
        font-family: Georgia, serif;
        font-size: 42px;
        font-weight: 400;
        margin: 0;
    }

    .wishlist-subtitle {
        color: #666;
        margin-top: 8px;
    }

    .wishlist-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 22px;
    }

    .wishlist-card {
        display: block;
    }

    .image-box {
        aspect-ratio: 1 / 1.25;
        background: #efefed;
        overflow: hidden;
    }

    .image-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
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

    .wishlist-info {
        padding-top: 13px;
        line-height: 1.5;
    }

    .product-name {
        font-size: 15px;
    }

    .price {
        color: #555;
        font-size: 14px;
        margin-top: 4px;
    }

    .wishlist-actions {
        display: grid;
        grid-template-columns: 1fr;
        gap: 8px;
        margin-top: 12px;
    }

    .btn {
        width: 100%;
        height: 44px;
        border: 1px solid #111;
        background: transparent;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-dark {
        background: #111;
        color: white;
    }

    .btn-danger {
        border-color: #8b0000;
        color: #8b0000;
    }

    .empty {
        background: white;
        padding: 40px;
        color: #666;
    }

    @media (max-width: 1100px) {
        .wishlist-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 750px) {
        .wishlist-page {
            padding: 30px 18px 60px;
        }

        .wishlist-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .wishlist-title {
            font-size: 34px;
        }
    }
</style>
@endsection

@section('content')

<section class="wishlist-page">
    <div class="wishlist-header">
        <h1 class="wishlist-title">Wishlist</h1>
        <div class="wishlist-subtitle">Saved pieces you can come back to later.</div>
    </div>

    @if($wishlistItems->isEmpty())
        <div class="empty">
            Your wishlist is empty.<br><br>
            <a href="{{ route('products.index') }}" style="text-decoration:underline;">Browse catalogue</a>
        </div>
    @else
        <div class="wishlist-grid">
            @foreach($wishlistItems as $item)
                @php
                    $product = $item->product;
                    $image = $product->images->where('is_main', 1)->first() ?? $product->images->first();
                    $price = $product->discount_price ?? $product->price;
                @endphp

                <div class="wishlist-card">
                    <a href="{{ route('products.show', $product->slug) }}">
                        <div class="image-box">
                            @if($image)
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}">
                            @else
                                <div class="no-image-box">No Image</div>
                            @endif
                        </div>

                        <div class="wishlist-info">
                            <div class="product-name">{{ $product->name }}</div>

                            <div class="price">
                                Rp {{ number_format($price, 0, ',', '.') }}
                            </div>
                        </div>
                    </a>

                    <div class="wishlist-actions">
                        <form action="{{ route('cart.store', $product) }}" method="POST">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button class="btn btn-dark" type="submit">Add to cart</button>
                        </form>

                        <form action="{{ route('wishlist.destroy', $product) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Remove</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>

@endsection