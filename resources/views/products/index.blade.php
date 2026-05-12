@extends('layouts.app', ['title' => 'Products - Sora Jewelry'])

@section('styles')
<style>
    .catalogue-header {
        margin-bottom: 55px;
    }

    .catalogue-title {
        font-size: 27px;
        font-weight: 400;
        margin-bottom: 55px;
    }

    .catalogue-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .filters {
        display: flex;
        gap: 28px;
        align-items: center;
    }

    .filter-select {
        border: none;
        background: transparent;
        font-size: 15px;
        color: #333;
        padding: 5px 0;
        cursor: pointer;
    }

    .toolbar-right {
        display: flex;
        align-items: center;
        gap: 25px;
        color: #555;
    }

    .view-icons {
        display: flex;
        gap: 14px;
        font-size: 20px;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 18px;
    }

    .product-image-box {
        width: 100%;
        aspect-ratio: 1 / 1.22;
        background: #efefed;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .product-image-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.35s ease;
    }

    .product-card:hover img {
        transform: scale(1.04);
    }

    .product-info {
        padding-top: 12px;
        line-height: 1.35;
    }

    .product-name {
        font-size: 15px;
        color: #333;
    }

    .product-price {
        font-size: 15px;
        color: #555;
    }

    .empty {
        grid-column: 1 / -1;
        padding: 80px 0;
        text-align: center;
        color: #777;
    }

    .pagination {
        margin-top: 40px;
    }

    @media (max-width: 1200px) {
        .products-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (max-width: 900px) {
        .products-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .catalogue-toolbar {
            align-items: flex-start;
            gap: 20px;
            flex-direction: column;
        }
    }

    @media (max-width: 500px) {
        .products-grid {
            grid-template-columns: 1fr;
        }

        .filters {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
    }
</style>
@endsection

@section('content')

<div class="catalogue-header">
    <h1 class="catalogue-title">Products</h1>

    <form method="GET" action="{{ route('products.index') }}" class="catalogue-toolbar">
        <div class="filters">
            <select name="category" class="filter-select" onchange="this.form.submit()">
                <option value="">Product type</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <select name="availability" class="filter-select" onchange="this.form.submit()">
                <option value="">Availability</option>
                <option value="in_stock" {{ request('availability') == 'in_stock' ? 'selected' : '' }}>In stock</option>
                <option value="out_of_stock" {{ request('availability') == 'out_of_stock' ? 'selected' : '' }}>Out of stock</option>
            </select>

            <select name="price" class="filter-select" onchange="this.form.submit()">
                <option value="">Price</option>
                <option value="low_high" {{ request('price') == 'low_high' ? 'selected' : '' }}>Low to high</option>
                <option value="high_low" {{ request('price') == 'high_low' ? 'selected' : '' }}>High to low</option>
            </select>
        </div>

        <div class="toolbar-right">
            <span>{{ $products->total() }} items</span>

            <select name="sort" class="filter-select" onchange="this.form.submit()">
                <option value="">Sort</option>
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Popular</option>
                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
            </select>

            <div class="view-icons">
                <span>▦</span>
                <span>☷</span>
            </div>
        </div>
    </form>
</div>

<div class="products-grid">
    @forelse($products as $product)
        @php
            $mainImage = $product->images->where('is_main', 1)->first() ?? $product->images->first();
        @endphp

        <a href="{{ route('products.show', $product->slug) }}" class="product-card">
            <div class="product-image-box">
                @if($mainImage)
                    <img src="{{ asset('storage/' . $mainImage->image_path) }}" alt="{{ $product->name }}">
                @else
                    <img src="{{ asset('storage/products/default-jewelry.jpg') }}" alt="{{ $product->name }}">
                @endif
            </div>

            <div class="product-info">
                <div class="product-name">{{ $product->name }}</div>

                <div class="product-price">
                    @if($product->discount_price)
                        Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                    @else
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    @endif
                </div>
            </div>
        </a>
    @empty
        <div class="empty">No products found.</div>
    @endforelse
</div>

<div class="pagination">
    {{ $products->links() }}
</div>

@endsection