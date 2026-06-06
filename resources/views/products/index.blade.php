@extends('layouts.app', ['title' => 'Catalogue - Sora Jewelry'])

@section('styles')
<style>
    .catalogue-page {
        padding: 42px 38px 80px;
        background: #f8f8f6;
        min-height: calc(100vh - 70px);
    }

    .catalogue-header {
        margin-bottom: 15px;
    }

    .catalogue-title {
        font-family: Georgia, serif;
        font-size: 42px;
        font-weight: 400;
        margin: 0;
    }

    .catalogue-subtitle {
        color: #666;
        margin-top: 12px;
        font-size: 18px;
    }

    .product-count {
        margin-top: 5px;
        color: #777;
        font-size: 17px;
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

    .empty-box {
        background: white;
        padding: 40px;
        color: #666;
    }

    .pagination-box {
        margin-top: 40px;
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

    .product-image-wrap {
        overflow: hidden;
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
        .catalogue-filters {
    margin: 28px 0 36px;
    padding: 18px;
    background: #ffffff;
    border: 1px solid #e1e1dd;
    display: flex;
    gap: 14px;
    align-items: center;
    flex-wrap: wrap;
}

.catalogue-filters select,
.catalogue-filters input {
    height: 42px;
    border: 1px solid #d8d8d4;
    background: transparent;
    padding: 0 12px;
    font-family: 'Cormorant Garamond', serif;
    font-size: 15px;
    min-width: 150px;
}

.filter-btn {
    height: 42px;
    border: 1px solid #111;
    background: #111;
    color: white;
    padding: 0 22px;
    cursor: pointer;
    font-family: 'Cormorant Garamond', serif;
    font-size: 15px;
}

.clear-filter-btn {
    height: 42px;
    border: 1px solid #d8d8d4;
    background: transparent;
    color: #333;
    padding: 0 18px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
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

.catalogue-filters {
    margin: 28px 0 36px;
    padding: 18px 20px;
    background: #ffffff;
    border: 1px solid #e1e1dd;
    display: flex;
    gap: 14px;
    align-items: center;
    flex-wrap: wrap;
}

.catalogue-filters input,
.catalogue-filters select {
    height: 48px;
    min-width: 180px;

    padding: 0 18px;

    border: 1px solid #d8d2c8;
    border-radius: 999px;

    background: #fff;

    color: #4e443a;

    font-family: 'Cormorant Garamond', serif;
    font-size: 17px;

    outline: none;

    transition: all 0.3s ease;
}

.catalogue-filters input {
    min-width: 230px;
}

.catalogue-filters input::placeholder {
    color: #999;
}

.catalogue-filters input:focus,
.catalogue-filters select:focus {
    border-color: #b89b5e;
    background: #fff;

        box-shadow: 0 0 0 4px rgba(184, 155, 94, 0.12);
}

.filter-btn {
    height: 44px;
    border: 1px solid #111;
    background: #111;
    color: white;
    padding: 0 24px;
    cursor: pointer;
    font-family: 'Cormorant Garamond', serif;
    font-size: 16px;
    transition: 0.3s ease;
}

.filter-btn:hover {
    background: #b89b5e;
    border-color: #b89b5e;
}

.clear-filter-btn {
    height: 44px;
    border: 1px solid #d8d8d4;
    background: transparent;
    color: #333;
    padding: 0 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-family: 'Cormorant Garamond', serif;
    font-size: 16px;
    transition: 0.3s ease;
}

.clear-filter-btn:hover {
    border-color: #b89b5e;
    color: #b89b5e;
}

.search-result-text {
    margin-top: 12px;
    color: #666;
    font-size: 15px;
}

.search-result-text strong {
    color: #111;
}

.search-result-text a {
    margin-left: 10px;
    color: #b89b5e;
    text-decoration: underline;
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

    .catalogue-filters {
        padding: 16px;
        gap: 10px;
    }

    .catalogue-filters input,
    .catalogue-filters select,
    .filter-btn,
    .clear-filter-btn {
        width: 100%;
        min-width: 100%;
    }

    .clear-filter-btn {
        justify-content: center;
    }
}
    }
    
.catalogue-filters select {
    height: 40px;
    min-width: 180px;

    padding: 0 18px;

    border: 1px solid #d8d2c8;
    border-radius: 999px;

    background: #fff;

    color: #4e443a;

    font-family: 'Cormorant Garamond', serif;
    font-size: 17px;

    transition: all 0.3s ease;
}

.catalogue-filters select:focus {
    border-color: #b89b5e;
    box-shadow: 0 0 0 4px rgba(184, 155, 94, 0.12);
}

.catalogue-filters {
    margin: 20px 0 20px;
}

.filter-btn,
.clear-filter-btn {
    height: 40px;
    padding: 0 22px;

    border-radius: 999px;
    border: 1px solid #d8d2c8;

    font-family: 'Cormorant Garamond', serif;
    font-size: 17px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    text-decoration: none;
    cursor: pointer;

    transition: all 0.3s ease;
}

.filter-btn {
    background: #d7c3a3;
    border-color: #d7c3a3;
    color: #4e443a;
    margin-left: 15px;
}

.filter-btn:hover {
    background: #ccb089;
    border-color: #ccb089;

    box-shadow: 0 0 0 4px rgba(184, 155, 94, 0.12);
}

.clear-filter-btn {
    background: #fff;
    color: #4e443a;
    margin-left: 5px;
}

.clear-filter-btn:hover {
    border-color: #b89b5e;
    color: #b89b5e;

    box-shadow: 0 0 0 4px rgba(184, 155, 94, 0.12);
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

            @if(request('search') || request('category') || request('sort') || request('featured') || request('discount'))
    <div class="search-result-text">
        Showing filtered results

        @if(request('search'))
            for: <strong>{{ request('search') }}</strong>
        @endif

        <a href="{{ route('products.index') }}">Clear all</a>
    </div>
@endif
        </div>
    </div>

    <form action="{{ route('products.index') }}" method="GET" class="catalogue-filters">
    {{-- <input
        type="text"
        name="search"
        placeholder="Search products..."
        value="{{ request('search') }}"
    > --}}

    <select name="category">
        <option value="">All Categories</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>

    <select name="sort">
        <option value="">Newest</option>
        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>
            Price: Low to High
        </option>
        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>
            Price: High to Low
        </option>
        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>
            Name A-Z
        </option>
    </select>

    <select name="featured">
        <option value="">All Products</option>
        <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>
            Featured Only
        </option>
    </select>

    <select name="discount">
        <option value="">All Prices</option>
        <option value="1" {{ request('discount') == '1' ? 'selected' : '' }}>
            Discount Only
        </option>
    </select>

    <button type="submit" class="filter-btn">
        Apply
    </button>

    <a href="{{ route('products.index') }}" class="clear-filter-btn">
        Clear
    </a>
</form>

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