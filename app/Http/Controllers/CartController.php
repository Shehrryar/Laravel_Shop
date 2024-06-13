<?php

namespace App\Http\Controllers;

use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Country;
use Gloudemans\Shoppingcart\Facades\Cart;
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
        if (Cart::count() > 0) {

            $cartcontent = Cart::content();
            $productAlreadyExist = false;

            foreach ($cartcontent as $item) {
                if ($item->id == $product->id) {
                    $productAlreadyExist = true;
                }
            }

            if ($productAlreadyExist == false) {
                Cart::add($product->id, $product->title, 1, $product->price, ['productImage' => (!empty($product->product_images)) ? $product->product_images->first() : '']);
                $status = true;
                $message = $product->title . " Added in the Cart";
                session()->flash('success', $message);

            } else {
                $status = false;
                $message = $product->title . " Already added in the Cart";
            }

        } else {
            Cart::add($product->id, $product->title, 1, $product->price, ['productImage' => (!empty($product->product_images)) ? $product->product_images->first() : '']);
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
        $cartcontent = Cart::content();
        $data['cartcontent'] = $cartcontent;
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
            $message = "Cart updated sucessfully";
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

        $countries = Country::orderBy('name', 'ASC')->get();
        return view('front.checkout',['countries'=>$countries]);
    }

    public function processCheckout(Request $request){
        // apply validation

        $validator = Validator::make($request->all(),[
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
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'please fix the error',
                'errors' => $validator->errors()
            ]);
        }
        $user = Auth::user();
        CustomerAddress::updateOrCreate(
            ['user_id'=>$user->id],
            [
                'user_id'=>$user->id,
                'firstname'=>$request->firstname,
                'lastname'=>$request->lastname,
                'email'=>$request->email,
                'mobile'=>$request->mobile,
                'address'=>$request->address,
                'city'=>$request->city,
                'apartment'=>$request->apartment,
                'state'=>$request->state,
                'zip'=>$request->zip,
                'country_id'=>$request->country,
            ]
        );

        if($request->payment_method == 'cod'){
            $shipping = 0;
            $discount = 0;
            $subtotal = Cart::subtotal(2,'.','');
            $grandtotal = $subtotal + $shipping;

            $order = new Order();
            $order->subtotal = $subtotal;
            $order->shipping = $shipping;
            $order->grandtotal = $grandtotal;
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
                $orderitems =new OrderItem();
                $orderitems->product_id = $item->id;
                $orderitems->order_id = $order->id;
                $orderitems->name = $item->name;
                $orderitems->quantity = $item->qty;
                $orderitems->price = $item->price;
                $orderitems->total = $item->price * $item->qty;
                $orderitems->save();


                session()->flash('success','You have successfully placed your order');
                return response()->json([
                    'status' => true,
                    'message' => 'Order Saved Successfully',
                ]);
            }


        }
        else{

        }

    }

    public function thankyou(){
        
    }
}