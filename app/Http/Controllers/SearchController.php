<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use App\Models\Discount;
use Illuminate\Http\Request;
class SearchController extends Controller
{
    public function search(Request $request)
    {
        $products = Product::latest('id')->with('product_images');
        if (!empty($request->get('keyword'))) {
            $products = $products->where('title', 'like', '%' . $request->get('search_query') . '%');
        }
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
        $data['wishlist'] = $wishlist;
        $data['discount'] = $discount;
        $data['featured_products'] = $featured_products;
        $data['latest_product'] = $latest_product;
        return view('front.home', $data);
    }
}
