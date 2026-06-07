@extends('layouts.app', ['title' => 'Wishlist - Sora Jewelry'])

@section('styles')
<style>
    .wishlist-page {
        padding: 42px 38px 70px;
    }

    .wishlist-title {
        font-size: 30px;
        font-weight: 400;
        margin-bottom: 35px;
    }

    .wishlist-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 18px;
    }

    .wishlist-card {
        display: block;
    }

    .image-box {
        aspect-ratio: 1 / 1.22;
        background: #efefed;
        overflow: hidden;
    }

    .image-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .wishlist-info {
        padding-top: 12px;
        line-height: 1.5;
    }

    .price {
        color: #555;
    }

    .wishlist-actions {
        display: grid;
        grid-template-columns: 1fr;
        gap: 8px;
        margin-top: 10px;
    }

    .btn {
        height: 42px;
        border: 1px solid #111;
        background: transparent;
        cursor: pointer;
    }

    .btn-dark {
        background: #111;
        color: white;
    }

    .empty {
        background: white;
        padding: 35px;
        color: #666;
    }

    @media (max-width: 1100px) {
        .wishlist-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 700px) {
        .wishlist-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endsection

@section('content')

<section class="wishlist-page">
    <h1 class="wishlist-title">My Wishlist</h1>

    @if($wishlistItems->isEmpty())
        <div class="empty">Your wishlist is empty.</div>
    @else
        <div class="wishlist-grid">
            @foreach($wishlistItems as $item)
                @php
                    $product = $item->product;
                    $image = $product->images->where('is_main', 1)->first() ?? $product->images->first();
                @endphp

                <div class="wishlist-card">
                    <a href="{{ route('products.show', $product->slug) }}">
                        <div class="image-box">
                            @if($image)
                                <img src="{{ $image->image_url }}" alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('images/default-jewelry.jpg') }}" alt="{{ $product->name }}">
                            @endif
                        </div>

                        <div class="wishlist-info">
                            <div>{{ $product->name }}</div>
                            <div class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        </div>
                    </a>

                   <div class="wishlist-actions">
    <form action="{{ route('cart.store', $product) }}" method="POST" class="ajax-cart-form">
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