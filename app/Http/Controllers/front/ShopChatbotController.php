<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Throwable;

class ShopChatbotController extends Controller
{
    public function ask(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $message = trim($request->message);

        $prediction = $this->predictIntent($message);

        $intent = $prediction['intent'] ?? 'unknown';
        $confidence = (float)($prediction['confidence'] ?? 0);
        $modelReply = $prediction['reply'] ?? null;

        $reply = $this->replyByIntent($intent, $message, $modelReply);

        return response()->json([
            'status' => true,
            'intent' => $intent,
            'confidence' => $confidence,
            'reply' => $reply,
        ]);
    }

    private function predictIntent(string $message): array
    {
        try {
            $apiUrl = rtrim(env('CHATBOT_API_URL', 'http://127.0.0.1:8001'), '/');

            $response = Http::timeout(10)->post($apiUrl . '/predict', [
                'message' => $message,
            ]);

            if ($response->successful()) {
                return $response->json();
            }
        } catch (Throwable $exception) {
            // If Python API is not running, Laravel fallback will handle the reply.
        }

        return [
            'status' => false,
            'intent' => 'unknown',
            'confidence' => 0,
            'reply' => null,
        ];
    }

    private function replyByIntent(string $intent, string $message, ?string $modelReply): string
    {
        return match ($intent) {
            'greeting' => 'Hello! Welcome to our shop. How can I help you today?',
            'product_search' => $this->productSearchReply($message),
            'budget_products' => $this->budgetProductsReply($message),
            'latest_products' => $this->latestProductsReply(),
            'cart_checkout' => 'To buy a product, open the product page, click Add to Cart, then go to Cart and Checkout.',
            'order_status' => $this->orderStatusReply(),
            'order_cancel' => 'You can request order cancellation from your order page. If the order is already shipped, please contact support.',
            'return_refund' => 'You can request a return, refund, or exchange according to the store policy. Please keep your order ID and product details ready.',
            'payment_methods' => 'You can pay using the available payment methods on the checkout page. Options may include cash on delivery or online payment depending on store settings.',
            'shipping_info' => 'Delivery time and shipping charges depend on your location and product availability. You can check the final delivery cost at checkout.',
            'account_help' => 'Please use the login or register page. If you forgot your password, use the password reset option.',
            'contact_support' => 'You can contact support using the admin chat or contact option on the website.',
            'generic_shopping_advice' => 'I can help you choose a product. Please tell me your budget, product category, and main requirement.',
            'goodbye' => 'Thank you for visiting our shop. Have a nice day!',
            default => $modelReply ?: 'Sorry, I did not understand clearly. Please ask about products, orders, payment, shipping, returns, cart, account, or support.',
        };
    }

    private function productSearchReply(string $message): string
    {
        if (!Schema::hasTable('products')) {
            return 'Product table was not found in the database.';
        }

        $products = $this->searchProducts($message, null, false);

        if ($products->isEmpty()) {
            return 'I could not find matching products. Please try another product name or category.';
        }

        return "I found these products:\n\n" . $this->formatProducts($products);
    }

    private function budgetProductsReply(string $message): string
    {
        if (!Schema::hasTable('products')) {
            return 'Product table was not found in the database.';
        }

        $priceLimit = $this->extractPriceLimit($message);

        $products = $this->searchProducts($message, $priceLimit, true);

        if ($products->isEmpty()) {
            return 'I could not find budget-friendly products for your request.';
        }

        if ($priceLimit) {
            return "Here are products under {$priceLimit}:\n\n" . $this->formatProducts($products);
        }

        return "Here are some low-price products:\n\n" . $this->formatProducts($products);
    }

    private function latestProductsReply(): string
    {
        if (!Schema::hasTable('products')) {
            return 'Product table was not found in the database.';
        }

        $columns = Schema::getColumnListing('products');

        $query = DB::table('products');

        if (in_array('status', $columns)) {
            $query->where('status', 1);
        }

        if (in_array('created_at', $columns)) {
            $query->orderBy('created_at', 'desc');
        } elseif (in_array('id', $columns)) {
            $query->orderBy('id', 'desc');
        }

        $products = $query->limit(5)->get();

        if ($products->isEmpty()) {
            return 'No latest products are available right now.';
        }

        return "Here are the latest products:\n\n" . $this->formatProducts($products);
    }

