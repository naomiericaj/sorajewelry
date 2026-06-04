<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiChatbotController extends Controller
{
    public function message(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $userMessage = trim($request->message);

        /*
         |--------------------------------------------------------------------------
         | 1. Try local smart reply first
         |--------------------------------------------------------------------------
         | This makes the chatbot useful even when Gemini free limit is reached.
         */
        $localReply = $this->localReply($userMessage);

        if ($localReply) {
            return response()->json([
                'reply' => $localReply,
            ]);
        }

        /*
         |--------------------------------------------------------------------------
         | 2. Try Gemini only for questions local reply cannot answer
         |--------------------------------------------------------------------------
         */
        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            return response()->json([
                'reply' => $this->fallbackReply(),
            ]);
        }

        $systemPrompt = "
You are Sora Assistant, the customer service chatbot for Sora Jewelry.
Sora Jewelry sells minimalist jewelry such as necklaces, rings, bracelets, and earrings.
Answer briefly and politely.
Help customers with products, payment, shipping, returns, refunds, and order questions.
Payment is handled through Midtrans.
If the customer asks something unrelated, guide them back to Sora Jewelry topics.
";

        try {
            $response = Http::timeout(30)->post(
                'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $apiKey,
                [
                    'contents' => [
                        [
                            'parts' => [
                                [
                                    'text' => $systemPrompt . "\n\nCustomer question: " . $userMessage
                                ]
                            ]
                        ]
                    ]
                ]
            );

            if ($response->successful()) {
                $reply = $response->json('candidates.0.content.parts.0.text');

                return response()->json([
                    'reply' => $reply ?? $this->fallbackReply(),
                ]);
            }

            Log::error('Gemini API Error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            if ($response->status() === 429) {
                return response()->json([
                    'reply' => $this->fallbackReply(),
                ]);
            }

            return response()->json([
                'reply' => $this->fallbackReply(),
            ]);
        } catch (\Exception $e) {
            Log::error('Chatbot Exception', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'reply' => $this->fallbackReply(),
            ]);
        }
    }

    private function localReply($message)
    {
        $message = strtolower($message);

        if ($this->contains($message, ['hello', 'hi', 'hey', 'halo'])) {
            return $this->randomReply([
                'Hi! Welcome to Sora Jewelry. I can help you find products, understand payment, shipping, returns, or order help.',
                'Hello! I’m Sora Assistant. You can ask me about our jewelry, catalogue, payment, or delivery.',
                'Hi there! Looking for rings, necklaces, bracelets, or earrings? I can help you browse.',
            ]);
        }

        if ($this->contains($message, ['payment', 'pay', 'midtrans', 'qris', 'transfer', 'paid'])) {
            return $this->randomReply([
                'We use Midtrans for secure online payment. If your order is still pending, open My Orders and click Pay Now.',
                'Payment is handled through Midtrans. After checkout, you can complete the payment directly. Pending orders can still be paid from My Orders.',
                'If your payment did not finish, go to My Orders and press Pay Now on the pending order.',
            ]);
        }

        if ($this->contains($message, ['shipping', 'delivery', 'ship', 'send', 'ongkir'])) {
            return $this->randomReply([
                'Shipping is calculated during checkout. After your payment succeeds, our team will process the order.',
                'Delivery cost depends on your checkout details. Once payment is successful, the order status will move forward.',
                'You can see shipping details at checkout. Paid orders will be processed by the store team.',
            ]);
        }

        if ($this->contains($message, ['refund', 'return', 'exchange', 'cancel'])) {
            return $this->randomReply([
                'For refunds, returns, or exchanges, please contact us through the Contact page and include your order number.',
                'Return or refund requests are handled through customer support. Please send your order number through the Contact page.',
                'If there is an issue with your order, contact our team and include your order number so we can check it.',
            ]);
        }

        if ($this->contains($message, ['contact', 'admin', 'support', 'help'])) {
            return $this->randomReply([
                'You can contact us through the Contact page. If it is about an order, please include your order number.',
                'Our support can be reached from the Contact page. Please explain your issue clearly.',
                'For order help, use the Contact page and include your order number.',
            ]);
        }

        if ($this->contains($message, ['necklace', 'ring', 'bracelet', 'earring', 'product', 'catalogue', 'jewelry', 'jewellery'])) {
            return $this->productReply($message);
        }

        if ($this->contains($message, ['cheap', 'affordable', 'discount', 'sale', 'promo'])) {
            return $this->discountProductReply();
        }

        if ($this->contains($message, ['featured', 'popular', 'best'])) {
            return $this->featuredProductReply();
        }

        return null;
    }

    private function productReply($message)
    {
        $query = Product::where('status', 'active');

        if (str_contains($message, 'necklace')) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%necklace%']);
        } elseif (str_contains($message, 'ring')) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%ring%']);
        } elseif (str_contains($message, 'bracelet')) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%bracelet%']);
        } elseif (str_contains($message, 'earring')) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%earring%']);
        }

        $products = $query->latest()->take(3)->get();

        if ($products->isEmpty()) {
            return 'I could not find matching products right now. You can browse the full catalogue here: ' . route('products.index');
        }

        $reply = "Here are some products you may like:\n\n";

        foreach ($products as $product) {
            $price = $product->discount_price ?? $product->price;

            $reply .= $product->name . "\n";
            $reply .= "Price: Rp " . number_format($price, 0, ',', '.') . "\n";
            $reply .= route('products.show', $product->slug) . "\n\n";
        }

        return $reply;
    }

    private function discountProductReply()
    {
        $products = Product::where('status', 'active')
            ->whereNotNull('discount_price')
            ->latest()
            ->take(3)
            ->get();

        if ($products->isEmpty()) {
            return 'There are no discounted products right now, but you can still browse the full catalogue here: ' . route('products.index');
        }

        $reply = "These products currently have discounted prices:\n\n";

        foreach ($products as $product) {
            $reply .= $product->name . "\n";
            $reply .= "Now: Rp " . number_format($product->discount_price, 0, ',', '.') . "\n";
            $reply .= "Before: Rp " . number_format($product->price, 0, ',', '.') . "\n";
            $reply .= route('products.show', $product->slug) . "\n\n";
        }

        return $reply;
    }

    private function featuredProductReply()
    {
        $products = Product::where('status', 'active')
            ->where('is_featured', 1)
            ->latest()
            ->take(3)
            ->get();

        if ($products->isEmpty()) {
            return 'There are no featured products right now. You can browse the catalogue here: ' . route('products.index');
        }

        $reply = "Here are some featured products:\n\n";

        foreach ($products as $product) {
            $reply .= $product->name . "\n";
            $reply .= "Price: Rp " . number_format($product->discount_price ?? $product->price, 0, ',', '.') . "\n";
            $reply .= route('products.show', $product->slug) . "\n\n";
        }

        return $reply;
    }

    private function fallbackReply()
    {
        return $this->randomReply([
            'I can help with Sora Jewelry products, payment, shipping, returns, and order questions. Try asking “show me rings” or “how do I pay?”',
            'I could not find an exact answer, but I can help you browse products or explain payment and shipping.',
            'Please ask me about products, payment, shipping, refunds, or order help. For example: “show me necklaces” or “payment help”.',
        ]);
    }

    private function randomReply(array $replies)
    {
        return $replies[array_rand($replies)];
    }

    private function contains($message, array $words)
    {
        foreach ($words as $word) {
            if (str_contains($message, $word)) {
                return true;
            }
        }

        return false;
    }
}