<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;

class ChatbotController extends Controller
{
    public function reply(Request $request)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:500'],
        ]);

        $message = trim($validated['message']);

        $chatbotUrl = rtrim(
            config('services.chatbot.url', env('CHATBOT_API_URL', 'http://127.0.0.1:8000')),
            '/'
        );

        try {
            $response = Http::timeout(3)->post($chatbotUrl . '/chat', [
                'message' => $message,
            ]);

            if ($response->successful()) {
                $payload = $response->json();

                return response()->json([
                    'status' => true,
                    'source' => 'python-chatbot',
                    'category' => $payload['category'] ?? null,
                    'reply' => $payload['reply'] ?? 'I received your message.',
                ]);
            }
        } catch (Throwable $exception) {
            // If Python chatbot is not running, Laravel fallback will reply.
        }

        $fallback = $this->fallbackReply($message);

        return response()->json([
            'status' => true,
            'source' => 'laravel-fallback',
            'category' => $fallback['category'],
            'reply' => $fallback['reply'],
            'products' => $fallback['products'] ?? [],
        ]);
    }

    private function fallbackReply(string $message): array
    {
        $text = strtolower($message);

        if ($this->containsAny($text, ['order', 'track', 'delivery', 'shipping'])) {
            return [
                'category' => 'order',
                'reply' => 'Please open My Orders from your profile to check your order status. If you have an order ID, share it with support.',
            ];
        }

        if ($this->containsAny($text, ['return', 'refund', 'exchange', 'replace'])) {
            return [
                'category' => 'return',
                'reply' => 'You can request a return or exchange according to the store return policy. Please keep your order details ready.',
            ];
        }

        if ($this->containsAny($text, ['installment', 'instalment', 'emi', 'monthly payment'])) {
            return [
                'category' => 'installment',
                'reply' => 'Yes, installment support is available for eligible products. Check the product or checkout page for payment options.',
            ];
        }

        if ($this->containsAny($text, ['budget', 'cheap', 'low price', 'affordable', 'less price'])) {
            $products = Product::where('status', 1)
                ->with('product_images')
                ->orderBy('price')
                ->limit(3)
                ->get(['id', 'title', 'slug', 'price']);

            $names = $products->pluck('title')->filter()->values()->implode(', ');

            return [
                'category' => 'budget',
                'reply' => $names
                    ? 'Some budget-friendly products are: ' . $names . '. You can also use the search page for more options.'
                    : 'You can use the search page and sort/filter products to find budget-friendly items.',
                'products' => $products,
            ];
        }

        if ($this->containsAny($text, ['game', 'gaming', 'gamer', 'controller', 'keyboard', 'mouse'])) {
            $products = Product::where('status', 1)
                ->where(function ($query) {
                    $query->whereRaw('LOWER(title) LIKE ?', ['%game%'])
                        ->orWhereRaw('LOWER(title) LIKE ?', ['%gaming%'])
                        ->orWhereRaw('LOWER(title) LIKE ?', ['%keyboard%'])
                        ->orWhereRaw('LOWER(title) LIKE ?', ['%mouse%']);
                })
                ->with('product_images')
                ->limit(3)
                ->get(['id', 'title', 'slug', 'price']);

            $names = $products->pluck('title')->filter()->values()->implode(', ');

            return [
                'category' => 'game',
                'reply' => $names
                    ? 'Gaming-related products I found: ' . $names . '.'
                    : 'We may have gaming products available. Please search for gaming, keyboard, mouse, or controller.',
                'products' => $products,
            ];
        }

        if ($this->containsAny($text, ['search', 'find', 'product', 'price'])) {
            return [
                'category' => 'search',
                'reply' => 'Use the search icon at the top of the shop to search products by title, brand, SKU, or price.',
            ];
        }

        return [
            'category' => 'unknown',
            'reply' => 'Sorry, I did not understand clearly. You can ask about orders, returns, budget products, gaming products, installments, or product search.',
        ];
    }

    private function containsAny(string $text, array $keywords): bool
    {
        foreach ($keywords as $keyword) {
            if (str_contains($text, $keyword)) {
                return true;
            }
        }
        return false;
    }
}