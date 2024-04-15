<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;


class ShopController extends Controller
{
    public function index(){

        $categories = Category::orderBy('name','DESC')->with('sub_category')->where('status',1)->get();
        $brands = Brand::orderBy('name','DESC')->where('status',1)->get();
        $products = Product::orderBy('id','DESC')->where('status',1)->get();

        $data['categories'] = $categories;
        $data['brands'] = $brands;
        $data['products'] = $products;

        return view('front.shop', $data);
    }

}
