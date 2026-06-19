<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use App\Models\Discount;
use Illuminate\Http\Request;
class SearchController extends Controller
{
    public function search(Request $request)
    {
        $wishlist = collect();
        if (!empty(Auth::user())) {
            $wishlist = Wishlist::where('user_id', Auth::user()->id)->with('product')->get();
        }
        $featured_products = array();
        $keyword = request()->input('search_query');
        if (!empty($keyword)) {
            $featured_products = Product::where('status', 1)
                ->when(!empty($keyword), function ($query) use ($keyword) {
                    return $query->where('title', 'like', '%' . $keyword . '%'); // Adjust field if necessary
                })
                ->withCount('product_ratings')
                ->withSum('product_ratings', 'rating')
                ->get();
        }
        $discount = Discount::where('status', 1)->get();
        $data['keyword'] = $keyword;
        $data['wishlist'] = $wishlist;
        $data['discount'] = $discount;
        $data['featured_products'] = $featured_products;
        return response()->json(
            [$data],
        );
    }
}
