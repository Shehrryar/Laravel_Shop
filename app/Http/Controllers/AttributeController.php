<?php

namespace App\Http\Controllers;
use App\Models\ProductAttribute;
use App\Models\Discount;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function change_color(Request $request){
        $color = $request->input('color');
        $product_attribute_data= ProductAttribute::where('color_id', $color)->first();
        $discount = Discount::where('status', 1)->get();
        $discountedPrice = getDiscountedPrice($product_attribute_data->product_id, $discount, $product_attribute_data->original_price);
        return response()->json([
            'status'=>true,
            'product_attribute_data' => $product_attribute_data,
            'discountedPrice' => $discountedPrice,
        ]);
    }
}