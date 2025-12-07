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
// use App\Models\ProductAttribute;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductView;
use Illuminate\Support\Facades\Auth;
use App\Models\Size;
use App\Models\Color;
use Inertia\Inertia;
class ShopController extends Controller
{
    public function index(Request $request, $catslug = null, $subcatslug = null, $subsubcatslug = null, $brandid = null)
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

        if (!empty($request->get('disct_id'))) {
            $discountId = $request->get('disct_id'); // single id
            $discount = Discount::whereIn('id', $discountId)->first();
            if ($discount && !empty($discount->product_ids)) {
                $productIds = explode(',', $discount->product_ids);                // Fetch products
                $products = $products->whereIn('id', $productIds);
            }
        }

        if ($request->get('price') != '') {
            $products = $products->whereBetween('price', [intval(value: 0), intval($request->get('price'))]);
        }
        if (!empty($request->get('size_id'))) {
            $sizeIds = (array) $request->get('size_id'); // supports single or multiple IDs
            $products = $products->whereHas('size', function ($query) use ($sizeIds) {
                $query->whereIn('id', $sizeIds);
            });
        }
        if (!empty($request->get('color_id'))) {
            $colorId = intval($request->get('color_id'));
            $products = $products->whereHas('color', function ($query) use ($colorId) {
                $query->where('id', $colorId);
            });
        }
        if ($request->get('sortValue') != '') {
            if ($request->get('sortValue') == 'latest') {
                $products = $products->orderBy('id', 'DESC');
            } elseif ($request->get('sortValue') == 'pricelow') {
                $products = $products->orderBy('price', 'ASC');
            } elseif ($request->get('sortValue') == 'pricehigh') {
                $products = $products->orderBy('price', 'DESC');
            }
        }
        // $products = $products->withCount('product_ratings')->withSum('product_ratings', 'rating')->orderBy('id', 'DESC');
        $products = $products->with('product_images')        // fetch images
            ->withCount('product_ratings')  // count ratings
            ->withSum('product_ratings', 'rating')
            ->orderBy('id', 'DESC');
        $products = $products->paginate(100);
        $discounts = Discount::where('status', 1)->get();
        $products->getCollection()->transform(function ($product) use ($discounts) {
            $discountData = getDiscountedPrice($product->id, $discounts, $product->price);
            $product->discount_value = $discountData['discount_value'];
            $product->discounted_price = $discountData['discounted_price'];
            $product->actual_price = $discountData['actual_price'];
            return $product;
        });
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
        $data['discount'] = $discounts;
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




        $today = now()->toDateString();

        $discount = Discount::where('status', 1)
            ->whereDate('start_at', '<=', $today)
            ->whereDate('expires_at', '>=', $today)
            ->get();




        $samcatproduct->transform(function ($product) use ($discount) {
            $discountData = getDiscountedPrice($product->id, $discount, $product->price);
            // If product already has a discount_value
            if (!empty($product->discount_value)) {
                $product->discount_value = $discountData['discount_value'];
                $product->discounted_price = $discountData['discounted_price'];
                $product->actual_price = $discountData['actual_price'];
            } else {
                $product->discount_value = $discountData['discount_value'];
                $product->actual_price = $discountData['actual_price'];
                $product->discounted_price = $discountData['discounted_price'];
            }
            return $product;
        });
        // Calculate average rating
        $avg_rating = $product->product_ratings_count > 0
            ? number_format($product->product_ratings_sum_rating / $product->product_ratings_count, 2)
            : '0.00';
        // $avg_rating_per = ($avg_rating * 100) / 5;
        $avg_rating_per = max(1, min(5, $avg_rating));
        // Fetch wishlist only if user is logged in
        $wishlist = collect();
        if (auth()->check()) {
            $wishlist = Wishlist::where('user_id', auth()->id())->pluck('product_id'); // Only fetch product IDs
        }
        // Fetch active discounts
        // Track product view without redundant query
        ProductView::firstOrCreate([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
        ]);




        $getprice = getDiscountedPrice($product->id, $discount, $product->price);
        $product->discount_value = $getprice['discount_value'];
        $product->discounted_price = $getprice['discounted_price'];
        $product->actual_price = $getprice['actual_price'];


        $stockHandle = handleStock($product->id, 0, 0);
        $wishlistitems = collect();
        if (!empty(Auth::user())) {
            $wishlistitems = Wishlist::where('user_id', Auth::id())
                ->with('product')
                ->get()
                ->keyBy('product_id');
        }
        // Return Inertia response
        return Inertia::render('Front/Product', [
            'product' => $product,
            'wishlist' => $wishlist,
            'wishlistitems' => $wishlistitems,
            'showrelatedproduct' => $samcatproduct,
            'avg_rating_per' => $avg_rating_per,
            'discount' => $discount,
            'product_available_color' => $product->color,
            'product_available_size' => $product->size,
            'getPrice' => $getprice,
            'stockHandle' => $stockHandle,
        ]);
    }
    public function productRating(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'comment' => 'required|string|min:3',
            'rating' => 'required|numeric|min:1|max:5',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
        if (!Auth::check()) {
            return response()->json([
                'status' => false,
                'message' => 'Please login to rate this product.',
            ]);
        }
        $user = Auth::user();
        //  Check if user has already rated this product
        // $alreadyRated = ProductRating::where('email', $user->email)
        //     ->where('product_id', $request->product_id)
        //     ->exists();
        // if ($alreadyRated) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'You have already rated this product.',
        //     ]);
        // }
        // Save the rating
        $rating = new ProductRating();
        $rating->product_id = $request->product_id;
        $rating->username = $user->name;
        $rating->email = $user->email;
        $rating->comment = $request->comment;
        $rating->rating = $request->rating;
        $rating->status = 0; // Pending approval
        $rating->save();
        return response()->json([
            'status' => true,
            'message' => 'Thanks for your rating!',
        ]);
    }
}