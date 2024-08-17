<?php

namespace App\Http\Controllers;

use App\Models\ProductRating;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    public function index(Request $request, $catslug = null, $subcatslug = null){

        $subcategroy_selected = "";
        $categroy_selected = "";
        $brandsArray = [];
        $categories = Category::orderBy('name','DESC')->with('sub_category')->where('status',1)->get();
        $brands = Brand::orderBy('name','DESC')->where('status',1)->get();
        $products = Product::where('status',1);
        if(!empty($catslug)){
            $categroy = Category::where('slug',$catslug)->first();
            $products = $products->where('categories_id',$categroy->id);
            $categroy_selected = $categroy->id;
        }
        if(!empty($subcatslug)){
            $subcategroy = SubCategory::where('slug',$subcatslug)->first();
            $products = $products->where('sub_category_id',$subcategroy->id);
            $subcategroy_selected = $subcategroy->id;
        }

        if(!empty($request->get('brand'))){
           $brandsArray = explode(',' ,$request->get('brand'));
           $products = $products->whereIn('brands_id', $brandsArray);
       }
       if($request->get('price_max') != '' && $request->get('price_min')){
           $products = $products->whereBetween('price', [intval($request->get('price_min')),intval($request->get('price_max'))]);
       }
       if($request->get('sort') != ''){
        if($request->get('sort') == 'latest'){
           $products = $products->orderBy('id','DESC'); 
       }elseif ($request->get('sort') == 'pricelow') {
           $products = $products->orderBy('price','ASC'); 
       }else{
           $products = $products->orderBy('price','DESC'); 
       }
   }else{
       $products = $products->orderBy('id','DESC'); 
   }

   $products = $products->paginate(6);

   $data['categories'] = $categories;
   $data['brands'] = $brands;
   $data['products'] = $products;
   $data['subcategroy_selected'] = $subcategroy_selected;
   $data['categroy_selected'] = $categroy_selected;
   $data['brandsArray'] = $brandsArray;
   $data['price_max'] = intval($request->get('price_max'));
   $data['price_min'] = intval($request->get('price_min'));
   $data['sort'] = $request->get('sort');
   return view('front.shop', $data);
}
public function product($slug){
    $product = Product::where('slug', $slug)
    ->withCount('product_ratings')->withSum('product_ratings','rating')->with('product_images')->first();    
    
    if($product == NULL){
        abort(404);
    }

    // fetch related products 
    $related_products = [];
    if($product != null){
        $related_products = explode(',', $product->related_products);
        $showrelatedproduct = Product::whereIn('id', $related_products)->with('product_images')->get();
    }

    $data['product'] =  $product;
    $data['showrelatedproduct'] =  $showrelatedproduct;
    $avgrating = '0.00';
    if($product->product_ratings_count>0){
        $avgrating = $product->product_ratings_sum_rating/$product->product_ratings_count;
    }
    $data['avgrating'] =  $avgrating;
    $data['countrating'] =  $product->product_ratings_count;
    return view('front.product', $data);
}

public function productRating(Request $request, $id){

    $validator = Validator::make($request->all(),[
        'name'=>'required|min:5',
        'email'=>'required|email',
        'review'=>'required|min:10',
        'rating'=>'required',
    ]);

    if($validator->fails()){
        return response()->json([
            'status'=>false,
            'errors'=>$validator->errors()
        ]);
    }

    $count = ProductRating::where('email', $request->email)->where('product_id',$id)->count();    
    if($count >0){
        session()->flash('error', 'You already rate this product');
        return response()->json([
            'status'=>true,
            'message'=>'You already rate this product'
        ]);
    }
    $productrating = new ProductRating();
    $productrating->product_id= $id;
    $productrating->username= $request->name;
    $productrating->email= $request->email;
    $productrating->comment= $request->review;
    $productrating->rating= $request->rating;
    $productrating->status= 0;
    $productrating->save();
    session()->flash('success', 'Thanks for your rating');
    return response()->json([
        'status'=>true,
        'message'=>'Thanks for your rating'
    ]);

}

}