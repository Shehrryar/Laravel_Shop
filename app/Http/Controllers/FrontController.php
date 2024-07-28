<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;




class FrontController extends Controller
{
    public function index(){
        $product = Product::where('is_featured','Yes')->where('status',1)->get();
        $latest_product = Product::OrderBy('id','DESC')->where('status',1)->take(8)->get();

        $data['featured_products'] = $product;
        $data['latest_product'] = $latest_product;

        return view('front.home', $data);
    }
    public function addToWishlist(Request $request){
        if(Auth::check()== false){
            session(['url.intended'=>url()->previous()]);
            return response()->json([
                'status'=>false
            ]);
        }


        $product = Product::where('id',$request->id)->first();
        if($product == null){
            return response()->json([
                'status'=>true,
                'message'=> '<div class = "alert alert-danger">Product not found.</div>'
            ]);
        }

        $wishlist = Wishlist::updateOrCreate(
            [   
                'user_id' => Auth::user()->id,
                'product_id'=>$request->id
            ],
            [   
                'user_id' => Auth::user()->id,
                'product_id'=>$request->id
            ]);

        return response()->json([
            'status'=>true,
            'message'=> '<div class = "alert alert-success"><strong>"'.$product->title.'"</strong> is added to the Wishlist.</div>'
        ]);


    }
}