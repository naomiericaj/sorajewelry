@extends('layouts.app', ['title' => 'Add Product'])

@section('styles')
<style>
    .form-container {
        max-width: 850px;
        background: white;
        padding: 30px;
    }

    .form-title {
        font-size: 28px;
        font-weight: 400;
        margin-bottom: 25px;
    }

    label {
        display: block;
        margin-top: 16px;
        margin-bottom: 6px;
        font-size: 14px;
    }

    input,
    select,
    textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        background: #fff;
    }

    textarea {
        min-height: 120px;
    }

    .checkbox-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 18px;
    }

    .checkbox-row input {
        width: auto;
    }

    .button {
        margin-top: 25px;
        background: #111;
        color: white;
        padding: 14px 22px;
        border: none;
        cursor: pointer;
    }

    .back-link {
        display: inline-block;
        margin-top: 18px;
        color: #555;
    }

    .error {
        background: #f8d7da;
        color: #721c24;
        padding: 12px;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')

<div class="form-container">
    <h1 class="form-title">Add New Product</h1>

    @if ($errors->any())
        <div class="error">
            <strong>Please fix these errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Product Name</label>
        <input type="text" name="name" value="{{ old('name') }}" required>

        <label>Category</label>
        <select name="category_id" required>
            <option value="">-- Select Category --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <label>Collection</label>
        <select name="collection_id">
            <option value="">-- No Collection --</option>
            @foreach($collections as $collection)
                <option value="{{ $collection->id }}" {{ old('collection_id') == $collection->id ? 'selected' : '' }}>
                    {{ $collection->name }}
                </option>
            @endforeach
        </select>

        <label>Description</label>
        <textarea name="description">{{ old('description') }}</textarea>

        <label>Price</label>
        <input type="number" name="price" value="{{ old('price') }}" required>

        <label>Discount Price</label>
        <input type="number" name="discount_price" value="{{ old('discount_price') }}">

        <label>Stock</label>
        <input type="number" name="stock" value="{{ old('stock') }}" required>

        <label>Material</label>
        <input type="text" name="material" value="{{ old('material') }}" placeholder="Example: Stainless Steel">

        <label>Color</label>
        <input type="text" name="color" value="{{ old('color') }}" placeholder="Example: Silver">

        <label>Status</label>
        <select name="status" required>
            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>

        <div class="checkbox-row">
            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
            <span>Featured Product</span>
        </div>

        <label>Product Images</label>
        <input type="file" name="images[]" multiple required>

        <button type="submit" class="button">Save Product</button>
    </form>

    <a href="{{ route('admin.products.index') }}" class="back-link">← Back to Product List</a>
</div>

@endsection