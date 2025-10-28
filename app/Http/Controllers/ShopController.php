<?php
namespace App\Http\Controllers;
use App\Models\ProductRating;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\Wishlist;
use App\Models\Discount;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductView;
use Illuminate\Support\Facades\Auth;
use App\Models\Size;
use App\Models\Color;
use Inertia\Inertia;
class ShopController extends Controller
{
    public function index(Request $request, $catslug = null, $subcatslug = null, $subsubcatslug = null)
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

        if (!empty($request->get('brand_id'))) {

            $brandsArray = $request->get('brand_id');
            // $brandsArray = explode(',', $request->get('brand_id'));
            $products = $products->whereIn('brands_id', $brandsArray);
        }
        if ($request->get('price') != '') {
            $products = $products->whereBetween('price', [intval(value: 0), intval($request->get('price'))]);
        }

        if ($request->get('sortValue') != '') {
            if ($request->get('sortValue') == 'latest') {
                $products = $products->orderBy('id', 'DESC');
            } elseif ($request->get('sortValue') == 'pricelow') {
                $products = $products->orderBy('price', 'ASC');
            } elseif ($request->get('sortValue') == 'pricehigh') {
                $products = $products->orderBy('price', 'DESC');
            }
        } else {
            $products = $products->withCount('product_ratings')->withSum('product_ratings', 'rating')->orderBy('id', 'DESC');
        }


        $products = $products->paginate(10);

        $wishlist = collect();
        if (!empty(Auth::user())) {
            $wishlist = Wishlist::where('user_id', Auth::id())
                ->with('product')
                ->get()
                ->keyBy('product_id');
        }
        $sizes = Size::get();
        $colors = Color::get();
        if (empty($request->get('price_max'))) {
            $request->merge(['price_max' => 1000]);
        }
        $discount = Discount::where('status', 1)->get();
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
        $data['sizes'] = $sizes;
        $data['colors'] = $colors;
        $data['cat_slug'] = $catslug;
        $data['subcat_slug'] = $subcatslug;
        $data['subsubcat_slug'] = $subsubcatslug;
        $data['keyword'] = '';
        // return view('front.shop', $data);
        return Inertia::render('Front/Shop', $data);
    }
    public function product($slug)
    {
        // Fetch product with necessary relationships
        $product = Product::where('slug', $slug)
            ->with([
                'product_ratings',
                'product_images',
                'color',
                'size'
            ])
            ->withCount('product_ratings')
            ->withSum('product_ratings', 'rating')
            ->firstOrFail();
        // Fetch related products by category
        $samcatproduct = Product::where('categories_id', $product->categories_id)
            ->with(['product_ratings', 'product_images'])
            ->withCount('product_ratings')
            ->withSum('product_ratings', 'rating')
            ->get();
        // Calculate average rating
        $avg_rating = $product->product_ratings_count > 0
            ? number_format($product->product_ratings_sum_rating / $product->product_ratings_count, 2)
            : '0.00';
        $avg_rating_per = ($avg_rating * 100) / 5;
        // Fetch wishlist only if user is logged in
        $wishlist = collect();
        if (auth()->check()) {
            $wishlist = Wishlist::where('user_id', auth()->id())->pluck('product_id'); // Only fetch product IDs
        }
        // Fetch active discounts
        $discount = Discount::where('status', 1)->get();
        // Track product view without redundant query
        ProductView::firstOrCreate([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
        ]);
        $getprice = getDiscountedPrice($product->id, $discount, $product->price);
        $stockHandle = handleStock($product->id, 0, 0);
        // Return Inertia response
        return Inertia::render('Front/Product', [
            'product' => $product,
            'wishlist' => $wishlist,
            'showrelatedproduct' => $samcatproduct,
            'avg_rating' => $avg_rating,
            'avg_rating_per' => $avg_rating_per,
            'discount' => $discount,
            'product_available_color' => $product->color,
            'product_available_size' => $product->size,
            'getPrice' => $getprice,       // ✅ Pass to frontend
            'stockHandle' => $stockHandle, // ✅ Pass to frontend
            'keyword' => '',
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