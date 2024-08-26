<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;

class SubSubCategoryController extends Controller
{
    public function index(Request $request){
        
        $subsubcategories = SubSubCategory::select(
            'sub_sub_categories.*',  
            'sub_categories.name as subcatname',  
            'categories.name as catnami'
        )
        ->leftJoin('sub_categories', 'sub_categories.id', '=', 'sub_sub_categories.subcategory_id') 
        ->leftJoin('categories', 'categories.id', '=', 'sub_categories.category_id')  
        ->latest('sub_sub_categories.id')->paginate(10);
    
    
        if(!empty($request->get('keyword'))){
            $subsubcategories = $subsubcategories->where('sub_categories.name','like','%'.$request->get('keyword').'%');
        }
        if(!empty($request->get('keyword'))){
            $subsubcategories = $subsubcategories->orwhere('categories.name','like','%'.$request->get('keyword').'%');
        }
        if(!empty($request->get('keyword'))){
            $subsubcategories = $subsubcategories->orwhere('sub_sub_categories.name','like','%'.$request->get('keyword').'%');
        }
        return view('admin.subsubcategory.list', compact('subsubcategories'));
    } 
    public function create(){
        $data = [];
        $cat_data = Category::orderBy('name','ASC')->get();
        $subcat_data = SubCategory::orderBy('name','ASC')->get();
        $data['cat_data']= $cat_data;
        $data['subcat_data']= $subcat_data;

        return view('admin.subsubcategory.create', $data);
    }
}
