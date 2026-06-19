<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use App\Models\DiscountCoupon;
use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductView;
use App\Models\Product;
use App\Models\Country;
use App\Models\Shipping;
use Carbon\Carbon;
use App\Models\Cart;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderEmail;
use App\Models\Stock;
use App\Models\Color;
use App\Models\Size;
use App\Models\Wishlist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use App\Services\CartService;
use App\Services\OrderService;
class CartController extends Controller
{
    protected $cartService;
    protected $orderService;
    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }
    public function addToCart(Request $request)
    {
        // echo '<pre>';
        // print_r($request->all());
        // echo '</pre>';
        // exit;
        if ($request->color_id == null) {
            $request->color_id = 0;
        }
        if ($request->size_id == null) {
            $request->size_id = 0;
        }
        $product = Product::with(['product_images', 'color', 'size'])->find($request->product_id);
        if ($product == null) {
            return response()->json([
                'status' => false,
                'message' => 'Product not Found'
            ]);
        }
        if (Auth::check() == false) {
            return response()->json([
                'status' => false,
                // 'userlogin' => false,
                'message' => 'Please login to add product in cart'
            ]);
        }
        $stock_product = handleStockforCart($request->product_id, $request->color_id, $request->size_id, $request->quantity);
        if ($stock_product['status'] == false) {
            return response()->json([
                'status' => false,
                'stock' => false,
                'message' => 'Out of Stock'
            ]);
        }
        $product_size = $product->size->where('id', $request->size_id)->first();
        $product_color = $product->color->where('id', $request->color_id)->first();
        $additional_attributes = json_encode([
            'size' => $product_size ? $product_size->name : null,
            'color' => $product_color ? $product_color->name : null
        ]);
        if (Cart::count() > 0) {
            $cartcontent = Cart::get();
            $productAlreadyExist = false;
            foreach ($cartcontent as $item) {
                if (
                    $item->user_id == Auth::user()->id && $item->product_id == $request->product_id
                    && $item->color_id == $request->color_id && $item->size_id == $request->size_id
                ) {
                    $productAlreadyExist = true;
                }
            }
            if ($productAlreadyExist == false) {
                try {
                    Cart::create([
                        'user_id' => Auth::user()->id,
                        'product_id' => $request->product_id,
                        'product_attribute_id' => $product->id,
                        'title' => $product->title,
                        'quantity' => $request->quantity,
                        'color_id' => ($request->color_id) ? $request->color_id : 0,
                        'size_id' => ($request->size_id) ? $request->size_id : 0,
                        'price' => $request->variantPrice['actual'],
                        'discounted_price' => $request->variantPrice['discounted'],
                        'discounted_value' => $request->variantPrice['discount_value'],
                        'additional_attributes' => $additional_attributes,
                        'product_image' => (!empty($product->product_images->first()->image)) ? $product->product_images->first()->image : ''
                    ]);
                    return response(['status' => true, 'add_to_cart' => true, 'message' => 'Product added into cart!'], 200);
                } catch (\Exception $e) {
                    return response(
                        [
                            'status' => false,
                            'message' => 'Something went wrong!',
                            'errors' => $e->getMessage()
                        ],
                        500
                    );
                }
            } else {
                try {
                    $cartItem = Cart::where('user_id', Auth::user()->id)
                        ->where('product_id', $request->product_id)
                        ->where('color_id', $request->color_id)
                        ->where('size_id', $request->size_id)
                        ->first();
                    if ($cartItem) {
                        if ($request->page == "product") {
                            $newQuantity = $request->quantity + $cartItem->quantity;
                            $price_actual = $request->variantPrice['baseactualprice'] * $newQuantity;
                            $discounted_price = $request->variantPrice['basediscountedprice'] * $newQuantity;
                        } else {
                            $newQuantity = $request->quantity;
                            $price_actual = $request->variantPrice['actual'];
                            $discounted_price = $request->variantPrice['discounted'];
                        }
                        $cartItem->update([
                            'product_attribute_id' => $product->id,
                            'title' => $product->title,
                            'quantity' => $newQuantity,
                            'price' => $price_actual,
                            'discounted_price' => $discounted_price,
                            'discounted_value' => $request->variantPrice['discount_value'],
                            'additional_attributes' => $additional_attributes,
                            'product_image' => (!empty($product->product_images->first()->image)) ? $product->product_images->first()->image : ''
                        ]);
                    }
                    return response(['status' => true, 'add_to_cart' => true, 'message' => 'Product added into cart!'], 200);
                } catch (\Exception $e) {
                    return response(
                        [
                            'status' => false,
                            'message' => 'Something went wrong!',
                            'errors' => $e->getMessage()
                        ],
                        500
                    );
                }
            }
        } else {
            try {
                Cart::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => $request->product_id,
                    'product_attribute_id' => $product->id,
                    'title' => $product->title,
                    'quantity' => $request->quantity,
                    'color_id' => ($request->color_id) ? $request->color_id : 0,
                    'size_id' => ($request->size_id) ? $request->size_id : 0,
                    'price' => $request->variantPrice['actual'],
                    'discounted_price' => $request->variantPrice['discounted'],  // REQUIRED
                    'discounted_value' => $request->variantPrice['discount_value'],
                    'additional_attributes' => $additional_attributes,
                    'product_image' => (!empty($product->product_images->first()->image)) ? $product->product_images->first()->image : ''
                ]);
                return response(['status' => true, 'add_to_cart' => true, 'message' => 'Product added into cart!'], 200);
            } catch (\Exception $e) {
                logger($e);
                return response(
                    [
                        'status' => false,
                        'message' => 'Something went wrong!',
                        'errors' => $e->getMessage()
                    ],
                    500
                );
            }
        }
    }
    public function Cart()
    {
        $userId = Auth::id();
        // ----------------------------
        // 1. LOAD CART WITH RELATIONS
        // ----------------------------
        $cartcontent = Cart::where('user_id', $userId)
            ->with(['product', 'size']) // eager load
            ->get();
        // Apply product discounts for each cart item
        $cartcontent->each(function ($item) {
            if ($item->product) {
                $item->product->applyDiscount();
            }
        });
        // ----------------------------
        // 2. RECORD PRODUCT VIEWS
        // ----------------------------
        $productIds = $cartcontent->pluck('product_id')->unique();
        foreach ($productIds as $productId) {
            ProductView::firstOrCreate([
                'product_id' => $productId,
                'user_id' => $userId,
            ]);
        }
        // ----------------------------
        // 3. WISHLIST ITEMS
        // ----------------------------
        $wishlistProductIds = Wishlist::where('user_id', $userId)
            ->pluck('product_id');
        $wishlistProducts = Product::with(['product_images', 'color', 'size'])
            ->whereIn('id', $wishlistProductIds)
            ->get();
        // Apply active discounts to wishlist products
        $today = now()->toDateString();
        $discounts = Discount::where('status', 1)
            ->whereDate('start_at', '<=', $today)
            ->whereDate('expires_at', '>=', $today)
            ->get();
        $wishlistProducts->each(function ($product) use ($discounts) {
            $discountData = getDiscountedPrice($product->id, $discounts, $product->price);
            $product->discount_value = $discountData['discount_value'];
            $product->discounted_price = $discountData['discounted_price'];
            $product->actual_price = $discountData['actual_price'];
        });
        // Full wishlist with product info
        $wishlistitems = Wishlist::where('user_id', $userId)
            ->with('product')
            ->get()
            ->keyBy('product_id');
        // ----------------------------
        // 4. CALCULATE CART AMOUNTS
        // ----------------------------
        $cartTotalAmount = $cartcontent->sum('price');
        // Discounted total
        $cartTotalDiscountAmount = $cartcontent->sum(function ($item) {
            return ($item->discounted_value > 0) ? $item->discounted_price : 0;
        });
        $bagsavingvalue = $cartTotalDiscountAmount > 0
            ? $cartTotalAmount - $cartTotalDiscountAmount
            : 0;
        // ----------------------------
        // 5. SHIPPING CALCULATION
        // ----------------------------
        $shippingAmount = 100;
        $customerAddress = CustomerAddress::where('user_id', $userId)->first();
        if ($customerAddress && $customerAddress->country_id) {
            $shipping = Shipping::where('country_id', $customerAddress->country_id)->first();
            if ($shipping) {
                foreach ($cartcontent as $item) {
                    $shippingAmount += $shipping->amount * $item->quantity;
                }
            }
        }
        // ----------------------------
        // 6. FINAL TOTAL
        // ----------------------------
        $totalPayable = $cartTotalAmount + $shippingAmount;
        // ----------------------------
        // 7. RESPONSE DATA
        // ----------------------------
        $data = [
            'wishlist' => $wishlistProducts,
            'wishlistitems' => $wishlistitems,
            'cartcontent' => $cartcontent,
            'colors' => Color::all(),
            'sizes' => Size::all(),
            'bagsavingvalue' => $bagsavingvalue,
            'carttotalamount' => $cartTotalAmount,
            'shippingAmount' => $shippingAmount,
            'totalPayable' => $totalPayable,
        ];
        return Inertia::render('Front/Cart', $data);
    }

    public function updateCart(Request $request)
    {
        $iteminfo = Cart::find($request->rowid);
        $stock = DB::table('stocks')
            ->where('product_id', $iteminfo->product_id)
            ->where('color_id', $iteminfo->color_id)
            ->where('size_id', $iteminfo->size_id)
            ->where('status', 1)
            ->first();
        if ($stock) {
            if ($request->qty <= $stock->quantity) {
                $iteminfo->quantity = $request->qty;
                $iteminfo->save();
                $message = "Cart updated sucessfully";
                $status = True;
                session()->flash('success', $message);
            } else {
                $message = "Requested qty($request->qty) not available";
                $status = false;
                session()->flash('error', $message);
            }
        } else {
            $message = "Requested qty($request->qty) not available";
            $status = false;
            session()->flash('error', $message);
        }
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }
    public function deleteitem(Request $request)
    {
        $iteminfo = Cart::find($request->item_id);
        if ($iteminfo == null) {
            $error_message = 'item not found';
            session()->flash('error', $error_message);
            return response()->json([
                'status' => false,
                'message' => $error_message
            ]);
        } else {
            if ($request->action == "removefromcart") {
                $iteminfo->delete();
                $message = 'item removed successfully';
                session()->flash('success', $message);
                return response()->json([
                    'status' => true,
                    'message' => $message
                ]);
            } elseif ($request->action == "AddtoWishlist") {
                Wishlist::updateOrCreate(
                    [
                        'user_id' => $request->user_id,
                        'product_id' => $request->product_id
                    ],
                    [
                        'user_id' => $request->user_id,
                        'product_id' => $request->product_id
                    ]
                );
                $iteminfo->delete();
                $message = 'item moved to wishlist successfully';
                return response()->json([
                    'status' => true,
                    'message' => $message
                ]);
            }
        }
    }
    public function checkout()
    {
        $data = $this->cartService->calculateCartTotals();
        return Inertia::render('Front/Delivery', [
            'countries' => $data['countries'],
            'customerAddresses' => $data['customerAddresses'],
            'totalcartamount' => $data['cartTotalAmount'],
            'bagsavingvalue' => $data['bagSavingValue'],
            'shippingAmount' => $data['shippingAmount'],
            'totalPayable' => $data['totalPayable'],
        ]);
    }
    public function Payment(Request $request)
    {
        $data = $this->cartService->calculateCartTotals(
            couponApplied: $request->couponApplied,
            newTotal: $request->newTotalcartAmount
        );
        return Inertia::render('Front/Payment', [
            'totalcartamount' => $data['cartTotalAmount'],
            'newTotalcartAmount' => $request->newTotalcartAmount,
            'totalPayable' => $data['totalPayable'],
            'bagsavingvalue' => $data['bagSavingValue'],
            'shippingAmount' => $data['shippingAmount'],
            'couponApplied' => $request->couponApplied,
            'couponcode' => $request->couponcode,
            'discount_coupon_amount' => $request->discount_coupon_amount,
        ]);
    }
    public function orderPlaced(Request $request)
    {
        $order = Order::with('orderItems.product') // eager load items + product details
            ->where('user_id', auth()->id())
            ->latest()
            ->first();

        //  If no order found, redirect safely
        if (!$order) {
            return redirect()->route('front.cart')->with('error', 'No order found.');
        }
        //  Pass order and order_items to the React page
        return Inertia::render('Front/OrderPlaced', [
            'order' => $order,
            'order_items' => $order->orderItems,

        ]);
    }



    public function getOrderSummary(Request $request)
    {
        $cartcontent = Cart::where('user_id', auth()->id())->get();
        $subtotal = getcartquantityandtotal()['totalPrice'];
        // apply discount here
        $discount = 0;
        $discount_amo = 0;
        $discountString = '';
        if (session()->has('code')) {
            $code = session()->get('code');
            if ($code->type == 'percent') {
                $discount = ($code->discont_amount / 100) * $subtotal;
                $discount_amo = '<strong>' . $code->discont_amount . '%</strong>';
            } else {
                $discount = $code->discont_amount;
                $discount_amo = $code->discont_amount;
            }
            $discountString = '<div class="mt-4">
            <strong>' . session()->get('code')->code . '</strong>
            <a class="btn btn-sm btn-danger" id="remove-discount" ><i class="fa fa-times"></i></a>
        </div>';
        }
        if ($request->country_id > 0) {
            $shipping_info = Shipping::where('country_id', $request->country_id)->first();
            $totalqty = 0;
            foreach ($cartcontent as $item) {
                $totalqty += $item->quantity;
            }
            if (!empty($shipping_info)) {
                $shipping_charge = $totalqty * $shipping_info->amount;
                $grand_total = ($subtotal - $discount) + $shipping_charge;
                return response()->json([
                    'status' => true,
                    'discount' => $discount_amo,
                    'shipping_charge' => number_format($shipping_charge, 2),
                    'discountString' => $discountString,
                    'grand_total' => number_format($grand_total, 2)
                ]);
            } else {
                $shipping_charge = 10;
                $grand_total = ($subtotal - $discount) + $shipping_charge;
                return response()->json([
                    'status' => true,
                    'discount' => $discount_amo,
                    'discountString' => $discountString,
                    'shipping_charge' => number_format($shipping_charge, 2),
                    'grand_total' => number_format($grand_total, 2)
                ]);
            }
        } else {
            return response()->json([
                'status' => true,
                'discount' => $discount_amo,
                'discountString' => $discountString,
                'shipping_charge' => number_format(0),
                'grand_total' => number_format($subtotal - $discount, 2)
            ]);
        }
    }
    public function apply_discount(Request $request)
    {
        $coupon = DiscountCoupon::where('code', $request->coupon_code)
            ->where('status', 1)
            ->first();
        if (!$coupon) {
            return redirect()->back()->withErrors(['coupon' => 'Invalid coupon']);
        }
        // Example: calculate discount
        $cartTotal = $request->cart_total;
        if ($coupon->type === 'percent') {
            $discount = ($cartTotal * $coupon->discont_amount) / 100;
        } else {
            $discount = $coupon->discont_amount;
        }
        $newTotal = $cartTotal - $discount;
        // Return updated total back to Inertia
        return response()->json([
            'cartTotalAmount' => $newTotal,
            'couponApplied' => $coupon->code,
            'discount_coupon' => $discount,
            'successapplied' => true,
        ]);
    }
    public function removecoupon(Request $request)
    {
        session()->forget('code');
        return $this->getOrderSummary($request);
    }
    public function thankyou()
    {
        $data['keyword'] = '';
        return view('front.thanks', $data);
    }
    public function couponPage(Request $request)
    {
        $discountCoupons = DiscountCoupon::where('status', 1)
            ->where('start_at', '<=', now())
            ->where('expires_at', '>=', now())
            ->get();
        $data['coupons'] = $discountCoupons;
        $data['totalcartamount'] = $request->totalcartamount;
        $data['couponApplied'] = $request->couponApplied;
        $data['couponcode'] = $request->couponcode;
        $data['shippingAmount'] = $request->shippingAmount;
        return Inertia::render('Front/CouponPage', $data);
    }




}