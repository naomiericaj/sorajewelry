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
        top: 12px;
        left: 12px;
        background: #111;
        color: white;
        font-size: 12px;
        padding: 7px 10px;
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

                <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                    <div class="product-image-wrap">
                        @if($product->is_featured)
                            <span class="featured-badge">Featured</span>
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
            @endforeach
        </div>

        @if(method_exists($products, 'links'))
            <div class="pagination-box">
                {{ $products->links() }}
            </div>
        @endif
    @endif
</section>

@endsection