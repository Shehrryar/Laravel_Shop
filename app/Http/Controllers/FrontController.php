<?php
namespace App\Http\Controllers;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\App;
use App\Models\Discount;
use App\Models\Category;
use App\Models\ProductView;
use App\Models\HomepageLabel;
use Inertia\Inertia;
class FrontController extends Controller
{
    public function index()
    {
        $brands = Brand::OrderBy('name', 'ASC')->where('status', 1)->get();
        $homelables = HomepageLabel::OrderBy('label_name', 'ASC')->where('is_active', 1)->get();

        $featured_products = Product::where('is_featured', 1)
            ->where('status', 1)
            ->withCount('product_ratings')
            ->withSum('product_ratings', 'rating')
            ->get();
        $latest_product = Product::orderBy('id', 'DESC')
            ->where('status', 1)
            ->withCount('product_ratings')
            ->withSum('product_ratings', 'rating')
            ->paginate(8);
        $today = now()->toDateString();
        $discounts = Discount::where('status', 1)
            ->whereDate('start_at', '<=', $today)
            ->whereDate('expires_at', '>=', $today)
            ->get();

        $products = Product::where('status', 1)
            ->with('product_images')        // ← load images
            ->get()
            ->filter(function ($product) use ($discounts) {

                foreach ($discounts as $dis) {

                    // Clean product_ids: remove quotes "1,2,3"
                    $cleanIds = trim($dis->product_ids, '"');

                    // Convert string → array [1,2,3]
                    $productIds = explode(',', $cleanIds);

                    // Check if product has discount
                    if (in_array($product->id, $productIds)) {
                        return true;
                    }
                }

                return false;
            })->values();

        $dis_products = $products->map(function ($product) use ($discounts) {

            $priceData = getDiscountedPrice($product->id, $discounts, $product->price);

            $product->discount_value = $priceData['discount_value'];
            $product->actual_price = $priceData['actual_price'];
            $product->discounted_price = $priceData['discounted_price'];
            $product->discounted_price = $priceData['discounted_price'];

            return $product;
        });



        $recommended_products = Product::orderBy('id', 'DESC')
            ->where('status', 1)
            ->withCount('product_ratings')
            ->withSum('product_ratings', 'rating')
            ->with('product_recommendation')->paginate(8);
        $recommended_product_ids = ProductView::where('user_id', Auth::id())->pluck('product_id')->toArray();
        $recommended_products = Product::orderBy('id', 'DESC')
            ->where('status', 1)
            ->whereIn('id', $recommended_product_ids)
            ->withCount('product_ratings')
            ->withSum('product_ratings', 'rating')
            ->paginate(8);

        $wishlistitems = collect();
        if (!empty(Auth::user())) {
            $wishlistitems = Wishlist::where('user_id', Auth::id())
                ->with('product')
                ->get()
                ->keyBy('product_id');
        }


        $data['wishlistitems'] = $wishlistitems;
        $data['discount'] = $discounts;
        $data['recommended_products'] = $recommended_products;
        $data['featured_products'] = $featured_products;
        $data['latest_product'] = $latest_product;
        $data['dis_products'] = $dis_products;
        $data['brands'] = $brands;
        $data['homelables'] = $homelables;


        
        return Inertia::render('Front/Index', $data);
        // return view('front.home', $data);
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