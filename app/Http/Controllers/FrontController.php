<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class FrontController extends Controller
{
    public function index(){
        $product = Product::where('is_featured','Yes')->where('status',1)->get();
        $latest_product = Product::OrderBy('id','DESC')->where('status',1)->take(8)->get();

        $data['featured_products'] = $product;
        $data['latest_product'] = $latest_product;

        return view('front.home', $data);
    }
}
