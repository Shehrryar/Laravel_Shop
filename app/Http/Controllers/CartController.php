<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

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
            } else {
                $status = false;
                $message = $product->title . " Already added in the Cart";
            }

        } else {
            Cart::add($product->id, $product->title, 1, $product->price, ['productImage' => (!empty($product->product_images)) ? $product->product_images->first() : '']);
            $status = true;
            $message = $product->title . " Added to the Cart";
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }
    public function Cart()
    {
        $cartcontent =  Cart::content();
        $data['cartcontent'] = $cartcontent;
        return view('front.cart', $data);
    }
}
