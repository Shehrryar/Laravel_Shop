<?php

namespace App\Http\Controllers\admin;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function index(Request $request){
        $subcategories = SubCategory::select('sub_categories.*','categories.name as catnami')->latest('sub_categories.id')->leftJoin('categories','categories.id','sub_categories.category_id');

        if(!empty($request->get('keyword'))){
            $subcategories = $subcategories->where('sub_categories.name','like','%'.$request->get('keyword').'%');
        }
        if(!empty($request->get('keyword'))){
            $subcategories = $subcategories->orwhere('categories.name','like','%'.$request->get('keyword').'%');
        }

        $subcategories = $subcategories->paginate(10);
        return view('admin.subcategory.list', compact('subcategories'));
    }   
    public function create(){

        $cat_data = Category::orderBy('name','ASC')->get();
        return view('admin.subcategory.create', compact('cat_data'));
    }

    public function store(Request $request){
        $validater = Validator::make($request->all(),[
            'name'=>'required',
            'slug'=>'required|unique:sub_categories',
            'category'=>'required',
            'status'=>'required',
        ]);
        if($validater->passes()){

            $subcategory = new SubCategory();
            $subcategory->name = $request->name;
            $subcategory->slug = $request->slug;
            $subcategory->category_id = $request->category;
            $subcategory->status = $request->status;
            $subcategory->save();

            $request->session()->flash("success","sub Catagorie is added");

            return response()->json([
                'status'=>true,
                'message'=> 'sub Catagorie is added'
            ]);
        }
        else{
            return response([
                'status'=>false,
                'error'=>$validater->errors()
            ]);
        }

    }

    public function edit($id, Request $request){

        $subcat = SubCategory::find($id);
        if(empty($subcat)){
            $request->session()->flash("error","sub Catagorie not found");
            return redirect()->route('subcategories.index');
        }
        $cat_data = Category::orderBy('name','ASC')->get();
        $data['cat_data'] = $cat_data;
        $data['subcat'] = $subcat;
        return view('admin.subcategory.edit', $data);
    }

    public function update($id , Request $request){

        $subcategory = SubCategory::find($id);

        if(empty($subcategory)){
            return response([
                'status'=>false,
                'notfound'=>true,
            ]);
        }

        $validater = Validator::make($request->all(),[
            'name'=>'required',
            'slug'=>'required|unique:sub_categories,slug,'.$subcategory->id.',id',
            'category'=>'required',
            'status'=>'required',
        ]);
        if($validater->passes()){


            $subcategory->name = $request->name;
            $subcategory->slug = $request->slug;
            $subcategory->category_id = $request->category;
            $subcategory->status = $request->status;
            $subcategory->save();

            $request->session()->flash("success","SubCatagory is updated successfully");

            return response()->json([
                'status'=>true,
                'message'=> 'subcategory is updated successfully'
            ]);
        }
        else{
            return response([
                'status'=>false,
                'error'=>$validater->errors()
            ]);
        }

    }

    public function destroy($id, Request $request){

                $scat_del = SubCategory::find($id);
        if(empty($scat_del)){
            $request->session()->flash("Error","SubCatagory not found");
                   return response()->json([
            'status'=>true,
            'notfound'=>true,
        ]);
        }
        
        $scat_del->delete();

        $request->session()->flash("success","SubCatagory deleted successfully");

        return response()->json([
            'status'=>true,
            'message'=> 'SubCatagory deleted successfully'
        ]);

    }
}