    private function orderStatusReply(): string
    {
        if (!Auth::check()) {
            return 'Please login to your account first to check your order status.';
        }

        if (!Schema::hasTable('orders')) {
            return 'Order table was not found in the database.';
        }

        $columns = Schema::getColumnListing('orders');

        $query = DB::table('orders');

        if (in_array('user_id', $columns)) {
            $query->where('user_id', Auth::id());
        }

        if (in_array('created_at', $columns)) {
            $query->orderBy('created_at', 'desc');
        } elseif (in_array('id', $columns)) {
            $query->orderBy('id', 'desc');
        }

        $order = $query->first();

        if (!$order) {
            return 'I could not find any order in your account.';
        }

        $orderId = $order->id ?? 'N/A';
        $status = $order->status ?? $order->order_status ?? 'pending';
        $payment = $order->payment_status ?? 'not updated';
        $shipping = $order->shipping_status ?? $order->Shipping_status ?? 'not updated';
        $total = $order->grand_total ?? $order->grandtotal ?? $order->total ?? 0;

        return "Your latest order information:\n\n"
            . "Order ID: {$orderId}\n"
            . "Order Status: {$status}\n"
            . "Payment Status: {$payment}\n"
            . "Shipping Status: {$shipping}\n"
            . "Total: {$total}";
    }

    private function searchProducts(string $message, ?float $priceLimit = null, bool $budgetMode = false)
    {
        $columns = Schema::getColumnListing('products');

        $searchColumns = array_values(array_intersect([
            'title',
            'name',
            'en_title_translation',
            'ur_title_translation',
            'slug',
            'sku',
            'description',
        ], $columns));

        $priceColumn = $this->firstExistingColumn($columns, [
            'price',
            'sale_price',
            'compare_price',
            'regular_price',
        ]);

        $query = DB::table('products');

        if (in_array('status', $columns)) {
            $query->where('status', 1);
        }

        $keywords = $this->extractKeywords($message);

        if (!empty($keywords) && !empty($searchColumns)) {
            $query->where(function ($q) use ($keywords, $searchColumns) {
                foreach ($keywords as $word) {
                    foreach ($searchColumns as $column) {
                        $q->orWhere($column, 'LIKE', '%' . $word . '%');
                    }
                }
            });
        }

        if ($priceLimit && $priceColumn) {
            $query->where($priceColumn, '<=', $priceLimit);
        }

        if ($budgetMode && $priceColumn) {
            $query->orderBy($priceColumn, 'asc');
        } elseif (in_array('created_at', $columns)) {
            $query->orderBy('created_at', 'desc');
        } elseif (in_array('id', $columns)) {
            $query->orderBy('id', 'desc');
        }

        return $query->limit(5)->get();
    }

    private function formatProducts($products): string
    {
        $lines = [];

        foreach ($products as $index => $product) {
            $title = $this->productValue($product, [
                'title',
                'name',
                'en_title_translation',
                'ur_title_translation',
            ], 'Product');

            $price = $this->productValue($product, [
                'price',
                'sale_price',
                'compare_price',
                'regular_price',
            ], 'N/A');

            $stock = $this->productValue($product, [
                'qty',
                'stock',
                'quantity',
            ], null);

            $slug = $this->productValue($product, ['slug'], null);

            $url = $slug ? url('/product/' . $slug) : '';

            $line = ($index + 1) . ". {$title} - Price: {$price}";

            if ($stock !== null) {
                $line .= " - Stock: {$stock}";
            }

            if ($url) {
                $line .= "\n   Link: {$url}";
            }

            $lines[] = $line;
        }

        return implode("\n\n", $lines);
    }

    private function productValue($product, array $columns, $default = null)
    {
        foreach ($columns as $column) {
            if (isset($product->{$column}) && $product->{$column} !== '') {
                return $product->{$column};
            }
        }

        return $default;
    }

    private function firstExistingColumn(array $existingColumns, array $possibleColumns): ?string
    {
        foreach ($possibleColumns as $column) {
            if (in_array($column, $existingColumns)) {
                return $column;
            }
        }

        return null;
    }

    private function extractPriceLimit(string $message): ?float
    {
        if (preg_match('/(?:under|below|less than|upto|up to)\s+([0-9]+)/i', $message, $matches)) {
            return (float)$matches[1];
        }

        return null;
    }

    private function extractKeywords(string $message): array
    {
        $message = strtolower($message);
        $message = preg_replace('/[^a-z0-9\s]/', ' ', $message);
        $words = preg_split('/\s+/', $message);

        $stopWords = [
            'show', 'me', 'can', 'you', 'please', 'find', 'search',
            'product', 'products', 'item', 'items', 'under', 'below',
            'less', 'than', 'cheap', 'budget', 'affordable', 'latest',
            'new', 'the', 'a', 'an', 'i', 'want', 'need', 'do', 'have',
            'is', 'are', 'in', 'my', 'your', 'to', 'for', 'of',
        ];

        $keywords = [];

        foreach ($words as $word) {
            if (strlen($word) < 2) {
                continue;
            }

            if (in_array($word, $stopWords)) {
                continue;
            }

            if (is_numeric($word)) {
                continue;
            }

            $keywords[] = $word;
        }

        return array_values(array_unique($keywords));
    }
}