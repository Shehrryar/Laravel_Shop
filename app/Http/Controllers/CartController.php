<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request){
        $product  = Product::with('product_images')->find($request->id);
        if($product == null){
            return response()->json([
                'status'=>false,
                'message'=>'Product not Found'
            ]); 
        }
        if(Cart::count()>0){
            
        }else{
            Cart::add($product->id, $product->title, 1, $product->price, ['productImage'=> (!empty($product->product_images)) ? $product->product_images->first(): '']);
        }
    }
    public function Cart(){
        dd(Cart::content());
        return view('front.cart');
    }
}
