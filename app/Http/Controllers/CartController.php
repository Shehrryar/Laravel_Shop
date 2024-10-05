<?php
namespace App\Http\Controllers;
use App\Models\CustomerAddress;
use App\Models\DiscountCoupon;
use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Country;
use App\Models\Shipping;
use Carbon\Carbon;
use App\Models\Cart;
// use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::with('product_images')->find($request->id);
        if ($product == null) {
            return response()->json([
                'status' => false,
                'message' => 'Product not Found'
            ]);
        }
        $discountprice = getDiscountedPrice($request->id, Discount::get(), $request->actual_price);
        if ($discountprice['discounted_price'] != 0) {
            $price = $discountprice['discounted_price'];
        } else {
            $price = $discountprice['actual_price'];
        }
        if (Cart::count() > 0) {
            $cartcontent = Cart::content();
            $productAlreadyExist = false;
            foreach ($cartcontent as $item) {
                if ($item->id == $product->id) {
                    $productAlreadyExist = true;
                }
            }
            if ($productAlreadyExist == false) {

                $cart = new Cart();

                Cart::add($product->id, $product->title, 1, $price, ['productImage' => (!empty($product->product_images)) ? $product->product_images->first() : '']);


                $status = true;
                $message = $product->title . " Added in the Cart";
                session()->flash('success', $message);
            } else {
                $status = false;
                $message = $product->title . " Already added in the Cart";
            }
        } else {
            Cart::add($product->id, $product->title, 1, $price, ['productImage' => (!empty($product->product_images)) ? $product->product_images->first() : '']);
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
        $cartcontent = Cart::content();
        $data['cartcontent'] = $cartcontent;
        $data['discount'] = $discount;
        $data['keyword'] = '';
        return view('front.cart', $data);
    }
    public function updateCart(Request $request)
    {
        $iteminfo = Cart::get($request->rowid);
        $product = Product::find($iteminfo->id);
        if ($product->track_qty == 'Yes') {
            if ($request->qty <= $product->qty) {
                Cart::update($request->rowid, $request->qty);
                $message = "Cart updated sucessfully";
                $status = True;
                session()->flash('success', $message);
            } else {
                $message = "Requested qty($request->qty) not available";
                $status = false;
                session()->flash('error', $message);
            }
        } else {
            Cart::update($request->rowid, $request->qty);
            $message = "Cart updated successfully";
            $status = True;
            session()->flash('success', $message);
        }
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }
    public function deleteitem(Request $request)
    {
        $iteminfo = Cart::get($request->rowid);
        if ($iteminfo == null) {
            $error_message = 'item not found';
            session()->flash('error', $error_message);
            return response()->json([
                'status' => false,
                'message' => $error_message
            ]);
        } else {
            Cart::remove($request->rowid);
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
        // if cart is empty redirect to the cart page
        $discount = 0;
        $discount_amo = 0;
        $discount_type = '';
        $subtotal = Cart::subtotal(2, '.', '');
        if (Cart::count() == 0) {
            return redirect()->route('front.cart');
        }
        // if user is not loogin redirect to the login page
        if (Auth::check() == false) {
            if (!session()->has('url.intended')) {
                session(['url.intended' => url()->current()]);
            }
            return redirect()->route('account.login');
        }
        session()->forget('url.intended');
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
            foreach (Cart::content() as $item) {
                $totalqty += $item->qty;
            }
            $total_shipping = $totalqty * $shipping_info->amount;
            $grand_total = ($subtotal - $discount) + $total_shipping;
        } else {
            $total_shipping = 0;
            $grand_total = ($subtotal - $discount) + $total_shipping;
            // echo $grand_total;
            // exit;
        }
        return view(
            'front.checkout',
            [
                'countries' => $countries,
                'customerAddress' => $customerAddress,
                'discount' => $discount_amo,
                'discount_type' => $discount_type,
                'total_shipping' => number_format($total_shipping, 2),
                'grand_total' => $grand_total,
                'keyword' => ''
            ]
        );
    }
    public function processCheckout(Request $request)
    {
        // apply validation
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
            $discountcodeid = '';
            $promocode = '';
            $subtotal = Cart::subtotal(2, '.', '');
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
            foreach (Cart::content() as $item) {
                $totalqty += $item->qty;
            }
            if ($shipping_info != null) {
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
            $order->save();
            // store order item in the order item table
            foreach (Cart::content() as $item) {
                $orderitems = new OrderItem();
                $orderitems->product_id = $item->id;
                $orderitems->order_id = $order->id;
                $orderitems->name = $item->name;
                $orderitems->quantity = $item->qty;
                $orderitems->price = $item->price;
                $orderitems->total = $item->price * $item->qty;
                $orderitems->save();
                // Updat product stock
                // $productData = Product::find($item->id);
                // $currentQuantity = $productData->qty;
                // $updatedquantity = $currentQuantity - $item->qty;
                // $productData->qty = $updatedquantity;
                // $productData->save();
            }
            orderEmail($order->id, 'customer');
            session()->flash('success', 'You have successfully placed your order');
            Cart::destroy();
            return response()->json([
                'status' => true,
                'message' => 'Order Saved Successfully',
                'orderId' => $order->id
            ]);
        }
    }
    public function getOrderSummary(Request $request)
    {
        $subtotal = Cart::subtotal(2, '.', '');
        // apply discount here
        $discount = 0;
        $discountString = '';
        if (session()->has('code')) {
            $code = session()->get('code');
            if ($code->type == 'percent') {
                $discount = ($code->discont_amount / 100) * $subtotal;
            } else {
                $discount = $code->discont_amount;
            }
            $discountString = '<div class="mt-4">
            <strong>' . session()->get('code')->code . '</strong>
            <a class="btn btn-sm btn-danger" id="remove-discount" ><i class="fa fa-times"></i></a>
        </div>';
        }
        if ($request->country_id > 0) {
            $shipping_info = Shipping::where('country_id', $request->country_id)->first();
            $totalqty = 0;
            foreach (Cart::content() as $item) {
                $totalqty += $item->qty;
            }
            if ($shipping_info != null) {
                $shipping_charge = $totalqty * $shipping_info->amount;
                $grand_total = ($subtotal - $discount) + $shipping_charge;
                return response()->json([
                    'status' => true,
                    'discount' => $discount,
                    'shipping_charge' => number_format($shipping_charge, 2),
                    'discountString' => $discountString,
                    'grand_total' => number_format($grand_total, 2)
                ]);
            } else {
                $shipping_charge = 10;
                $grand_total = ($subtotal - $discount) + $shipping_charge;
                return response()->json([
                    'status' => true,
                    'discount' => $discount,
                    'discountString' => $discountString,
                    'shipping_charge' => number_format($shipping_charge, 2),
                    'grand_total' => number_format($grand_total, 2)
                ]);
            }
        } else {
            return response()->json([
                'status' => true,
                'discount' => $discount,
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
        return view('front.thanks');
    }
}