<?php
namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;


class OrderService
{
    /** Store Order in Database  */
    function createOrder($user, $cartItems, $request, $customerAddress)
    {
        // $coupon_discount_amount = 0;
        $subtotal = $request->totalcartamount;
        $shipping = $request->shippingAmount;
        $grandTotal = $request->totalPayable;
        $discount_coupon_amount = $request->discount_coupon_amount;
        $bagsavingvalue = $request->bagsavingvalue;

        $orderId = session()->get('order_id');
        $order = Order::find($orderId) ?? new Order();
        $order->user_id = $user->id;
        $order->subtotal = $subtotal;
        $order->discount = 0.00;
        $order->shipping = $shipping;
        $order->product_discount_amount = $bagsavingvalue;
        $order->grandtotal = $grandTotal;
        $order->coupon_discount_amount = $discount_coupon_amount;
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


        // translations
        $order->en_firstname_translation = $customerAddress->en_firstname_translation;
        $order->ur_firstname_translation = $customerAddress->ur_firstname_translation;
        $order->en_lastname_translation = $customerAddress->en_lastname_translation;
        $order->ur_lastname_translation = $customerAddress->ur_lastname_translation;
        $order->en_address_translation = $customerAddress->en_address_translation;
        $order->ur_address_translation = $customerAddress->ur_address_translation;
        $order->en_city_translation = $customerAddress->en_city_translation;
        $order->ur_city_translation = $customerAddress->ur_city_translation;
        $order->en_state_translation = $customerAddress->en_state_translation;
        $order->ur_state_translation = $customerAddress->ur_state_translation;



        $order->save();
        foreach ($cartItems as $item) {
            // 1. Check if same product already exists in order_items
            $existingOrderItem = OrderItem::where('order_id', $order->id)
                ->where('product_id', $item->product_id)
                ->where('cart_id', $item->id)
                ->first();

            // 2. Update stock
            $stock = DB::table('stocks')
                ->where('product_id', $item->product_id)
                ->where('color_id', $item->color_id)
                ->where('size_id', $item->size_id)
                ->where('status', 1)
                ->first();
            DB::table('stocks')->where('id', $stock->id)->update([
                'quantity' => $stock->quantity - $item->quantity,
                'sold_quantity' => $stock->sold_quantity + $item->quantity,
            ]);
            if ($existingOrderItem) {
                // 3. Update quantity and total
                $existingOrderItem->quantity += $item->quantity;
                $existingOrderItem->total = $existingOrderItem->price;
                $existingOrderItem->save();
            } else {
                // 4. Create new order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'cart_id' => $item->id,
                    'name' => $item->title,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->price,
                    'discounted_price' => $item->discounted_price,
                    'discounted_value' => $item->discounted_value,
                    'additional_attributes' => $item->additional_attributes,
                ]);
            }
        }
        /** Putting the Order id in session */
        session()->put('order_id', $order->id);
        /** Putting the grand total amount in session */
        session()->put('grand_total', $order->grandtotal);
        return true;

    }

    /** Clear Session Items  */
    function clearSession()
    {
        Cart::where('user_id', auth()->id())->delete();   // delete cart rows for this user
        session()->forget('order_id');
        session()->forget('grand_total');
    }


    function orderdetails($id)
    {

        $user = Auth::user();
        $order = Order::where('user_id', $user->id)->where('id', $id)->first();
        $orderitems = OrderItem::where('order_id', $id)->get();
        $orderitemscount = OrderItem::where('order_id', $id)->count();
        $data['order'] = $order;
        $data['orderitemscount'] = $orderitemscount;
        $data['orderitems'] = $orderitems;
    }

}
