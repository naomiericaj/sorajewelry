<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Event;

class CheckoutController extends Controller
{
    public function index()
{
    $cart = Cart::where('user_id', Auth::id())->first();

    if (!$cart) {
        return redirect()->route('cart.index')->withErrors([
            'cart' => 'Your cart is empty.',
        ]);
    }

    $cartItems = CartItem::with(['product.images', 'variant'])
        ->where('cart_id', $cart->id)
        ->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('cart.index')->withErrors([
            'cart' => 'Your cart is empty.',
        ]);
    }

    $subtotal = $cartItems->sum(function ($item) {
        $price = $item->product->discount_price ?? $item->product->price;
        $variantPrice = $item->variant->additional_price ?? 0;

        return ($price + $variantPrice) * $item->quantity;
    });

    $shippingCost = 20000;
    $total = $subtotal + $shippingCost;

    return view('checkout.index', compact(
        'cartItems',
        'subtotal',
        'shippingCost',
        'total'
    ));
}

    public function store(Request $request)
{
    $request->validate([
        'receiver_name' => 'required|string|max:255',
        'receiver_phone' => 'required|string|max:30',
        'shipping_address' => 'required|string',
        'discount_code' => 'nullable|string',
    ]);


    $cart = Cart::where('user_id', Auth::id())->first();

    if (!$cart) {
        return redirect()->route('cart.index')->withErrors([
            'cart' => 'Your cart is empty.',
        ]);
    }

    $cartItems = CartItem::with(['product', 'variant'])
        ->where('cart_id', $cart->id)
        ->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('cart.index')->withErrors([
            'cart' => 'Your cart is empty.',
        ]);
    }

    $event = null;

    if ($request->filled('discount_code')) {

       $event = Event::where(
    'discount_code',
    $request->discount_code
)
->where('is_active', true)
->where('start_date', '<=', now())
->where(function ($query) {
    $query->whereNull('end_date')
          ->orWhere('end_date', '>=', now());
})
->first();

        if (!$event) {

            return back()
                ->withInput()
                ->withErrors([
                    'discount_code' =>
                        'Invalid or expired voucher code.'
                ]);
        }
    }

    $order = DB::transaction(function () use (
        $request,
        $cart,
        $cartItems,
        $event
    ) {

        $subtotal = $cartItems->sum(function ($item) {

            $price = $item->product->discount_price
                ?? $item->product->price;

            $variantPrice =
                $item->variant->additional_price ?? 0;

            return ($price + $variantPrice)
                * $item->quantity;
        });

        $shippingCost = 20000;

        $discountAmount = 0;
        $voucherCode = null;

        if ($event) {

            $voucherCode = $event->discount_code;

            $discountAmount =
                ($subtotal * $event->discount_percentage) / 100;
        }

        $total = $subtotal
            + $shippingCost
            - $discountAmount;

        $orderNumber =
            $this->generateUniqueOrderNumber();

        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => $orderNumber,

            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,

            'voucher_code' => $voucherCode,
            'discount_amount' => $discountAmount,

            'total_price' => $total,

            'order_status' => 'pending',

            'receiver_name' => $request->receiver_name,
            'receiver_phone' => $request->receiver_phone,
            'shipping_address' => $request->shipping_address,
        ]);

        foreach ($cartItems as $item) {

            $price = $item->product->discount_price
                ?? $item->product->price;

            $variantPrice =
                $item->variant->additional_price ?? 0;

            $finalPrice = $price + $variantPrice;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'product_variant_id' => $item->product_variant_id,
                'product_name' => $item->product->name,
                'price' => $finalPrice,
                'quantity' => $item->quantity,
                'total' => $finalPrice * $item->quantity,
            ]);
        }

        Payment::create([
            'order_id' => $order->id,
            'payment_method' => 'midtrans_snap',
            'payment_status' => 'pending',
            'midtrans_order_id' => $order->order_number,
            'transaction_id' => null,
            'amount' => $total,
            'payment_response' => null,
            'paid_at' => null,
        ]);

        CartItem::where('cart_id', $cart->id)
            ->delete();

        return $order;
    });

    return redirect()->route('payment.show', $order);
}

    private function generateUniqueOrderNumber(): string
    {
        do {
            $orderNumber = 'SOR-' 
                . now()->format('YmdHis') 
                . '-' 
                . Auth::id() 
                . '-' 
                . strtoupper(Str::random(10));
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}