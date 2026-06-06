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
        grid-template-columns: 1fr 460px;
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

    .upload-btn {
        width: 100%;
        height: 54px;
        background: #111;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 15px;
        margin-top: 14px;
    }

    .note {
        color: #666;
        font-size: 13px;
        line-height: 1.6;
        margin-top: 10px;
    }

    .image-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
    }

    .image-card {
        background: #f1f1ee;
        border: 1px solid #e1e1dd;
        padding: 10px;
    }

    .image-card img {
        width: 100%;
        height: 170px;
        object-fit: cover;
        display: block;
        background: #eee;
    }

    .main-badge {
        display: block;
        text-align: center;
        margin-top: 10px;
        padding: 8px 10px;
        background: #111;
        color: white;
        font-size: 12px;
    }

    .image-actions {
        display: grid;
        grid-template-columns: 1fr;
        gap: 8px;
        margin-top: 10px;
    }

    .small-btn {
        width: 100%;
        height: 38px;
        border: 1px solid #111;
        background: transparent;
        color: #111;
        cursor: pointer;
        font-size: 13px;
    }

    .danger-btn {
        border-color: #8b0000;
        color: #8b0000;
    }

    .danger-btn:hover {
        background: #8b0000;
        color: white;
    }

    .main-preview {
        background: #f1f1ee;
        padding: 12px;
        margin-bottom: 18px;
    }

    .main-preview img {
        width: 100%;
        height: 260px;
        object-fit: cover;
        display: block;
    }

    .main-preview-label {
        margin-top: 10px;
        font-size: 13px;
        color: #555;
        text-align: center;
    }

    @media (max-width: 1000px) {
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
            <div class="subtitle">
                Update product details, upload images, delete images, and choose the main image.
            </div>
        </div>

        <a href="{{ route('admin.products.index') }}" class="back-link">Back to products</a>
    </div>

    <div class="form-grid">
        <div>
            <form action="{{ route('admin.products.update', $product) }}" method="POST">
                @csrf
                @method('PATCH')

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
                    <h2 class="box-title">Save Product Details</h2>

                    <p class="note">
                        This saves product name, category, price, stock, status, and description.
                        Product images are managed separately on the right.
                    </p>

                    <button type="submit" class="submit-btn">
                        Save Product Details
                    </button>
                </div>
            </form>
        </div>

        <aside>
            <div class="box">
                <h2 class="box-title">Upload Product Images</h2>

                <form action="{{ route('admin.products.images.store', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>Select Images</label>
                        <input type="file" name="images[]" multiple accept="image/*" required>

                        <div class="note">
                            You can upload as many product images as you want. If this product has no images yet, the first uploaded image will become the main image automatically.
                        </div>
                    </div>

                    <button type="submit" class="upload-btn">
                        Add Images
                    </button>
                </form>
            </div>

            <div class="box">
                <h2 class="box-title">Main Image Preview</h2>

                @php
                    $mainImage = $product->images->where('is_main', 1)->first();
                @endphp

                @if($mainImage)
                    <div class="main-preview">
                        <img src="{{ asset('images/' . $mainImage->image_path) }}" alt="{{ $product->name }}">
                        <div class="main-preview-label">Currently selected main image</div>
                    </div>
                @else
                    <p class="note">
                        No main image selected yet. Upload images first, then choose one as the main image.
                    </p>
                @endif
            </div>

            <div class="box">
                <h2 class="box-title">All Product Images</h2>

                @if($product->images->isEmpty())
                    <p class="note">
                        No images uploaded yet. Use the upload box above to add product images.
                    </p>
                @else
                    <div class="image-grid">
                        @foreach($product->images as $image)
                            <div class="image-card">
                                <img src="{{ asset('images/' . $image->image_path) }}" alt="{{ $product->name }}">

                                @if($image->is_main)
                                    <span class="main-badge">Main Image</span>
                                @else
                                    <div class="image-actions">
                                        <form action="{{ route('admin.products.images.main', $image) }}" method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" class="small-btn">
                                                Make Main Image
                                            </button>
                                        </form>
                                    </div>
                                @endif

                                <div class="image-actions">
                                    <form action="{{ route('admin.products.images.delete', $image) }}" method="POST" onsubmit="return confirm('Delete this image?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="small-btn danger-btn">
                                            Delete Image
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </aside>
    </div>
</section>

@endsection