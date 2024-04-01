<?php

namespace App\Http\Controllers\admin;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;


class BrandController extends Controller
{
    public function index(Request $request){
        $brands = Brand::latest('id');
        if(!empty($request->get('keyword'))){

            $brands = $brands->where('name','like','%'.$request->get('keyword').'%');
        }
        $brands = $brands->paginate(10);

        return view('admin.brands.list', compact('brands'));
    }
    public function create(){
        return view('admin.brands.create');
    }

    public function store(Request $request){

        $validater = Validator::make($request->all(),
            ['name'=>'required', 
            'slug'=>'required|unique:brands',
            'status'=>'required',

        ]);

        if($validater->passes()){
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;

            $brand->save();

            return response()->json([
                'status'=>true,
                'message'=> 'brand added sucessfully'
            ]);
        }
        else{
            return response()->json([
                'status'=>false,
                'errors'=> $validater->errors()
            ]);
        }
    }

    public function edit($id, Request $request){

        $brand = Brand::find($id);
        if(empty($brand)){
            $request->session()->flash('error','Record not found');
            return redirect()->route('brands.index');
        }
        $data['brand'] = $brand; 
        return view('admin.brands.edit', $data);

    }

    public function update($id, Request $request){
        $brand_edit = Brand::find($id);
        if(empty($brand_edit)){
            $request->session()->flash('error','Record not found');
             return response()->json([
                'status'=>false,
                'notfound'=> true
            ]);
        }

        $validater = Validator::make($request->all(),
            ['name'=>'required', 
            'slug'=>'required|unique:brands',

            'slug'=>'required|unique:brands,slug,'.$brand_edit->id.',id',

            'status'=>'required',

        ]);

        if($validater->passes()){

            $brand_edit->name = $request->name;
            $brand_edit->slug = $request->slug;
            $brand_edit->status = $request->status;
            $brand_edit->save();

            $request->session()->flash('sucess','brand updated sucessfully');


            return response()->json([

                'status'=>true,
                'message'=> 'brand updated sucessfully'
            ]);
        }
        else{
            return response()->json([
                'status'=>false,
                'error'=>$validater->errors()
            ]);
        }
    }

         public function destroy($brnd_id, Request $request){
        $brnd_del = Brand::find($brnd_id);
        if(empty($brnd_del)){
            $request->session()->flash("Error","brand not found");
                   return response()->json([
            'status'=>true,
            'message'=> 'brand not found'
        ]);
        }

        $brnd_del->delete();

        $request->session()->flash("success","brand deleted successfully");

        return response()->json([
            'status'=>true,
            'message'=> 'brand deleted successfully'
        ]);
    }

}
