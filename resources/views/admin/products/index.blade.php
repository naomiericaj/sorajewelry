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
    }

    th {
        background: #f0f0ee;
        font-weight: 500;
    }

    .thumb {
        width: 70px;
        height: 70px;
        object-fit: cover;
        background: #eee;
    }

    .pagination {
        margin-top: 25px;
    }

    .edit-btn {
    display: inline-block;
    padding: 9px 14px;
    background: #111;
    color: white;
    text-decoration: none;
    font-size: 13px;
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
                <td>
                    @php
    $image = $product->images->where('is_main', 1)->first() ?? $product->images->first();
@endphp

@if($image)
    <img src="{{ asset('images/' . $image->image_path) }}" alt="{{ $product->name }}">
@else
    <div style="width:80px;height:80px;background:#eee;display:flex;align-items:center;justify-content:center;color:#999;font-size:12px;">
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
                    Edit</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="pagination">
    {{ $products->links() }}
</div>

@endsection