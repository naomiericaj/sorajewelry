<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private function getCart()
    {
        return Cart::firstOrCreate([
            'user_id' => Auth::id(),
        ]);
    }

    public function index()
    {
        $cart = $this->getCart();

        $cartItems = CartItem::with(['product.images', 'variant'])
            ->where('cart_id', $cart->id)
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            $price = $item->product->discount_price ?? $item->product->price;
            $variantPrice = $item->variant->additional_price ?? 0;

            return ($price + $variantPrice) * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'subtotal'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'product_variant_id' => 'nullable|exists:product_variants,id',
        ]);

        if ($product->stock < $request->quantity) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available.',
                ], 422);
            }

            return back()->withErrors([
                'quantity' => 'Not enough stock available.',
            ]);
        }

        $cart = $this->getCart();

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->where('product_variant_id', $request->product_variant_id)
            ->first();

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $request->quantity,
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'product_variant_id' => $request->product_variant_id,
                'quantity' => $request->quantity,
            ]);
        }

        if ($request->expectsJson()) {
            $cartCount = $cart->items()->sum('quantity');

            return response()->json([
                'success' => true,
                'message' => 'Added to cart.',
                'cart_count' => $cartCount,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated.',
        ]);
    }

 public function destroy(CartItem $cartItem)
{
    $cartItem->delete();

    return redirect()
        ->route('cart.index')
        ->with('success', 'Item removed from cart.');
}
}
