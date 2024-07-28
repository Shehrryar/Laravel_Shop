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


?>