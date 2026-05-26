@extends('layouts.app', ['title' => 'Edit Product - Sora Jewelry'])

@section('styles')
<style>
    .edit-product-page {
        padding: 48px 38px 80px;
        background: #f8f8f6;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: end;
        margin-bottom: 35px;
    }

    .title {
        font-family: Georgia, serif;
        font-size: 38px;
        font-weight: 400;
        margin: 0;
    }

    .subtitle {
        color: #666;
        margin-top: 8px;
    }

    .back-link {
        text-decoration: underline;
        font-size: 14px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 420px;
        gap: 28px;
        align-items: start;
    }

    .box {
        background: white;
        padding: 28px;
        margin-bottom: 22px;
    }

    .box-title {
        font-size: 20px;
        margin-bottom: 22px;
        font-weight: 400;
    }

    .form-group {
        margin-bottom: 18px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #333;
        font-size: 14px;
    }

    input,
    select,
    textarea {
        width: 100%;
        border: 1px solid #d8d8d4;
        background: transparent;
        padding: 14px;
        font-size: 15px;
    }

    textarea {
        min-height: 140px;
        resize: vertical;
    }

    .two-col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .checkbox-row {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .checkbox-row input {
        width: auto;
    }

    .image-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .image-card {
        background: #f1f1ee;
        border: 1px solid #e1e1dd;
        padding: 10px;
    }

    .image-card img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        display: block;
    }

    .main-badge {
        display: inline-block;
        margin-top: 8px;
        padding: 5px 9px;
        background: black;
        color: white;
        font-size: 12px;
    }

    .submit-btn {
        width: 100%;
        height: 58px;
        background: #111;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 15px;
        margin-top: 10px;
    }

    .note {
        color: #666;
        font-size: 13px;
        line-height: 1.6;
        margin-top: 10px;
    }

    @media (max-width: 950px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .two-col {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

<section class="edit-product-page">
    <div class="page-header">
        <div>
            <h1 class="title">Edit Product</h1>
            <div class="subtitle">Update product details, price, stock, status, and images.</div>
        </div>

        <a href="{{ route('admin.products.index') }}" class="back-link">Back to products</a>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="form-grid">
            <div>
                <div class="box">
                    <h2 class="box-title">Product Information</h2>

                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="two-col">
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category_id" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Collection</label>
                            <select name="collection_id">
                                <option value="">No collection</option>

                                @foreach($collections as $collection)
                                    <option value="{{ $collection->id }}" {{ old('collection_id', $product->collection_id) == $collection->id ? 'selected' : '' }}>
                                        {{ $collection->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="two-col">
                        <div class="form-group">
                            <label>Material</label>
                            <input type="text" name="material" value="{{ old('material', $product->material) }}" placeholder="Silver, gold plated, pearl...">
                        </div>

                        <div class="form-group">
                            <label>Color</label>
                            <input type="text" name="color" value="{{ old('color', $product->color) }}" placeholder="Silver, gold, rose gold...">
                        </div>
                    </div>
                </div>

                <div class="box">
                    <h2 class="box-title">Pricing & Inventory</h2>

                    <div class="two-col">
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0" step="1000" required>
                        </div>

                        <div class="form-group">
                            <label>Discount Price</label>
                            <input type="number" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}" min="0" step="1000">
                        </div>
                    </div>

                    <div class="two-col">
                        <div class="form-group">
                            <label>Stock</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" required>
                                <option value="active" {{ old('status', $product->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $product->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="checkbox-row">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                        <label style="margin:0;">Featured product</label>
                    </div>
                </div>

                <div class="box">
                    <h2 class="box-title">Add New Images</h2>

                    <div class="form-group">
                        <label>Upload additional product images</label>
                        <input type="file" name="images[]" multiple accept="image/*">
                        <div class="note">
                            Existing images will remain saved. New images will be added to this product.
                        </div>
                    </div>
                </div>
            </div>

            <aside>
                <div class="box">
                    <h2 class="box-title">Current Images</h2>

                    @if($product->images->isEmpty())
                        <p class="note">No images uploaded yet.</p>
                    @else
                        <div class="image-grid">
                            @foreach($product->images as $image)
                                <div class="image-card">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}">

                                    @if($image->is_main)
                                        <span class="main-badge">Main Image</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="box">
                    <h2 class="box-title">Save Changes</h2>
                    <p class="note">
                        Click save to update the product. The catalogue and product detail page will use the newest product data.
                    </p>

                    <button type="submit" class="submit-btn">
                        Save Product Changes
                    </button>
                </div>
            </aside>
        </div>
    </form>
</section>

@endsection