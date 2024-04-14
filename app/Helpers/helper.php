<?php
use App\Models\Category;

function getcategories(){
	return Category::OrderBy('name', 'ASC')
	->with('sub_category')
	->where('status',1)
	->get();
}
?>