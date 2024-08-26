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
    public function store(Request $request){

        print_r($request->all());
        exit;
        $validater = Validator::make($request->all(),[
            'name'=>'required',
            'slug'=>'required|unique:sub_sub_categories',
            'category'=>'required',
            'subcategory'=>'required',
            'status'=>'required',
        ]);
        if($validater->passes()){

            $subsubcategory = new SubSubCategory();
            $subsubcategory->name = $request->name;
            $subsubcategory->slug = $request->slug;
            $subsubcategory->category_id = $request->category;
            $subsubcategory->subcategory_id = $request->subcategory;
            $subsubcategory->status = $request->status;
            $subsubcategory->save();
            $request->session()->flash("success","Sub SubCatagory is added");
            return response()->json([
                'status'=>true,
                'message'=> 'Sub SubCatagory is added'
            ]);
        }
        else{
            return response([
                'status'=>false,
                'error'=>$validater->errors()
            ]);
        }

    }
}
