<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\SubCategory;

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
    
}

}
