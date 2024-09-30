<?php

namespace App\Http\Controllers;
use App\Models\ProductAttribute;

use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function change_color(Request $request){
        $color = $request->input('color');
        $product_attribute_data= ProductAttribute::where('color_id', $color)->get();
    }
}
