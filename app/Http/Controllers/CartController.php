<?php
namespace App\Http\Controllers;
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
use App\Models\Stock;
use App\Models\Color;
use App\Models\Size;
use App\Models\Wishlist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Stripe\Coupon;
use Stripe\Stripe;
use Stripe\Checkout\Session;
class CartController extends Controller
{
    public function addToCart(Request $request)
    {

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
        // $discountprice = getDiscountedPrice($request->product_id, Discount::get(), $request->actual_price);
        // $price = $discountprice['discounted_price'] != 0 ? $discountprice['discounted_price'] : $discountprice['actual_price'];
        $product_size = $product->size->where('id', $request->size_id)->first();
        $product_color = $product->color->where('id', $request->color_id)->first();



        // if ($product_size) {
        //     $price = $price + $product_size->price;
        // }
        // if ($product_color) {
        //     $price = $price + $product_color->price;
        // }


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
                        'price' => $request->price['actual'],
                        'discounted_price' => $request->price['discounted'],
                        'discounted_value' => $request->price['discount_value'],
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
                        $cartItem->update([
                            'product_attribute_id' => $product->id,
                            'title' => $product->title,
                            'quantity' => $request->quantity,
                            'price' => $request->price['actual'],
                            'discounted_price' => $request->price['discounted'],
                            'discounted_value' => $request->price['discount_value'],
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
                    'price' => $request->price['actual'],
                    'discounted_price' => $request->price['discounted'],  // REQUIRED
                    'discounted_value' => $request->price['discount_value'],
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
        // $cartcontent = Cart::where('user_id', auth()->id())->get();
        $cartcontent = Cart::where('user_id', auth()->id())
            ->with('product')->with('size')
            ->get();
        $cartcontent->transform(function ($item) {
            if ($item->product) {
                $item->product->applyDiscount();
            }
            return $item;
        });
        foreach ($cartcontent as $content) {
            $existingProductView = ProductView::where('product_id', $content->product_id)
                ->where('user_id', auth()->id())
                ->first();
            if (!$existingProductView) {
                ProductView::create([
                    'product_id' => $content->product_id,
                    'user_id' => $content->user_id,
                ]);
            }
        }
        $wishlistProductIds = Wishlist::where('user_id', Auth::id())
            ->pluck('product_id');
        $products = Product::with(['product_images', 'color', 'size'])
            ->whereIn('id', $wishlistProductIds)
            ->get();
        $discounts = Discount::where('status', 1)->get();
        $products->transform(function ($product) use ($discounts) {
            $discountData = getDiscountedPrice($product->id, $discounts, $product->price);
            $product->discount_value = $discountData['discount_value'];
            $product->discounted_price = $discountData['discounted_price'];
            $product->actual_price = $discountData['actual_price'];
            return $product;
        });
        $wishlistitems = collect();
        if (!empty(Auth::user())) {
            $wishlistitems = Wishlist::where('user_id', Auth::id())
                ->with('product')
                ->get()
                ->keyBy('product_id');
        }
        $cartTotalAmount = $cartcontent->sum(function ($item) {
            return $item->price;
        });



        $cartTotaldiscountAmount = $cartcontent->sum(function ($item) {
            return $item->discounted_price;
        });



        $bagsavingvalue = $cartTotalAmount - $cartTotaldiscountAmount;





        $user = Auth::user();
        $shippingAmount = 100;
        $customerAddress = CustomerAddress::where('user_id', $user->id)->first();



        if ($customerAddress && $customerAddress->country_id) {
            $shipping = Shipping::where('country_id', $customerAddress->country_id)->first();

            if ($shipping) {
                // Apply shipping per product quantity
                foreach ($cartcontent as $item) {
                    $shippingAmount += $shipping->amount * $item->quantity;
                }
            }
        }

        // Total payable amount
        $totalPayable = $cartTotalAmount + $shippingAmount;
        $data['wishlist'] = $products;
        $data['wishlistitems'] = $wishlistitems;
        $data['cartcontent'] = $cartcontent;
        $data['colors'] = Color::get();
        $data['sizes'] = Size::get();
        $data['bagsavingvalue'] = $bagsavingvalue;




        $data['carttotalamount'] = $cartTotalAmount;
        $data['shippingAmount'] = $shippingAmount;
        $data['totalPayable'] = $totalPayable;
        return Inertia::render('Front/Cart', $data);
        // return view('front.cart', $data);
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
            }
        }
    }
    // public function checkout()
    // {
    //     $discount = 0;
    //     $discount_amo = 0;
    //     $discount_type = '';
    //     $cartcount = Cart::where('user_id', auth()->id())->count();
    //     $cartcontent = Cart::where('user_id', auth()->id())->get();
    //     $subtotal = getcartquantityandtotal()['totalPrice'];
    //     if ($cartcount == 0) {
    //         return redirect()->route('front.cart');
    //     }
    //     $customerAddress = CustomerAddress::where('user_id', Auth::user()->id)->first();
    //     $countries = Country::orderBy('name', 'ASC')->get();
    //     if (session()->has('code')) {
    //         $code = session()->get('code');
    //         if ($code->type == 'percent') {
    //             $discount = ($code->discont_amount / 100) * $subtotal;
    //             $discount_amo = $code->discont_amount;
    //             $discount_type = $code->type;
    //         } else {
    //             $discount_amo = $code->discont_amount;
    //             $discount_type = $code->type;
    //         }
    //     }
    //     // Calculate shiping here
    //     if (!empty($customerAddress->country_id)) {
    //         $usercountry = $customerAddress->country_id;
    //         $shipping_info = Shipping::where('country_id', $usercountry)->first();
    //         $totalqty = 0;
    //         $total_shipping = 0;
    //         foreach ($cartcontent as $item) {
    //             $totalqty += $item->quantity;
    //         }
    //         if (!empty($shipping_info) && $shipping_info != null) {
    //             $total_shipping = $totalqty * $shipping_info->amount;
    //         } else {
    //             $total_shipping = 0; // Default shipping if no info found
    //         }
    //         $grand_total = ($subtotal - $discount) + $total_shipping;
    //     } else {
    //         $total_shipping = 0;
    //         $grand_total = ($subtotal - $discount) + $total_shipping;
    //     }
    //     $data = [
    //         'cartcontent' => $cartcontent,
    //         'countries' => $countries,
    //         'customerAddress' => $customerAddress,
    //         'discount' => $discount_amo,
    //         'discount_type' => $discount_type,
    //         'subtotal' => $subtotal,
    //         'total_shipping' => number_format($total_shipping, 2),
    //         'grand_total' => $grand_total,
    //         'keyword' => ''
    //     ];
    //     // return view(
    //     //     'front.checkout',
    //     // );
    //     return Inertia::render('Front/Delivery', $data);
    // }
    public function checkout(Request $request)
    {
        // echo '<pre>';
        // print_r($request->all());
        // echo '</pre>';
        // exit;
        $countries = Country::orderBy('name', 'ASC')->get();
        $customerAddresses = collect(); // empty collection by default
        if (Auth::check()) {
            $customerAddresses = CustomerAddress::where('user_id', Auth::id())->get();
        }
        $totalcartamount = $request->totalcartamount;
        $cartcontent = $request->cartcontent;
        $data = [
            'countries' => $countries,
            'customerAddresses' => $customerAddresses,
            'totalcartamount' => $totalcartamount,
            'cartcontent' => $cartcontent,
        ];
        return Inertia::render('Front/Delivery', $data);
    }
    public function Payment(Request $request)
    {
        $totalcartamount = $request->totalcartamount;
        $cartcontent = $request->cartcontent;
        $data = [
            'totalcartamount' => $totalcartamount,
            'cartcontent' => $cartcontent,
        ];
        return Inertia::render('Front/Payment', $data);
    }
    public function processCheckout(Request $request)
    {
        $user = Auth::user();
        // Validate payment method
        if (!in_array($request->paymentMethod, ['cod', 'card'])) {
            return response()->json(['status' => false, 'message' => 'Invalid payment method.']);
        }
        // Get default address
        $customerAddress = CustomerAddress::where('user_id', $user->id)
            ->where('is_default', 1)
            ->first();
        if (!$customerAddress) {
            return response()->json([
                'status' => false,
                'message' => 'No default address found. Please set one before proceeding to checkout.',
            ]);
        }
        // Get user cart
        $cartItems = Cart::where('user_id', $user->id)->get();
        if ($cartItems->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Your cart is empty.',
            ]);
        }
        $subtotal = $request->totalcartamount;
        $shipping = 100.00;
        $grandTotal = $subtotal + $shipping;
        try {
            // Create Order first (common for both methods)
            $order = new Order();
            $order->user_id = $user->id;
            $order->subtotal = $subtotal;
            $order->discount = 0.00;
            $order->shipping = $shipping;
            $order->grandtotal = $grandTotal;
            $order->payment_status = 'not paid';
            $order->status = 'pending';
            $order->stripe_charge_id = null;
            $order->shipping_date = null;
            $order->coupon_code = null;
            $order->firstname = $customerAddress->firstname;
            $order->lastname = $customerAddress->lastname;
            $order->email = $customerAddress->email;
            $order->country_id = $customerAddress->country_id;
            $order->apartment = $customerAddress->apartment;
            $order->address = $customerAddress->address;
            $order->city = $customerAddress->city;
            $order->state = $customerAddress->state;
            $order->zip = $customerAddress->zip;
            $order->notes = $request->order_notes ?? null;
            $order->save();
            // Create order items and update stock
            foreach ($cartItems as $item) {
                $stock = DB::table('stocks')
                    ->where('product_id', $item->product_id)
                    ->where('color_id', $item->color_id)
                    ->where('size_id', $item->size_id)
                    ->where('status', 1)
                    ->first();
                if (!$stock || $item->quantity > $stock->quantity) {
                    $order->delete();
                    return response()->json([
                        'status' => false,
                        'message' => 'Stock is low for product: <strong>' . e($item->title) . '</strong>',
                    ]);
                }
                DB::table('stocks')->where('id', $stock->id)->update([
                    'quantity' => $stock->quantity - $item->quantity,
                    'sold_quantity' => $stock->sold_quantity + $item->quantity,
                ]);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'cart_id' => $item->id,
                    'name' => $item->title,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->price * $item->quantity,
                ]);
            }
            // Empty cart
            Cart::where('user_id', $user->id)->delete();
            // --------------------------
            // CASH ON DELIVERY
            // --------------------------
            if ($request->paymentMethod === 'cod') {
                return response()->json([
                    'status' => true,
                    'message' => 'Order placed successfully (COD)!',
                    'orderId' => $order->id,
                ]);
            }
            // --------------------------
            // STRIPE PAYMENT
            // --------------------------
            if ($request->paymentMethod === 'card') {
                Stripe::setApiKey(env('STRIPE_SECRET'));
                $session = Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [
                        [
                            'price_data' => [
                                'currency' => 'usd',
                                'product_data' => [
                                    'name' => 'Order #' . $order->id,
                                ],
                                'unit_amount' => intval($grandTotal * 100),
                            ],
                            'quantity' => 1,
                        ]
                    ],
                    'mode' => 'payment',
                    'success_url' => route('front.orderPlaced') . '?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => route('front.checkout'),
                    'metadata' => [
                        'order_id' => $order->id,
                        'user_id' => $user->id,
                    ],
                ]);
                // Save Stripe session ID
                $order->stripe_charge_id = $session->id;
                $order->save();
                return response()->json([
                    'status' => true,
                    'message' => 'Stripe checkout session created successfully.',
                    'orderId' => $order->id,
                    'url' => $session->url,
                ]);
            }
        } catch (\Exception $e) {
            // Rollback if any error occurs
            if (isset($order)) {
                $order->delete();
            }
            return response()->json([
                'status' => false,
                'message' => 'Checkout failed: ' . $e->getMessage(),
            ], 500);
        }
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
        // if (!empty(Auth::user())) {
        //     $cartcontent = Cart::where('user_id', Auth::user()->id)->get();
        // }
        // $cartTotalAmount = $cartcontent->sum(function ($item) {
        //     return $item->price;
        // });
        $discountCoupons = DiscountCoupon::where('status', 1)->get();
        $data['coupons'] = $discountCoupons;
        // $data['cartcontent'] = $cartcontent;
        $data['totalPayable'] = $request->totalPayable;
        return Inertia::render('Front/CouponPage', $data);
    }
}