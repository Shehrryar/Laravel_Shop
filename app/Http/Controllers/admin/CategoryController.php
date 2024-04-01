<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use Illuminate\Support\Facades\File;

use App\Models\TempImage;



class CategoryController extends Controller
{
    public function index(Request $request){


        $categories = Category::latest();

        if(!empty($request->get('keyword'))){

            $categories = $categories->where('name','like','%'.$request->get('keyword').'%');
        }

        $categories = $categories->paginate(10);



        return view('admin.category.list', compact('categories'));



    }
     public function create(){

        return view('admin.category.create');
    }
    public function store(Request $request){

        $validater = Validator::make($request->all(),
            ['name'=>'required', 
            'slug'=>'required|unique:categories',
        ]);

        if($validater->passes()){
            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->save();



         if(!empty($request->image_id)){
            $tempimage = TempImage::find($request->image_id);
            $extarray = explode('.', $tempimage->name);



            $ext = last($extarray);

            $new_image_name = $category->id.'.'.$ext;


            
            $spath = public_path().'/temp/'.$tempimage->name;

            $dpath = public_path().'/upload/category/'.$new_image_name;
            File::copy($spath,$dpath);

            $category->image = $new_image_name;
            $category->save();
            
            }

            $request->session()->flash("success","Catagorie is added");

            return response()->json([
                'status'=>true,
                'message'=> 'Catagorie is added'
        ]);


        }
        else{
            return response()->json([
                'status'=>false,
                'errors'=>$validater->errors()
        ]);
        }


    }

    
     public function slug_function(Request $request){
        $slug = '';
        if(!empty($request->title)){
         $slug = $request->title;         
        }
               return response()->json([
                'status'=>true,
                'slug'=>$slug,
        ]);
     }



     public function edit($catid, Request $request){

        $cat_edit = Category::find($catid);

        return view('admin.category.edit', compact('cat_edit'));
    }

     public function update($cat_id, Request $request){

          $cat_edit = Category::find($cat_id);

          if(empty($cat_edit))
           return response()->json([
                'status'=>false,
                'not found'=>ture,
                'message'=> 'Catagorie not found'
        ]);


         $validater = Validator::make($request->all(),
            ['name'=>'required', 
            'slug'=>'required|unique:categories,slug,'.$cat_edit->id.',id',
        ]);

        if($validater->passes()){

            $cat_edit->name = $request->name;
            $cat_edit->slug = $request->slug;
            $cat_edit->status = $request->status;
            $cat_edit->save();
            $oldimage = $cat_edit->image;


         if(!empty($request->image_id)){
            $tempimage = TempImage::find($request->image_id);
            $extarray = explode('.', $tempimage->name);



            $ext = last($extarray);

            $new_image_name = $cat_edit->id.'-'.time().'.'.$ext;


            
            $spath = public_path().'/temp/'.$tempimage->name;

            $dpath = public_path().'/upload/category/'.$new_image_name;
            File::copy($spath,$dpath);

            $cat_edit->image = $new_image_name;
            $cat_edit->save();

            /// delete old images heree

            File::delete(public_path().'/upload/category/'.$oldimage);
            }

            $request->session()->flash("success","Catagorie updated successfully");

            return response()->json([
                'status'=>true,
                'message'=> 'Catagorie updated successfully'
        ]);


        }
        else{
            return response()->json([
                'status'=>false,
                'errors'=>$validater->errors()
        ]);
        }

    }
     public function destroy($cat_id, Request $request){
        $cat_del = Category::find($cat_id);
        if(empty($cat_del)){
            $request->session()->flash("Error","Catagorie not found");
                   return response()->json([
            'status'=>true,
            'message'=> 'Catagorie not found'
        ]);
        }


        File::delete(public_path().'/upload/category/'.$cat_del->image);

        $cat_del->delete();

        $request->session()->flash("success","Catagorie deleted successfully");

        return response()->json([
            'status'=>true,
            'message'=> 'Catagorie deleted successfully'
        ]);
    }
}
