<?php
use App\Models\Category;
use App\Models\ProductImage;


function getcategories(){
	return Category::OrderBy('name', 'ASC')
	->with('sub_category')
	->where('status',1)
	->get();
}

function getProductImage($product_id){
	$image_data  = ProductImage::where('product_id',$product_id)->first();
	return $image_data;
}




if (!function_exists('transAdmin')) {
    function transAdmin($key, $replace = [], $locale = null)
    {
        return trans("admin::" . $key, $replace, $locale);
    }
}

if (!function_exists('transFront')) {
    function transFront($key, $replace = [], $locale = null)
    {
        return trans("front::" . $key, $replace, $locale);
    }
}



?>