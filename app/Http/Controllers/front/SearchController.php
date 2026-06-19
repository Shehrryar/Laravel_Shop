<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use App\Models\Discount;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\ProductService;
use App\Services\DiscountService;
class SearchController extends Controller
{
    protected $discountService;
    protected $productService;
    public function __construct(
        DiscountService $discountService,
        ProductService $productService
    ) {
        $this->discountService = $discountService;
        $this->productService = $productService;
    }
    public function search(Request $request)
    {
        $wishlistitems = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->with('product')->get()->keyBy('product_id')
            : collect();
        $discounts = $this->discountService->getActiveDiscounts();
        $latestproduct = $this->discountService->applyDiscount(
            $this->productService->latestProducts(limit: 12),
            $discounts
        );
        $data['wishlist'] = $wishlistitems;
        $data['latestproducts'] = $latestproduct;
        return Inertia::render('Front/Search', $data);
    }
    public function searchProducts(Request $request)
    {
        $keyword = trim($request->input('q')); // <-- match frontend param
        if (!$keyword || strlen($keyword) < 2) {
            return response()->json([]);
        }
        $discounts = $this->discountService->getActiveDiscounts();
        $seachedproduct = $this->discountService->applyDiscount(
            $this->productService->searchProducts($keyword),
            $discounts
        );
        return response()->json($seachedproduct);
    }
}