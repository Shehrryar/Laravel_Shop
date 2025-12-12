<?php
namespace App\Services;
use App\Models\Discount;
use Illuminate\Support\Collection;
class DiscountService
{
    public function getActiveDiscounts(): Collection
    {
        $today = now()->toDateString();
        return Discount::where('status', 1)
            ->whereDate('start_at', '<=', $today)
            ->whereDate('expires_at', '>=', $today)
            ->get();
    }
    public function applyDiscount(Collection $products, Collection $discounts): Collection
    {
        return $products->map(function ($product) use ($discounts) {
            $data = getDiscountedPrice($product->id, $discounts, $product->price);
            $product->discount_value = $data['discount_value'];
            $product->actual_price = $data['actual_price'];
            $product->discounted_price = $data['discounted_price'];
            return $product;
        });
    }
    public function getDiscountedProductIds(Collection $discounts): array
    {
        return $discounts->pluck('product_ids')
            ->map(fn($ids) => explode(',', trim($ids, '"')))
            ->flatten()
            ->unique()
            ->toArray();
    }
}