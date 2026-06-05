@extends('layouts.app', ['title' => 'Admin Products'])

@section('styles')
<style>
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .admin-title {
        font-size: 28px;
        font-weight: 400;
    }

    .button {
        background: #111;
        color: white;
        padding: 12px 18px;
        border: none;
        text-decoration: none;
        cursor: pointer;
    }

    .success {
        background: #d4edda;
        color: #155724;
        padding: 12px;
        margin-bottom: 20px;
    }

    .admin-table-wrapper {
        width: 100%;
        overflow-x: auto;
        background: white;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    th,
    td {
        padding: 14px;
        border-bottom: 1px solid #e5e5e5;
        text-align: left;
        font-size: 14px;
        vertical-align: middle;
    }

    th {
        background: #f0f0ee;
        font-weight: 500;
    }

    .product-image-cell {
        width: 90px;
    }

    .thumb {
        width: 70px !important;
        height: 70px !important;
        max-width: 70px !important;
        max-height: 70px !important;
        min-width: 70px !important;
        min-height: 70px !important;
        object-fit: cover !important;
        display: block !important;
        background: #eee;
        border: 1px solid #e1e1dd;
    }

    .no-image-thumb {
        width: 70px;
        height: 70px;
        background: #eee;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        font-size: 12px;
        border: 1px solid #e1e1dd;
        text-align: center;
    }

    .edit-btn {
        display: inline-block;
        padding: 9px 14px;
        background: #111;
        color: white;
        text-decoration: none;
        font-size: 13px;
    }

    .edit-btn:hover {
        background: #333;
    }

    .pagination {
        margin-top: 25px;
        display: flex;
        justify-content: center;
    }

    .pagination nav {
        width: 100%;
    }

    .pagination svg {
        width: 18px !important;
        height: 18px !important;
        max-width: 18px !important;
        max-height: 18px !important;
    }

    .pagination p {
        font-size: 14px;
        color: #666;
    }

    .pagination a,
    .pagination span {
        font-size: 14px;
    }

    .pagination > * {
        max-width: 100%;
    }

    @media (max-width: 800px) {
        .admin-header {
            display: block;
        }

        .button {
            display: inline-block;
            margin-top: 14px;
        }

        th,
        td {
            padding: 10px;
            font-size: 13px;
        }

        .thumb,
        .no-image-thumb {
            width: 60px !important;
            height: 60px !important;
            max-width: 60px !important;
            max-height: 60px !important;
            min-width: 60px !important;
            min-height: 60px !important;
        }
    }
</style>
@endsection

@section('content')

<div class="admin-header">
    <h1 class="admin-title">Admin Products</h1>
    <a href="{{ route('admin.products.create') }}" class="button">+ Add Product</a>
</div>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

<div class="admin-table-wrapper">
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Category</th>
                <th>Collection</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Featured</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($products as $product)
                <tr>
                    <td class="product-image-cell">
                        @php
                            $image = $product->images->where('is_main', 1)->first() ?? $product->images->first();
                        @endphp

                        @if($image)
                            <img
                                src="{{ asset('storage/' . $image->image_path) }}"
                                alt="{{ $product->name }}"
                                class="thumb"
                            >
                        @else
                            <div class="no-image-thumb">
                                No Image
                            </div>
                        @endif
                    </td>

                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td>{{ $product->collection->name ?? '-' }}</td>
                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ ucfirst($product->status) }}</td>
                    <td>{{ $product->is_featured ? 'Yes' : 'No' }}</td>

                    <td>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="edit-btn">
                            Edit
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="pagination">
    {{ $products->links() }}
</div>

@endsection