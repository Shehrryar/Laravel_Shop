<?php

namespace App\Http\Controllers;
use App\Models\ProductAttribute;
use App\Models\Discount;
use App\Models\Color;
use App\Models\Size;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function change_color(Request $request)
    {
        $color_image_name = array();
        $color = $request->input('color');
        $product_attribute_data = Color::where('id', $color)->first();
        $all_images = ProductImage::where('product_id', $product_attribute_data->product_id)
            ->pluck('image');
        foreach ($all_images as $value) {
            $colorName = preg_quote(strtolower($product_attribute_data->name), '/');
            if (preg_match("/$colorName/i", strtolower($value), $matches)) {
                $color_image_name['image_name_with_color'] = $value;
            } 
        }

        $discount = Discount::where('status', 1)->get();
        $discountedPrice = getDiscountedPrice($product_attribute_data->product_id, $discount, $product_attribute_data->price);


        return response()->json([
            'status' => true,
            'image_name_with_color'=>$color_image_name,
            'product_attribute_price' => $product_attribute_data->price,
            'discountedPrice' => $discountedPrice,
            'color_id' => $color,
        ]);
    }

    public function sizeChange(Request $request)
    {
        $size_name = array();
        $size_id = $request->input('size_id');
        $product_attribute_data = Size::where('id', $size_id)->first();
        $all_images = ProductImage::where('product_id', $product_attribute_data->product_id)
            ->pluck('image');
        foreach ($all_images as $value) {
            $sizeName = preg_quote(strtolower($product_attribute_data->name), '/');
            if (preg_match("/$sizeName/i", strtolower($value), $matches)) {
                $size_image_name['image_name_with_size'] = $value;
            } 
        }

        $discount = Discount::where('status', 1)->get();
        $discountedPrice = getDiscountedPrice($product_attribute_data->product_id, $discount, $product_attribute_data->price);

        return response()->json([
            'status' => true,
            'image_name_with_size'=>$size_image_name,
            'product_attribute_price' => $product_attribute_data->price,
            'discountedPrice' => $discountedPrice,
            'size_id' => $size_id,
        ]);
    }



    
}