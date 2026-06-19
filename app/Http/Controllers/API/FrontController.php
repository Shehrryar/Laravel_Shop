<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller; // Import the base controller
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\ProductView;
use App\Models\Discount;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
// use Illuminate\Support\Facades\App;
class FrontController extends Controller
{
    public function index()
    {
        $wishlist = collect();
        if (!empty(Auth::user())) {
            $wishlist = Wishlist::where('user_id', Auth::user()->id)->with('product')->get();
        }
        $featured_products = Product::where('is_featured', 1)
            ->where('status', 1)
            ->withCount('product_ratings')
            ->withSum('product_ratings', 'rating')
            ->take(8)
            ->get();
        $latest_product = Product::orderBy('id', 'DESC')
            ->where('status', 1)
            ->withCount('product_ratings')
            ->withSum('product_ratings', 'rating')
            ->take(8)
            ->get();
        $discount = Discount::where('status', 1)->get();
        $recommended_product_ids = ProductView::where('user_id', Auth::id())->pluck('product_id')->toArray();
        $recommended_products = Product::orderBy('id', 'DESC')
            ->where('status', 1)
            ->whereIn('id', $recommended_product_ids)
            ->withCount('product_ratings')
            ->withSum('product_ratings', 'rating')
            ->take(8)
            ->get();
        $brands = Brand::orderBy('id', 'asc')->where(['status' => 1])->get();
        $category = Category::orderBy('id', 'asc')->where(['status' => 1])->get();
        $data['wishlist'] = $wishlist;
        $data['discount'] = $discount;
        $data['recommended_products'] = $recommended_products;
        $data['featured_products'] = $featured_products;
        $data['latest_product'] = $latest_product;
        $data['brands'] = $brands;
        $data['category'] = $category;
        return response()->json([$data]);
    }
    public function addToWishlist(Request $request)
    {
        if (Auth::check() == false) {
            session(['url.intended' => url()->previous()]);
            return response()->json([
                'status' => false
            ]);
        }
        $product = Product::where('id', $request->id)->first();
        if ($product == null) {
            return response()->json([
                'status' => true,
                'message' => '<div class = "alert alert-danger">Product not found.</div>'
            ]);
        }
        Wishlist::updateOrCreate(
            [
                'user_id' => Auth::user()->id,
                'product_id' => $request->id
            ],
            [
                'user_id' => Auth::user()->id,
                'product_id' => $request->id
            ]
        );
        return response()->json([
            'status' => true,
            'message' => '<div class = "alert alert-success"><strong>"' . $product->title . '"</strong> is added to the Wishlist.</div>'
        ]);
    }
}