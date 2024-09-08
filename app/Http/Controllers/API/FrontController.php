<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use App\Models\Discount;
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
                    ->paginate(8);
        $latest_product = Product::orderBy('id', 'DESC')
                        ->where('status', 1)
                        ->withCount('product_ratings')
                        ->withSum('product_ratings', 'rating')
                        ->paginate(8);
        $discount = Discount::where('status', 1)->get();
        // echo "<pre>";
        // print_r($discount);
        // exit;
        $data['wishlist'] = $wishlist;
        $data['discount'] = $discount;
        $data['featured_products'] = $featured_products;
        $data['latest_product'] = $latest_product;
        $data['keyword'] = '';

        return view('front.home', $data);
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
        $wishlist = Wishlist::updateOrCreate(
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