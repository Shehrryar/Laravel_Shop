<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductView;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    public function featuredProducts()
    {
        return Product::where('is_featured', 1)
            ->where('status', 1)
            ->with('product_images')
            ->withCount('product_ratings')
            ->withSum('product_ratings', 'rating')
            ->get();
    }

    public function latestProducts()
    {
        return Product::where('status', 1)
            ->with('product_images')
            ->orderByDesc('id')
            ->withCount('product_ratings')
            ->withSum('product_ratings', 'rating')
            ->paginate(8);
    }

    public function discountedProducts(array $ids)
    {
        return Product::where('status', 1)
            ->whereIn('id', $ids)
            ->with('product_images')
            ->withCount('product_ratings')
            ->withSum('product_ratings', 'rating')
            ->get(8);
    }

    public function recommendedProducts()
    {
        $ids = ProductView::where('user_id', Auth::id())
            ->pluck('product_id')
            ->toArray();

        return Product::where('status', 1)
            ->whereIn('id', $ids)
            ->with('product_images')
            ->withCount('product_ratings')
            ->withSum('product_ratings', 'rating')
            ->paginate(8);
    }
}
