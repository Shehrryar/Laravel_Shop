<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Models\ProductRating;
use App\Services\ProductFilterService;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\Wishlist;
use App\Models\Discount;
use App\Services\DiscountService;
// use App\Models\ProductAttribute;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductView;
use Illuminate\Support\Facades\Auth;
use App\Models\Size;
use App\Models\Color;
use Inertia\Inertia;
use App\Models\User;
class ShopController extends Controller
{
    protected $discountService;
    protected $productFilterService;
    public function __construct(DiscountService $discountService, ProductFilterService $productFilterService)
    {
        $this->discountService = $discountService;
        $this->productFilterService = $productFilterService;
    }
    public function index(Request $request, $catslug = null, $subcatslug = null, $subsubcatslug = null)
    {
        // Products (filtered)
        $products = $this->productFilterService->filter($request, $catslug, $subcatslug, $subsubcatslug);
        // Apply discounts
        
        $discounts = $this->discountService->getActiveDiscounts();
        $products->getCollection()->transform(function ($product) use ($discounts) {
            $data = getDiscountedPrice($product->id, $discounts, $product->price);
            $product->discount_value = $data['discount_value'];
            $product->discounted_price = $data['discounted_price'];
            $product->actual_price = $data['actual_price'];
            return $product;
        });
        $wishlist = auth()->check()
            ? Wishlist::where('user_id', auth()->id())->with('product')->get()->keyBy('product_id')
            : collect();
        return Inertia::render('Front/Shop', [
            'categories' => Category::with('sub_category')->where('status', 1)->orderBy('name')->get(),
            'brands' => Brand::where('status', 1)->orderBy('name')->get(),
            'products' => $products,
            'wishlist' => $wishlist,
            'discount' => $discounts,
            'sizes' => Size::all(),
            'colors' => Color::all(),
            'price_min' => intval($request->price_min),
            'price_max' => intval($request->price_max ?? 1000),
            'brandsArray' => (array) $request->brand_id,
            'cat_slug' => $catslug,
            'subcat_slug' => $subcatslug,
            'subsubcat_slug' => $subsubcatslug,
        ]);
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
        $discount = $this->discountService->getActiveDiscounts();
        $samcatproduct = $this->discountService->applyDiscount($samcatproduct, $discount);
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