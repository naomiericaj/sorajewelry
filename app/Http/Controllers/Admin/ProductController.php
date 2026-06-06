<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // public function index()
    // {
    //     $products = Product::with(['category', 'collection', 'mainImage'])
    //         ->latest()
    //         ->paginate(15);

    //     return view('admin.products.index', compact('products'));
    // }

    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $products = Product::with(['category', 'collection', 'images'])
            ->latest()
            ->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $collections = Collection::all();

        return view('admin.products.create', compact('categories', 'collections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'collection_id' => 'nullable|exists:collections,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'material' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'nullable',
            'images' => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp,heic|max:10240',
        ]);

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug.'-'.$counter;
            $counter++;
        }

        $product = Product::create([
            'category_id' => $request->category_id,
            'collection_id' => $request->collection_id,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock' => $request->stock,
            'material' => $request->material,
            'color' => $request->color,
            'status' => $request->status,
            'is_featured' => $request->has('is_featured') ? 1 : 0,
            'view_count' => 0,
            'sold_count' => 0,
        ]);

        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('', 'public_images');

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'processed_image_path' => null,
                'is_main' => $index === 0 ? 1 : 0,
            ]);
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product added successfully.');
    }

    //     public function edit(Product $product)
    // {
    //     if (auth()->user()->role !== 'admin') {
    //         abort(403);
    //     }

    //     $categories = Category::all();
    //     $collections = Collection::all();

    //     $product->load(['images', 'variants', 'category', 'collection']);

    //     return view('admin.products.edit', compact('product', 'categories', 'collections'));
    // }

    // public function update(Request $request, Product $product)
    // {
    //     if (auth()->user()->role !== 'admin') {
    //         abort(403);
    //     }

    //     $request->validate([
    //         'category_id' => 'required|exists:categories,id',
    //         'collection_id' => 'nullable|exists:collections,id',
    //         'name' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'price' => 'required|numeric|min:0',
    //         'discount_price' => 'nullable|numeric|min:0',
    //         'stock' => 'required|integer|min:0',
    //         'material' => 'nullable|string|max:255',
    //         'color' => 'nullable|string|max:255',
    //         'status' => 'required|in:active,inactive',
    //         'is_featured' => 'nullable|boolean',
    //         'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
    //     ]);

    //     $product->update([
    //         'category_id' => $request->category_id,
    //         'collection_id' => $request->collection_id,
    //         'name' => $request->name,
    //         'slug' => Str::slug($request->name) . '-' . $product->id,
    //         'description' => $request->description,
    //         'price' => $request->price,
    //         'discount_price' => $request->discount_price,
    //         'stock' => $request->stock,
    //         'material' => $request->material,
    //         'color' => $request->color,
    //         'status' => $request->status,
    //         'is_featured' => $request->has('is_featured') ? 1 : 0,
    //     ]);

    //     if ($request->hasFile('images')) {
    //         foreach ($request->file('images') as $index => $image) {
    //             $path = $image->store('products', 'public');

    //             ProductImage::create([
    //                 'product_id' => $product->id,
    //                 'image_path' => $path,
    //                 'processed_image_path' => null,
    //                 'is_main' => $product->images()->count() === 0 && $index === 0 ? 1 : 0,
    //             ]);
    //         }
    //     }

    //     return redirect()
    //         ->route('admin.products.index')
    //         ->with('success', 'Product updated successfully.');
    // }

    public function deleteImage(ProductImage $image)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $product = $image->product;

        if (! $product) {
            return back()->withErrors([
                'image' => 'Product not found for this image.',
            ]);
        }

        $wasMain = (bool) $image->is_main;

        try {
            if ($image->image_path && Storage::disk('public_images')->exists($image->image_path)) {
                Storage::disk('public_images')->delete($image->image_path);
            }

            if ($image->processed_image_path && Storage::disk('public_images')->exists($image->processed_image_path)) {
                Storage::disk('public_images')->delete($image->processed_image_path);
            }

            $image->delete();

            if ($wasMain) {
                $newMainImage = $product->images()->oldest()->first();

                if ($newMainImage) {
                    $newMainImage->update([
                        'is_main' => 1,
                    ]);
                }
            }

            return back()->with('success', 'Product image deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'image' => 'Image could not be deleted: '.$e->getMessage(),
            ]);
        }
    }

    public function setMainImage(ProductImage $image)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        try {
            ProductImage::where('product_id', $image->product_id)->update([
                'is_main' => 0,
            ]);

            $image->update([
                'is_main' => 1,
            ]);

            return back()->with('success', 'Main image changed successfully.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'image' => 'Main image could not be changed: '.$e->getMessage(),
            ]);
        }
    }

    public function edit(Product $product)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $categories = Category::all();
        $collections = Collection::all();

        $product->load(['images', 'category', 'collection']);

        return view('admin.products.edit', compact('product', 'categories', 'collections'));
    }

    public function update(Request $request, Product $product)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'collection_id' => 'nullable|exists:collections,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'material' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'nullable|boolean',
        ]);

        $product->update([
            'category_id' => $request->category_id,
            'collection_id' => $request->collection_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name).'-'.$product->id,
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock' => $request->stock,
            'material' => $request->material,
            'color' => $request->color,
            'status' => $request->status,
            'is_featured' => $request->has('is_featured') ? 1 : 0,
        ]);

        return back()->with('success', 'Product details updated successfully.');
    }

    public function storeImages(Request $request, Product $product)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'images' => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('', 'public_images');

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'processed_image_path' => null,
                'is_main' => $product->images()->count() === 0 && $index === 0 ? 1 : 0,
            ]);
        }

        return back()->with('success', 'Product images added successfully.');
    }
}
