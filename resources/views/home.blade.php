    @extends('layouts.app', ['title' => 'Sora Jewelry'])

    @section('styles')
    <style>
        .hero {
        position: relative;
        height: 90vh;
        overflow: hidden;

        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;

        margin: -24px -38px 60px;
    }

    .hero-video {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.35);
    }

    .hero-content {
        position: relative;
        z-index: 2;
        color: white;
        padding: 20px;
    }

    .hero h1 {
        font-family: Georgia, serif;
        font-size: 64px;
        font-weight: 400;
        font-style: italic;
        margin: 0 0 18px;

        animation: fadeUp 2.5s ease;
    }

    .hero p {
        max-width: 520px;
        margin: 0 auto 28px;
        color: white;
        font-family: Georgia, serif;
        font-size: 18px;
        letter-spacing: 1px;
        line-height: 1.7;

        animation: fadeUp 2s ease;
    }
        .hero-btn {
        display: inline-block;
        padding: 14px 32px;

        border: 1px solid white;
        border-radius: 40px;

        font-size: 14px;
        letter-spacing: 1px;

        color: white;

        background: transparent;

        transition: 0.35s ease;

        animation: fadeUp 2.5s ease;
    }

    .hero-btn:hover {
        background: #d4b06a;

        color: white;

        transform: translateY(-5px) scale(1.05);

        box-shadow: 0 10px 25px rgba(0,0,0,0.25);
    }

    .section-title {
        position: relative;
        text-align: center;
        font-size: 38px;
        font-weight: 400;
        margin-bottom: px;
        letter-spacing: 0.5px;
        font-family: 'Playfair Display', serif;
        margin-bottom: 30px;
        color: #4e443a;
    }

    .section-title::after {
        content: '';
        display: block;
        width: 60px;
        height: 1px;
        background: #2f2f2f;
        margin: 12px auto 0;
    }

    .featured-wrapper {
        overflow-x: auto;
        scroll-behavior: smooth;
        scrollbar-width: none;
        width: 100%;
    }

    .featured-wrapper::-webkit-scrollbar {
        display: none;
    }

    .featured-wrapper:hover .featured-grid {
        animation-play-state: paused;
    }

    .featured-grid {
        display: flex;
        gap: 20px;
        width: max-content;
        animation: marquee 120s linear infinite;
    }

    .featured-grid a {
        min-width: 250px;
        flex-shrink: 0;
        transition: 0.3s ease;
        min-width: unset;
    }

    .featured-grid a:hover {
        transform: none;
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

        @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes marquee {
        from {
            transform: translateX(0);
        }

        to {
            transform: translateX(-50%);
        }
    }

    .featured-card {
        display: block;
        text-decoration: none;
        color: inherit;
        width: 500px;
    }

    .featured-image-box {
        width: 100%;
        aspect-ratio: 1 / 1;
        background: #efefed;
        overflow: hidden;
    }

    .featured-image-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.4s ease;
    }
    .featured-card:hover .featured-image-box img {
        transform: scale(1.05);
    }

    .featured-no-image {
        width: 100%;
        height: 100%;
        background: #efefed;
        color: #999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .featured-info {
        padding-top: 12px;
        font-size: 14px;
        line-height: 1.6;
    }

    .featured-name {
        font-family: 'Cormorant Garamond', serif;
        font-size: 22px;
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    .featured-price {
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        font-weight: 400;
        color: #666;
        letter-spacing: 0.8px;
        margin-top: 4px;
    }

    </style>
    @endsection

    @section('content')

    <section class="hero">

        <video autoplay muted loop playsinline class="hero-video">
            <source src="https://res.cloudinary.com/dq2ljlqkw/video/upload/v1780752636/jewelry-video_ouejna.mp4" type="video/mp4">
        </video>

        <div class="hero-overlay"></div>

        <div class="hero-content">
            <h1>Sora Jewelry</h1>

            <p>
                Minimal jewelry pieces designed for everyday elegance.
            </p>

            <a href="{{ route('products.index') }}" class="hero-btn">
                Shop Catalogue
            </a>
        </div>

    </section>

    <h2 class="section-title">Featured Products</h2>

    <div class="featured-wrapper">
    <div class="featured-grid">

        @foreach($featuredProducts->concat($featuredProducts) as $product)
           @php
    $image = $product->images->where('is_main', 1)->first() ?? $product->images->first();
@endphp

<a href="{{ route('products.show', $product->slug) }}" class="featured-card">
    <div class="featured-image-box">
        @if($image)
            <img src="{{ $image->image_url }}" alt="{{ $product->name }}">
        @else
            <div class="featured-no-image">No Image</div>
        @endif
    </div>

    <div class="featured-info">
        <div class="featured-name">
            {{ $product->name }}
        </div>

        <div class="featured-price">
            Rp {{ number_format($product->discount_price ?? $product->price, 0, ',', '.') }}
        </div>
    </div>
</a>
        @endforeach
    </div>
    </div>
    @include('components.chatbot')

    @endsection