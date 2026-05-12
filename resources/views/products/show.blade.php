@extends('layouts.app', ['title' => $product->name . ' - Sora Jewelry'])

@section('styles')
<style>
    .product-detail {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 55px;
        align-items: flex-start;
    }

    .image-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

    .image-box {
        background: #efefed;
        aspect-ratio: 1 / 1.18;
        overflow: hidden;
    }

    .image-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-summary {
        position: sticky;
        top: 100px;
        padding-top: 20px;
    }

    .product-title {
        font-size: 28px;
        font-weight: 400;
        margin: 0 0 12px;
    }

    .product-price {
        font-size: 18px;
        color: #555;
        margin-bottom: 30px;
    }

    .product-description {
        color: #555;
        line-height: 1.8;
        margin-bottom: 30px;
    }

    .meta {
        margin-bottom: 30px;
        color: #666;
        line-height: 1.8;
    }

    .quantity {
        margin-bottom: 18px;
    }

    .quantity input,
    .variant-select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        background: transparent;
        margin-top: 8px;
    }

    .btn {
        width: 100%;
        border: 1px solid #222;
        padding: 15px;
        margin-bottom: 12px;
        background: transparent;
        cursor: pointer;
        font-size: 15px;
    }

    .btn-dark {
        background: #222;
        color: white;
    }

    .back-link {
        display: inline-block;
        margin-bottom: 30px;
        color: #555;
    }

    .recommended-section {
        margin-top: 80px;
    }

    .recommended-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }

    .recommended-title {
        font-size: 24px;
        font-weight: 400;
        margin-bottom: 25px;
    }

    @media (max-width: 900px) {
        .product-detail {
            grid-template-columns: 1fr;
        }

        .product-summary {
            position: static;
        }

        .recommended-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endsection

@section('content')

<a href="{{ route('products.index') }}" class="back-link">← Back to products</a>

<div class="product-detail">
    <div class="image-grid">
        @forelse($product->images as $image)
            <div class="image-box">
                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}">
            </div>
        @empty
            <div class="image-box">
                <img src="{{ asset('storage/products/default-jewelry.jpg') }}" alt="{{ $product->name }}">
            </div>
        @endforelse
    </div>

    <div class="product-summary">
        <h1 class="product-title">{{ $product->name }}</h1>

        <div class="product-price">
            @if($product->discount_price)
                Rp {{ number_format($product->discount_price, 0, ',', '.') }}
            @else
                Rp {{ number_format($product->price, 0, ',', '.') }}
            @endif
        </div>

        <div class="product-description">
            {{ $product->description }}
        </div>

        <div class="meta">
            <div>Category: {{ $product->category->name ?? '-' }}</div>
            <div>Collection: {{ $product->collection->name ?? '-' }}</div>
            <div>Material: {{ $product->material ?? '-' }}</div>
            <div>Color: {{ $product->color ?? '-' }}</div>
            <div>Stock: {{ $product->stock }}</div>
        </div>

        <form action="#" method="POST">
            @csrf

            @if($product->variants->count() > 0)
                <label>Variant</label>
                <select name="product_variant_id" class="variant-select">
                    @foreach($product->variants as $variant)
                        <option value="{{ $variant->id }}">
                            {{ $variant->variant_name }} - Stock: {{ $variant->stock }}
                        </option>
                    @endforeach
                </select>
            @endif

            <div class="quantity">
                <label>Quantity</label>
                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}">
            </div>

            <button type="submit" class="btn btn-dark">Add to Cart</button>
            <button type="button" class="btn">Add to Wishlist</button>
        </form>
    </div>
</div>

@if($recommendedProducts->count() > 0)
    <section class="recommended-section">
        <h2 class="recommended-title">You may also like</h2>

        <div class="recommended-grid">
            @foreach($recommendedProducts as $recommended)
                @php
                    $mainImage = $recommended->images->where('is_main', 1)->first() ?? $recommended->images->first();
                @endphp

                <a href="{{ route('products.show', $recommended->slug) }}">
                    <div class="image-box">
                        @if($mainImage)
                            <img src="{{ asset('storage/' . $mainImage->image_path) }}" alt="{{ $recommended->name }}">
                        @else
                            <img src="{{ asset('storage/products/default-jewelry.jpg') }}" alt="{{ $recommended->name }}">
                        @endif
                    </div>

                    <div style="margin-top: 12px;">{{ $recommended->name }}</div>
                    <div style="color: #555;">Rp {{ number_format($recommended->price, 0, ',', '.') }}</div>
                </a>
            @endforeach
        </div>
    </section>
@endif

@endsection