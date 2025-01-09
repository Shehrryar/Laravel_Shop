<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\ProductRating;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\Wishlist;
use App\Models\Discount;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class ShopController extends Controller
{
    public function index(Request $request, $catslug = null, $subcatslug = null, $subsubcatslug = null )
    {
        $subcategroy_selected = "";
        $categroy_selected = "";
        $brandsArray = [];
        $subsubcategroy_selected = "";
        $categories = Category::orderBy('name', 'DESC')->with('sub_category')->where('status', 1)->get();
        $brands = Brand::orderBy('name', 'DESC')->where('status', 1)->get();
        $products = Product::where('status', 1);
        if (!empty($catslug)) {
            $categroy = Category::where('slug', $catslug)->first();
            $products = $products->where('categories_id', $categroy->id);
            $categroy_selected = $categroy->id;
        }
        if (!empty($subcatslug)) {
            $subcategroy = SubCategory::where('slug', $subcatslug)->first();
            $products = $products->where('sub_category_id', $subcategroy->id);
            $subcategroy_selected = $subcategroy->id;
        }
        if (!empty($subsubcatslug)) {
            $subsubcategroy = SubSubCategory::where('slug', $subsubcatslug)->first();
            $products = $products->where('sub_sub_category_id', $subsubcategroy->id);
            $subsubcategroy_selected = $subsubcategroy->id;
        }
        if (!empty($request->get('brand'))) {
            $brandsArray = explode(',', $request->get('brand'));
            $products = $products->whereIn('brands_id', $brandsArray);
        }
        if ($request->get('price_max') != '' && $request->get('price_min')) {
            $products = $products->whereBetween('price', [intval($request->get('price_min')), intval($request->get('price_max'))]);
        }
        if ($request->get('sort') != '') {
            if ($request->get('sort') == 'latest') {
                $products = $products->orderBy('id', 'DESC');
            } elseif ($request->get('sort') == 'pricelow') {
                $products = $products->orderBy('price', 'ASC');
            } else {
                $products = $products->orderBy('price', 'DESC');
            }
        } else {
            $products = $products->withCount('product_ratings')->withSum('product_ratings', 'rating')->orderBy('id', 'DESC');
        }
        $products = $products->paginate(10);
        $wishlist = collect();
        if (!empty(Auth::user())) {
            $wishlist = Wishlist::where('user_id', Auth::user()->id)->with('product')->get();
        }
        if (empty($request->get('price_max'))) {
            $request->merge(['price_max' => 1000]);
        }
        $discount = Discount::where('status',1)->get();
        $data['categories'] = $categories;
        $data['brands'] = $brands;
        $data['products'] = $products;
        $data['subcategroy_selected'] = $subcategroy_selected;
        $data['subsubcategroy_selected'] = $subsubcategroy_selected;
        $data['categroy_selected'] = $categroy_selected;
        $data['brandsArray'] = $brandsArray;
        $data['price_max'] = intval($request->get('price_max'));
        $data['price_min'] = intval($request->get('price_min'));
        $data['sort'] = $request->get('sort');
        $data['wishlist'] = $wishlist;
        $data['discount'] = $discount;
        $data['keyword'] = '';
        return response()->json([
            'data' => $data,
        ]);
    }
    public function product($slug)
    {
        $product = Product::where('slug', $slug)
            ->withCount('product_ratings')->withSum('product_ratings', 'rating')->with('product_images')->first();
        if ($product == NULL) {
            abort(404);
        }
        // fetch products according to the category
        if($product != Null){
            $samcatproduct = Product::where('categories_id', $product->categories_id)
            ->withCount('product_ratings')->withSum('product_ratings', 'rating')->with('product_images')->get();
        }
        // fetch related products 
        // $related_products = [];
        // if ($product != null) {
        //     $related_products = explode(',', $product->related_products);
        //     $showrelatedproduct = Product::whereIn('id', $related_products)->withCount('product_ratings')->withSum('product_ratings', 'rating')->with('product_images')->get();
        // }
        $avg_rating = '0.00';
        if ($product->product_ratings_count > 0) {
            $avg_rating = number_format(($product->product_ratings_sum_rating / $product->product_ratings_count),2);
        }
        $avg_rating_per = 0;
        if ($product->product_ratings_count > 0) {
            $avg_rating = number_format(($product->product_ratings_sum_rating / $product->product_ratings_count),2);
            $avg_rating_per = ($avg_rating*100)/5;
        }
        $wishlist = collect();
        if (!empty(Auth::user())) {
            $wishlist = Wishlist::where('user_id', Auth::user()->id)->with('product')->get();
        }
        $discount = Discount::where('status',1)->get();
        $data['product'] = $product;
        $data['wishlist'] = $wishlist;
        $data['showrelatedproduct'] = $samcatproduct;
        $data['avg_rating'] = $avg_rating;
        $data['avg_rating_per'] = $avg_rating_per;
        $data['discount'] = $discount;
        $data['keyword'] = '';
        return response()->json([
            'data' => $data,
        ]);
    }
    public function productRating(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'review' => 'required|min:10',
            'rating' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
        $count = ProductRating::where('email', $request->email)->where('product_id', $id)->count();
        if ($count > 0) {
            session()->flash('error', 'You already rate this product');
            return response()->json([
                'status' => true,
                'message' => 'You already rate this product'
            ]);
        }
        if (Auth::check()) {
            $productrating = new ProductRating();
            $productrating->product_id = $id;
            $productrating->username = Auth::user()->name;
            $productrating->email = Auth::user()->email;
            $productrating->comment = $request->review;
            $productrating->rating = $request->rating;
            $productrating->status = 0;
            $productrating->save();
            session()->flash('success', 'Thanks for your rating');
            return response()->json([
                'status' => true,
                'message' => 'Thanks for your rating'
            ]);
        } else {
            session()->flash('error', 'Please Register/Login your account');
            return response()->json([
                'message' => 'Please register your account'
            ]);
        }
    }
}