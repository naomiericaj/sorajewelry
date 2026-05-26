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
            font-size: 26px;
            font-weight: 400;
            margin-bottom: 25px;
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

    .featured-grid {
        display: flex;
        gap: 20px;
    }

    .featured-grid a {
        min-width: 250px;
        flex-shrink: 0;

        transition: 0.3s ease;
    }

    .featured-grid a:hover {
        transform: translateY(-8px);
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

    .featured-card {
    display: block;
    text-decoration: none;
    color: inherit;
}

.featured-image-box {
    width: 100%;
    aspect-ratio: 1 / 1.25;
    background: #efefed;
    overflow: hidden;
}

.featured-image-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
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

    </style>
    @endsection

    @section('content')

    <section class="hero">

        <video autoplay muted loop playsinline class="hero-video">
            <source src="{{ asset('videos/jewelry-video.mp4') }}" type="video/mp4">
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
            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}">
        @else
            <div class="featured-no-image">No Image</div>
        @endif
    </div>

    <div class="featured-info">
        <div>{{ $product->name }}</div>
        <div>Rp {{ number_format($product->discount_price ?? $product->price, 0, ',', '.') }}</div>
    </div>
</a>
        @endforeach
    </div>
    </div>

    @endsection