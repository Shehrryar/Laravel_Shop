<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use App\Services\ProductService;
use App\Services\DiscountService;
use App\Models\HomepageLabel;
use Inertia\Inertia;
class FrontController extends Controller
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
    public function index()
    {
        $discounts = $this->discountService->getActiveDiscounts();
        $discountedIds = $this->discountService->getDiscountedProductIds($discounts);
        $discountedProducts = $this->discountService->applyDiscount(
            $this->productService->discountedProducts($discountedIds),
            $discounts
        );
        $featured = $this->discountService->applyDiscount(
            $this->productService->featuredProducts(),
            $discounts
        );
        $recommended = $this->productService->recommendedProducts();
        $latest = $this->discountService->applyDiscount(
            $this->productService->latestProducts(),
            $discounts
        );
        $toprated = $this->discountService->applyDiscount(
            $this->productService->topRatedProducts(12),
            $discounts
        );
        $wishlistitems = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->with('product')->get()->keyBy('product_id')
            : collect();
        $productsByLabel = [
            'latest' => $latest,
            // 'trending_now' => Product::where('status', 1)
            //     ->orderBy('views', 'desc') // or sales count
            //     ->limit(12)
            //     ->get(),
            'top_rated' => $toprated,
        ];
        return Inertia::render('Front/Index', [
            'discount' => $discounts,
            'featured_products' => $featured,
            'latest_product' => $latest,
            'dis_products' => $discountedProducts,
            'recommended_products' => $recommended,
            'user' => Auth::user(),
            'languages' => Language::get(),
            'brands' => Brand::where('status', 1)->orderBy('name')->get(),
            'homelables' => HomepageLabel::where('is_active', 1)->orderBy('label_name')->get(),
            'productsByLabel' => $productsByLabel,
            'wishlistitems' => $wishlistitems,
        ]);
    }
    public function addToWishlist(Request $request)
    {
        if (Auth::check() == false) {
            session(['url.intended' => url()->previous()]);
            return response()->json([
                'status' => false,
                'userlodin' => false
            ]);
        }
        $product = Product::where('id', $request->product_id)->first();
        if ($product == null) {
            return response()->json([
                'status' => true,
                'message' => '<div class = "alert alert-danger">Product not found.</div>'
            ]);
        }
        if ($request->has('action') && $request->action == 'remove') {
            Wishlist::where('user_id', Auth::user()->id)
                ->where('product_id', $request->product_id)
                ->delete();
            return response()->json([
                'status' => true,
                'message' => '<div class = "alert alert-success"><strong>"' . $product->title . '"</strong> is removed from the Wishlist.</div>'
            ]);
        } else {
            Wishlist::updateOrCreate(
                [
                    'user_id' => Auth::user()->id,
                    'product_id' => $request->product_id
                ],
                [
                    'user_id' => Auth::user()->id,
                    'product_id' => $request->product_id
                ]
            );
            return response()->json([
                'status' => true,
                'message' => '<div class = "alert alert-success"><strong>"' . $product->title . '"</strong> is added to the Wishlist.</div>'
            ]);
        }
    }
    function loadProductModal($productId)
    {
        $product = Product::with(['size', 'color'])->findOrFail($productId);
        return view('front.layouts.ajax-files.product-popup-modal', compact('product'))->render();
    }
}