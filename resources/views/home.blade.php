@extends('layouts.app', ['title' => 'Sora Jewelry'])

@section('styles')
<style>
    .hero {
        height: 78vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        background: #f1f1ef;
        margin: -24px -38px 60px;
        padding: 40px;
    }

    .hero h1 {
        font-family: Georgia, serif;
        font-size: 64px;
        font-weight: 400;
        font-style: italic;
        margin: 0 0 18px;
    }

    .hero p {
        max-width: 520px;
        margin: 0 auto 28px;
        color: #555;
        line-height: 1.7;
    }

    .hero-btn {
        display: inline-block;
        padding: 13px 28px;
        border: 1px solid #222;
        font-size: 14px;
    }

    .section-title {
        font-size: 26px;
        font-weight: 400;
        margin-bottom: 25px;
    }

    .featured-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }

    .product-image-box {
        background: #efefed;
        aspect-ratio: 1 / 1.2;
        overflow: hidden;
    }

    .product-image-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-name {
        margin-top: 12px;
    }

    .product-price {
        color: #555;
        margin-top: 4px;
    }

    @media (max-width: 900px) {
        .featured-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endsection

@section('content')

<section class="hero">
    <div>
        <h1>Sora Jewelry</h1>
        <p>Minimal jewelry pieces designed for everyday elegance.</p>
        <a href="{{ route('products.index') }}" class="hero-btn">Shop Catalogue</a>
    </div>
</section>

<h2 class="section-title">Featured Products</h2>

<div class="featured-grid">
    @foreach($featuredProducts as $product)
        @php
            $mainImage = $product->images->where('is_main', 1)->first() ?? $product->images->first();
        @endphp

        <a href="{{ route('products.show', $product->slug) }}">
            <div class="product-image-box">
                @if($mainImage)
                    <img src="{{ asset('storage/' . $mainImage->image_path) }}" alt="{{ $product->name }}">
                @else
                    <img src="{{ asset('storage/products/default-jewelry.jpg') }}" alt="{{ $product->name }}">
                @endif
            </div>

            <div class="product-name">{{ $product->name }}</div>
            <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
        </a>
    @endforeach
</div>

@endsection