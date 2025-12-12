<?php
namespace App\Services;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\Discount;
class ProductFilterService
{
    public function filter($request, $catslug, $subcatslug, $subsubcatslug)
    {
        $products = Product::where('status', 1);
        // Category
        if ($catslug) {
            $cat = Category::where('slug', $catslug)->first();
            $products->where('categories_id', $cat->id);
        }
        // Subcategory
        if ($subcatslug) {
            $subcat = SubCategory::where('slug', $subcatslug)->first();
            $products->where('sub_category_id', $subcat->id);
        }
        // Sub-subcategory
        if ($subsubcatslug) {
            $subsubcat = SubSubCategory::where('slug', $subsubcatslug)->first();
            $products->where('sub_sub_category_id', $subsubcat->id);
        }
        // Brand filter
        if ($request->brand_id) {
            $products->whereIn('brands_id', (array) $request->brand_id);
        }
        // Discount filter
        if ($request->disct_id) {
            // Always treat as array
            $discountIds = (array) $request->disct_id;
            $discounts = Discount::whereIn('id', $discountIds)->get();
            $ids = [];
            foreach ($discounts as $discount) {
                // Remove quotes from "26"
                $clean = trim($discount->product_ids, '"');
                $ids[] = $clean;
            }
            $products->whereIn('id', $ids);
        }
        // Price filter
        if ($request->price !== null) {
            $products->whereBetween('price', [0, intval($request->price)]);
        }
        // Size filter
        if ($request->size_id) {
            $products->whereHas('size', function ($q) use ($request) {
                $q->whereIn('id', (array) $request->size_id);
            });
        }
        // Color filter
        if ($request->color_id) {
            $products->whereHas('color', function ($q) use ($request) {
                $q->where('id', intval($request->color_id));
            });
        }
        // Sorting
        match ($request->sortValue) {
            'latest' => $products->orderBy('id', 'DESC'),
            'pricelow' => $products->orderBy('price', 'ASC'),
            'pricehigh' => $products->orderBy('price', 'DESC'),
            default => null,
        };
        return $products
            ->with('product_images')
            ->withCount('product_ratings')
            ->withSum('product_ratings', 'rating')
            ->orderBy('id', 'DESC')
            ->paginate(100);
    }
}