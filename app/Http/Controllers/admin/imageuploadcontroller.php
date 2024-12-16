<?php
namespace App\Http\Controllers\admin;
// use Intervention\Image\Facades\Image as Image;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\TempImage;
class imageuploadcontroller extends Controller
{
    public function create(Request $request)
    {
        $image = $request->image;
        if (!empty($image)) {
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME); // Get the original name without extension
            $ext = $image->getClientOriginalExtension();  // Get the file extension
            $newname = $originalName . '_' . time() . '.' . $ext;  // Concatenate original name, current timestamp, and extension
            $fileSizeInKB = filesize($image); // Convert bytes to kilobytes and round to 2 decimals
            $tempimage = new TempImage();
            $tempimage->name = $newname;
            $tempimage->size = $fileSizeInKB;
            $tempimage->save();
            $image->move(public_path() . '/temp', $newname);
            return response()->json([
                'status' => true,
                'image_id' => $tempimage->id,
                'imagepath' => asset('/temp/' . $newname),
                'message' => 'image uploaded sucesfully'
            ]);
        }
    }
}
