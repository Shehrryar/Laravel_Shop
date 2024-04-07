<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductImage;
use Illuminate\Support\Facades\File;


class ProductImageControlller extends Controller
{
    public function update(Request $request){
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $spath = $image->getPathName();
        
        $productimage = new ProductImage();
        $productimage->product_id = $request->product_id;
        $new_image_name = $request->product_id.'-'.$productimage->id.'-'.time().'.'.$ext;
        $productimage->image = $new_image_name;
        $productimage->save();

        $image->move(public_path().'/upload/products/',$new_image_name);


        return response()->json([
            'status'=>true,
            'image_id'=> $productimage->id,
            'image_path'=>asset('upload/products/'.$productimage->image),
            'message'=>'image added Sucessfully'
        ]);
    }
    public function destroy(Request $request){

        $productimage = ProductImage::find($request->id);
        // delete images from folder
        if(empty($productimage)){
            return response()->json([
            'status'=>false,
            'message'=>'image not found'
        ]);
        }

        File::delete(public_path('upload/products'.$productimage->image));
        $productimage->delete();

        return response()->json([
            'status'=>true,
            'message'=>'image deleted Sucessfully'
        ]);

    }
}
