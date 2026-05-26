<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function home()
    {
        $featuredProducts = Product::with('images')
            ->where('status', 'active')
            ->where('is_featured', 1)
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('featuredProducts'));
    }

    public function index(Request $request)
    {
        $categories = Category::all();

        $query = Product::with(['images', 'category', 'collection'])
            ->where('status', 'active');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->availability === 'in_stock') {
            $query->where('stock', '>', 0);
        }

        if ($request->availability === 'out_of_stock') {
            $query->where('stock', '<=', 0);
        }

        if ($request->price === 'low_high') {
            $query->orderBy('price', 'asc');
        } elseif ($request->price === 'high_low') {
            $query->orderBy('price', 'desc');
        } elseif ($request->sort === 'popular') {
            $query->orderBy('view_count', 'desc');
        } elseif ($request->sort === 'name') {
            $query->orderBy('name', 'asc');
        } else {
            $query->latest();
        }

        $products = $query->paginate(20)->withQueryString();

        $products = Product::with(['category', 'collection', 'images'])
        ->where('status', 'active')
        ->latest()
        ->paginate(20);

        return view('products.index', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::with(['images', 'category', 'collection', 'variants'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $product->increment('view_count');

        ProductView::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'session_id' => session()->getId(),
        ]);

        $recommendedProducts = Product::with('images')
            ->where('status', 'active')
            ->where('id', '!=', $product->id)
            ->where(function ($query) use ($product) {
                $query->where('category_id', $product->category_id)
                    ->orWhere('collection_id', $product->collection_id);
            })
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'recommendedProducts'));
    }
}