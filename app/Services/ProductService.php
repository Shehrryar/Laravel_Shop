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
    public function latestProducts(int $limit = 8)
    {
        return Product::where('status', 1)
            ->with('product_images')
            ->withCount('product_ratings')
            ->withSum('product_ratings', 'rating')
            ->orderByDesc('created_at')  // <-- latest products by creation date
            ->limit($limit)              // <-- return specified number of products
            ->get();
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
    public function topRatedProducts(int $limit = 8)
    {
        return Product::where('status', 1)
            ->with('product_images')
            ->withCount('product_ratings')
            ->withSum('product_ratings', 'rating')
            ->orderByDesc(
                Product::selectRaw('SUM(rating) / NULLIF(COUNT(*), 0)')
                    ->from('product_ratings')
                    ->whereColumn('product_ratings.product_id', 'products.id')
            )
            ->orderByDesc('product_ratings_count') // tie-breaker
            ->limit($limit)
            ->get();
    }
}