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

    // public function index(Request $request)
    // {
    //     $categories = Category::all();

    //     $query = Product::with(['images', 'category', 'collection'])
    //         ->where('status', 'active');

    //     if ($request->filled('category')) {
    //         $query->where('category_id', $request->category);
    //     }

    //     if ($request->availability === 'in_stock') {
    //         $query->where('stock', '>', 0);
    //     }

    //     if ($request->availability === 'out_of_stock') {
    //         $query->where('stock', '<=', 0);
    //     }

    //     if ($request->price === 'low_high') {
    //         $query->orderBy('price', 'asc');
    //     } elseif ($request->price === 'high_low') {
    //         $query->orderBy('price', 'desc');
    //     } elseif ($request->sort === 'popular') {
    //         $query->orderBy('view_count', 'desc');
    //     } elseif ($request->sort === 'name') {
    //         $query->orderBy('name', 'asc');
    //     } else {
    //         $query->latest();
    //     }

    //     if ($request->filled('search')) {
    //     $search = strtolower($request->search);

    //     $query->where(function ($q) use ($search) {
    //         $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
    //             ->orWhereRaw('LOWER(description) LIKE ?', ['%' . $search . '%'])
    //             ->orWhereRaw('LOWER(material) LIKE ?', ['%' . $search . '%'])
    //             ->orWhereRaw('LOWER(color) LIKE ?', ['%' . $search . '%']);
    //     });
    //     }

    //     $products = $query->latest()->paginate(20)->withQueryString();

    //     $products = Product::with(['category', 'collection', 'images'])
    //     ->where('status', 'active')
    //     ->latest()
    //     ->paginate(20);

    //     return view('products.index', compact('products', 'categories'));
    // }

    public function index(Request $request)
{
    $productsQuery = Product::with(['category', 'collection', 'images'])
        ->where('status', 'active');

    if ($request->filled('search')) {
        $search = $request->input('search');

        $productsQuery->where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('material', 'like', '%' . $search . '%')
                ->orWhere('color', 'like', '%' . $search . '%');
        });
    }

    if ($request->filled('category')) {
        $productsQuery->where('category_id', $request->category);
    }

    if ($request->filled('featured') && $request->featured == '1') {
        $productsQuery->where('is_featured', 1);
    }

    if ($request->filled('discount') && $request->discount == '1') {
        $productsQuery->whereNotNull('discount_price');
    }

    if ($request->filled('sort')) {
        if ($request->sort === 'price_low') {
            $productsQuery->orderByRaw('COALESCE(discount_price, price) ASC');
        } elseif ($request->sort === 'price_high') {
            $productsQuery->orderByRaw('COALESCE(discount_price, price) DESC');
        } elseif ($request->sort === 'name') {
            $productsQuery->orderBy('name', 'asc');
        } else {
            $productsQuery->latest();
        }
    } else {
        $productsQuery->latest();
    }

    $products = $productsQuery
        ->paginate(20)
        ->withQueryString();

    $categories = Category::orderBy('name')->get();

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