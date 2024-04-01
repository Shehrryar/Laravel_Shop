<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempImage;

class imageuploadcontroller extends Controller
{
    public function create(Request $request){

        $image = $request->image;
        if(!empty($image)){
            $ext = $image->getClientOriginalExtension();
            $newname  = time().'.'.$ext;
            $tempimage = new TempImage();

            $tempimage->name = $newname;
            $tempimage->save();

            $image->move(public_path().'/temp',$newname);





             return response()->json([
              'status'=>true,
                'image_id'=>$tempimage->id,
                'message'=>'image uploadied sucesfully'
        ]);

        }

    }
}
