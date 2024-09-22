<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductAttribute;
class ProductAttributeController extends Controller
{
    public function index(){
        $data[] = "";
        $product_attributes = ProductAttribute::latest('id')->paginate(10);
        $data['product_attributes'] = $product_attributes;
        return view('admin.ProductAttributes.list', $data);
    }
}
