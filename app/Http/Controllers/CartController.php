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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;
use Stripe\Charge;
class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        if (Auth::check() == false) {
            return response()->json([
                'userlogin' => 'isnotlogged',
            ]);
        }
        $product = Product::with('product_images')->find($request->id);
        if ($product == null) {
            return response()->json([
                'status' => false,
                'message' => 'Product not Found'
            ]);
        }
        $cart_attribute = $request->attribute_Array;
        $discountprice = getDiscountedPrice($request->id, Discount::get(), $request->actual_price);
        if ($discountprice['discounted_price'] != 0) {
            $price = $discountprice['discounted_price'];
        } else {
            $price = $discountprice['actual_price'];
        }
        if (Cart::count() > 0) {
            $cartcontent = Cart::get();
            $productAlreadyExist = false;
            foreach ($cartcontent as $item) {
                if (!empty($cart_attribute)) {
                    if ($item->user_id == Auth::user()->id && $item->product_id == $product->id && $item->color_id == $cart_attribute['color_id'] && $item->size_id == $cart_attribute['size_id']) {
                        $productAlreadyExist = true;
                    }
                } else {
                    if ($item->user_id == Auth::user()->id && $item->product_id == $product->id && $item->color_id == 0 && $item->size_id == 0) {
                        $productAlreadyExist = true;
                    }
                }
            }
            if ($productAlreadyExist == false) {
                if (!empty($cart_attribute)) {
                    if ($cart_attribute['controller_type'] == 'color') {
                        Cart::create([
                            'user_id' => Auth::user()->id, // Assuming the user is logged in
                            'product_id' => $product->id,
                            'product_attribute_id' => $product->id,
                            'title' => $product->title . ' ' . $cart_attribute['color_name'] . ' ' . $cart_attribute['size_name'],
                            'color_id' => $cart_attribute['color_id'],
                            'size_id' => $cart_attribute['size_id'],
                            'quantity' => 1,
                            'price' => $price,
                            'product_image' => $cart_attribute['image_name_with_color']['image_name_with_color']
                            // 'product_image' => (!empty($product->product_images->first()->image)) ? $product->product_images->first()->image : ''
                        ]);
                    } elseif ($cart_attribute['controller_type'] == 'size') {
                        Cart::create([
                            'user_id' => Auth::user()->id, // Assuming the user is logged in
                            'product_id' => $product->id,
                            'product_attribute_id' => $product->id,
                            'title' => $product->title . ' ' . $cart_attribute['color_name'] . ' ' . $cart_attribute['size_name'],
                            'color_id' => $cart_attribute['color_id'],
                            'size_id' => $cart_attribute['size_id'],
                            'quantity' => 1,
                            'price' => $price,
                            'product_image' => $cart_attribute['image_name_with_size']['image_name_with_size']
                            // 'product_image' => (!empty($product->product_images->first()->image)) ? $product->product_images->first()->image : ''
                        ]);
                    }
                } else {
                    Cart::create([
                        'user_id' => Auth::user()->id, // Assuming the user is logged in
                        'product_id' => $product->id,
                        'product_attribute_id' => $product->id,
                        'title' => $product->title,
                        'color_id' => 0,
                        'size_id' => 0,
                        'quantity' => 1,
                        'price' => $price,
                        // 'product_image' => $cart_attribute['image_name_with_size']['image_name_with_size']
                        'product_image' => (!empty($product->product_images->first()->image)) ? $product->product_images->first()->image : ''
                    ]);
                }
                $status = true;
                $message = $product->title . " Added in the Cart";
                session()->flash('success', $message);
            } else {
                $status = false;
                $message = $product->title . " Already added in the Cart";
            }
        } else {
            if (!empty($cart_attribute)) {
                if ($cart_attribute['controller_type'] == 'color') {
                    Cart::create([
                        'user_id' => Auth::user()->id, // Assuming the user is logged in
                        'product_id' => $product->id,
                        'product_attribute_id' => $product->id,
                        'title' => $product->title . ' ' . $cart_attribute['color_name'] . ' ' . $cart_attribute['size_name'],
                        'color_id' => $cart_attribute['color_id'],
                        'size_id' => $cart_attribute['size_id'],
                        'quantity' => 1,
                        'price' => $price,
                        'product_image' => $cart_attribute['image_name_with_color']['image_name_with_color']
                        // 'product_image' => (!empty($product->product_images->first()->image)) ? $product->product_images->first()->image : ''
                    ]);
                } elseif ($cart_attribute['controller_type'] == 'size') {
                    Cart::create([
                        'user_id' => Auth::user()->id, // Assuming the user is logged in
                        'product_id' => $product->id,
                        'product_attribute_id' => $product->id,
                        'title' => $product->title . ' ' . $cart_attribute['color_name'] . ' ' . $cart_attribute['size_name'],
                        'color_id' => $cart_attribute['color_id'],
                        'size_id' => $cart_attribute['size_id'],
                        'quantity' => 1,
                        'price' => $price,
                        'product_image' => $cart_attribute['image_name_with_size']['image_name_with_size']
                        // 'product_image' => (!empty($product->product_images->first()->image)) ? $product->product_images->first()->image : ''
                    ]);
                }
            } else {
                Cart::create([
                    'user_id' => Auth::user()->id, // Assuming the user is logged in
                    'product_id' => $product->id,
                    'product_attribute_id' => $product->id,
                    'title' => $product->title,
                    'color_id' => 0,
                    'size_id' => 0,
                    'quantity' => 1,
                    'price' => $price,
                    // 'product_image' => $cart_attribute['image_name_with_size']['image_name_with_size']
                    'product_image' => (!empty($product->product_images->first()->image)) ? $product->product_images->first()->image : ''
                ]);
            }
            $status = true;
            $message = $product->title . " Added to the Cart";
            session()->flash('success', $message);
        }
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }
    public function Cart()
    {
        $discount = Discount::where('status', 1)->get();
        $cartcontent = Cart::where('user_id', auth()->id())->get();
        $cartcount = Cart::where('user_id', auth()->id())->count();
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
        $data['cartcount'] = $cartcount;
        $data['cartcontent'] = $cartcontent;
        $data['discount'] = $discount;
        $data['keyword'] = '';
        return view('front.cart', $data);
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
        $iteminfo = Cart::find($request->rowid);
        if ($iteminfo == null) {
            $error_message = 'item not found';
            session()->flash('error', $error_message);
            return response()->json([
                'status' => false,
                'message' => $error_message
            ]);
        } else {
            $iteminfo->delete();
            $message = 'item removed successfully';
            session()->flash('success', $message);
            return response()->json([
                'status' => true,
                'message' => $message
            ]);
        }
    }
    public function checkout()
    {
        $discount = 0;
        $discount_amo = 0;
        $discount_type = '';
        $cartcount = Cart::where('user_id', auth()->id())->count();
        $cartcontent = Cart::where('user_id', auth()->id())->get();
        $subtotal = getcartquantityandtotal()['totalPrice'];
        if ($cartcount == 0) {
            return redirect()->route('front.cart');
        }
        $customerAddress = CustomerAddress::where('user_id', Auth::user()->id)->first();
        $countries = Country::orderBy('name', 'ASC')->get();
        if (session()->has('code')) {
            $code = session()->get('code');
            if ($code->type == 'percent') {
                $discount = ($code->discont_amount / 100) * $subtotal;
                $discount_amo = $code->discont_amount;
                $discount_type = $code->type;
            } else {
                $discount_amo = $code->discont_amount;
                $discount_type = $code->type;
            }
        }
        // Calculate shiping here
        if (!empty($customerAddress->country_id)) {
            $usercountry = $customerAddress->country_id;
            $shipping_info = Shipping::where('country_id', $usercountry)->first();
            $totalqty = 0;
            $total_shipping = 0;
            foreach ($cartcontent as $item) {
                $totalqty += $item->quantity;
            }
            $total_shipping = $totalqty * $shipping_info->amount;
            $grand_total = ($subtotal - $discount) + $total_shipping;
        } else {
            $total_shipping = 0;
            $grand_total = ($subtotal - $discount) + $total_shipping;
        }
        return view(
            'front.checkout',
            [
                'cartcontent' => $cartcontent,
                'countries' => $countries,
                'customerAddress' => $customerAddress,
                'discount' => $discount_amo,
                'discount_type' => $discount_type,
                'subtotal' => $subtotal,
                'total_shipping' => number_format($total_shipping, 2),
                'grand_total' => $grand_total,
                'keyword' => ''
            ]
        );
    }
    public function processCheckout(Request $request)
    {
        $cartcontent = Cart::where('user_id', auth()->id())->get();
        $subtotal = getcartquantityandtotal()['totalPrice'];
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|min:5',
            'lastname' => 'required',
            'email' => 'required|email',
            'country' => 'required',
            'address' => 'required|min:30',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'mobile' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'please fix the error',
                'errors' => $validator->errors()
            ]);
        }
        $user = Auth::user();
        CustomerAddress::updateOrCreate(
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'address' => $request->address,
                'city' => $request->city,
                'apartment' => $request->apartment,
                'state' => $request->state,
                'zip' => $request->zip,
                'country_id' => $request->country,
            ]
        );
        if ($request->payment_method == 'cod') {
            $shipping = 0;
            $discount = 0;
            $promocode = '';
            if (session()->has('code')) {
                $code = session()->get('code');
                if ($code->type == 'percent') {
                    $discount = ($code->discont_amount / 100) * $subtotal;
                } else {
                    $discount = $code->discont_amount;
                }
                $discountcodeid = $code->id;
                $promocode = $code->code;
            }
            //calculate shipping 
            $shipping_info = Shipping::where('country_id', $request->country)->first();
            $totalqty = 0;
            foreach ($cartcontent as $item) {
                $totalqty += $item->quantity;
            }
            if (!empty($shipping_info) && $shipping_info != null) {
                $shipping = $totalqty * $shipping_info->amount;
                $grandtotal = ($subtotal - $discount) + $shipping;
            } else {
                $shipping = 10;
                $grandtotal = ($subtotal - $discount) + $shipping;
            }
            $order = new Order();
            $order->subtotal = $subtotal;
            $order->shipping = $shipping;
            $order->grandtotal = $grandtotal;
            $order->discount = $discount;
            $order->coupon_code = $promocode;
            $order->payment_status = 'not paid';
            $order->status = 'pending';
            $order->firstname = $request->firstname;
            $order->user_id = $user->id;
            $order->lastname = $request->lastname;
            $order->email = $request->email;
            $order->address = $request->address;
            $order->apartment = $request->apartment;
            $order->state = $request->state;
            $order->city = $request->city;
            $order->zip = $request->zip;
            $order->notes = $request->order_notes;
            $order->zip = $request->zip;
            $order->country_id = $request->country;
            // store order item in the order item table
            foreach ($cartcontent as $item) {
                $orderitems = new OrderItem();
                $orderitems->product_id = $item->product_id;
                $orderitems->cart_id = $item->id;
                $orderitems->name = $item->title;
                $orderitems->quantity = $item->quantity;
                $orderitems->price = $item->price;
                $orderitems->total = $item->price * $item->quantity;
                $orderitems->save();
                $stock = DB::table('stocks')
                    ->where('product_id', $item->product_id)
                    ->where('color_id', $item->color_id)
                    ->where('size_id', $item->size_id)
                    ->where('status', 1)
                    ->first();
                if (!empty($stock) && $item->quantity <= $stock->quantity) {
                    $currentQuantity = $stock->quantity;
                    $updatedQuantity = $currentQuantity - $item->quantity;
                    $soldQuantity = $stock->sold_quantity + $item->quantity;
                    // Update the stock record in the database
                    DB::table('stocks')
                        ->where('id', $stock->id)  // Assuming you have a unique identifier for the stock item
                        ->update([
                            'quantity' => $updatedQuantity,
                            'sold_quantity' => $soldQuantity,
                        ]);
                } else {
                    return response()->json([
                        'status' => 'stock_missing',
                        'message' => 'Stock is low for the --(<strong>' . $item->title . '</strong>)',
                    ]);
                }
            }
            $order->save();
            // orderEmail($order->id, 'customer');
            session()->flash('success', 'You have successfully placed your order');
            Cart::where('user_id', Auth::id())->delete();
            return response()->json([
                'status' => true,
                'message' => 'Order Saved Successfully',
                'orderId' => $order->id
            ]);
        } elseif ($request->payment_method == 'stripe') {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $shipping = 0;
            $discount = 0;
            $discountcodeid = '';
            $promocode = '';
            if (session()->has('code')) {
                $code = session()->get('code');
                if ($code->type == 'percent') {
                    $discount = ($code->discont_amount / 100) * $subtotal;
                } else {
                    $discount = $code->discont_amount;
                }
                $discountcodeid = $code->id;
                $promocode = $code->code;
            }
            //calculate shipping 
            $shipping_info = Shipping::where('country_id', $request->country)->first();
            $totalqty = 0;
            foreach ($cartcontent as $item) {
                $totalqty += $item->quantity;
            }
            if (!empty($shipping_info) && $shipping_info != null) {
                $shipping = $totalqty * $shipping_info->amount;
                $grandtotal = ($subtotal - $discount) + $shipping;
            } else {
                $shipping = 10;
                $grandtotal = ($subtotal - $discount) + $shipping;
            }
            $charge = Charge::create([
                'amount' => round($grandtotal * 100), // Amount in cents
                'currency' => 'usd',
                'source' => $request->stripeTokencard,
                'description' => 'Order payment for ' . $request->firstname . ' ' . $request->lastname,
                'metadata' => [
                    'user_id' => $user->id,
                    'email' => $request->email,
                    'order_notes' => $request->order_notes,
                ],
            ]);
            $order = new Order();
            $order->subtotal = $subtotal;
            $order->stripe_charge_id = $charge->id;
            $order->shipping = $shipping;
            $order->grandtotal = $grandtotal;
            $order->discount = $discount;
            $order->coupon_code = $promocode;
            $order->payment_status = 'paid';
            $order->status = 'pending';
            $order->firstname = $request->firstname;
            $order->user_id = $user->id;
            $order->lastname = $request->lastname;
            $order->email = $request->email;
            $order->address = $request->address;
            $order->apartment = $request->apartment;
            $order->state = $request->state;
            $order->city = $request->city;
            $order->zip = $request->zip;
            $order->notes = $request->order_notes;
            $order->zip = $request->zip;
            $order->country_id = $request->country;
            // store order item in the order item table
            foreach ($cartcontent as $item) {
                $orderitems = new OrderItem();
                $orderitems->product_id = $item->product_id;
                $orderitems->cart_id = $item->id;
                $orderitems->name = $item->title;
                $orderitems->quantity = $item->quantity;
                $orderitems->price = $item->price;
                $orderitems->total = $item->price * $item->quantity;
                $orderitems->save();
                $stock = DB::table('stocks')
                    ->where('product_id', $item->product_id)
                    ->where('color_id', $item->color_id)
                    ->where('size_id', $item->size_id)
                    ->where('status', 1)
                    ->first();
                if (!empty($stock) && $item->quantity <= $stock->quantity) {
                    $currentQuantity = $stock->quantity;
                    $updatedQuantity = $currentQuantity - $item->quantity;
                    $soldQuantity = $stock->sold_quantity + $item->quantity;
                    // Update the stock record in the database
                    DB::table('stocks')
                        ->where('id', $stock->id)  // Assuming you have a unique identifier for the stock item
                        ->update([
                            'quantity' => $updatedQuantity,
                            'sold_quantity' => $soldQuantity,
                        ]);
                } else {
                    return response()->json([
                        'status' => 'stock_missing',
                        'message' => 'Stock is low for the --(<strong>' . $item->title . '</strong>)',
                    ]);
                }
            }
            $order->save();
            // orderEmail($order->id, 'customer');
            session()->flash('success', 'You have successfully placed your order');
            Cart::where('user_id', Auth::id())->delete();
            return response()->json([
                'status' => true,
                'message' => 'Order Saved Successfully',
                'orderId' => $order->id
            ]);
        }
    }
    public function processCheckout2(Request $request)
    {
        $cartcontent = Cart::where('user_id', auth()->id())->get();
        $subtotal = getcartquantityandtotal()['totalPrice'];
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|min:5',
            'lastname' => 'required',
            'email' => 'required|email',
            'country' => 'required',
            'address' => 'required|min:30',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'mobile' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'please fix the error',
                'errors' => $validator->errors()
            ]);
        }
        $user = Auth::user();
        CustomerAddress::updateOrCreate(
            ['user_id' => $user->id],
            $request->only('firstname', 'lastname', 'email', 'mobile', 'address', 'city', 'apartment', 'state', 'zip', 'country')
        );
        $discount = 0;
        $promocode = '';
        if (session()->has('code')) {
            $code = session()->get('code');
            $discount = $code->type == 'percent' ? ($code->discont_amount / 100) * $subtotal : $code->discont_amount;
            $promocode = $code->code;
        }
        $shipping_info = Shipping::where('country_id', $request->country)->first();
        $totalqty = $cartcontent->sum('quantity');
        $shipping = $shipping_info ? $totalqty * $shipping_info->amount : 10;
        $grandtotal = ($subtotal - $discount) + $shipping;
        $orderData = array_merge($request->only('firstname', 'lastname', 'email', 'address', 'apartment', 'state', 'city', 'zip', 'country', 'order_notes'), [
            'user_id' => $user->id,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'grandtotal' => $grandtotal,
            'discount' => $discount,
            'coupon_code' => $promocode,
            'payment_status' => $request->payment_method == 'stripe' ? 'paid' : 'not paid',
            'status' => 'pending',
        ]);
        if ($request->payment_method == 'stripe') {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $charge = Charge::create([
                'amount' => round($grandtotal * 100),
                'currency' => 'usd',
                'source' => $request->stripeTokencard,
                'description' => 'Order payment for ' . $request->firstname . ' ' . $request->lastname,
            ]);
            $orderData['stripe_charge_id'] = $charge->id;
        }
        foreach ($cartcontent as $item) {
            OrderItem::create([
                'product_id' => $item->product_id,
                'name' => $item->title,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total' => $item->price * $item->quantity,
            ]);
            $stock = Stock::where([
                ['product_id', $item->product_id],
                ['color_id', $item->color_id],
                ['size_id', $item->size_id],
                ['status', 1]
            ])->first();
            if ($stock && $item->quantity <= $stock->quantity) {
                $stock->decrement('quantity', $item->quantity);
                $stock->increment('sold_quantity', $item->quantity);
            } else {
                return response()->json([
                    'status' => 'stock_missing',
                    'message' => 'Stock is low for the --(<strong>' . $item->title . '</strong>)',
                ]);
            }
        }
        $order = Order::create($orderData);
        session()->flash('success', 'You have successfully placed your order');
        Cart::where('user_id', Auth::id())->delete();
        return response()->json([
            'status' => true,
            'message' => 'Order Saved Successfully',
            'orderId' => $order->id
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
        $code = DiscountCoupon::where('code', $request->code)->first();
        if ($code == null) {
            return response()->json([
                'status' => false,
                'message' => 'invalid discount coupon'
            ]);
        }
        $now = Carbon::now();
        if ($code->start_at != "") {
            $start_date = Carbon::createFromFormat('Y-m-d H:i:s', $code->start_at);
            if ($now->lt($start_date)) {
                return response()->json([
                    'status' => false,
                    'message' => 'The coupon cannot match the start date'
                ]);
            }
        }
        if ($code->expires_at != "") {
            $expire_date = Carbon::createFromFormat('Y-m-d H:i:s', $code->expires_at);
            if ($now->gt($expire_date)) {
                return response()->json([
                    'status' => false,
                    'message' => 'The coupon cannot match the end date'
                ]);
            }
        }
        session()->put('code', $code);
        return $this->getOrderSummary($request);
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
}