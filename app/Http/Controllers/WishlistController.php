<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = Wishlist::with(['product.images'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlistItems'));
    }

    public function store(Request $request, Product $product)
    {
        Wishlist::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);

        if ($request->expectsJson()) {
            $wishlistCount = Wishlist::where('user_id', Auth::id())->count();

            return response()->json([
                'success' => true,
                'message' => 'Added to wishlist.',
                'wishlist_count' => $wishlistCount,
            ]);
        }

        return back()->with('success', 'Product added to wishlist.');
    }

    public function destroy(Request $request, Product $product)
    {
        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->delete();

        if ($request->expectsJson()) {
            $wishlistCount = Wishlist::where('user_id', Auth::id())->count();

            return response()->json([
                'success' => true,
                'message' => 'Removed from wishlist.',
                'wishlist_count' => $wishlistCount,
            ]);
        }

        return back()->with('success', 'Product removed from wishlist.');
    }
}