<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
class ProductImageControlller extends Controller
{
    public function update(Request $request)
    {
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME); // Get the original name without extension
        $productimage = new ProductImage();
        $productimage->product_id = $request->product_id;
        $new_image_name = $originalName . '-' . $request->product_id . '-' . $productimage->id . '-' . time() . '.' . $ext;
        $productimage->image = $new_image_name;
        $productimage->save();
        $image->move(public_path() . '/upload/products/', $new_image_name);
        return response()->json([
            'status' => true,
            'image_id' => $productimage->id,
            'image_path' => asset('upload/products/' . $productimage->image),
            'message' => 'image added Sucessfully'
        ]);
    }
    public function destroy(Request $request)
    {
        $deletedRows = DB::table('product_images')->where('product_id', $request->product_id)
            ->where('image', $request->file_name)->delete();
        if (empty($deletedRows)) {
            return response()->json([
                'status' => false,
                'message' => 'image not found'
            ]);
        }
        File::delete(public_path('upload/products/' . $request->file_name));
        return response()->json([
            'status' => true,
            'message' => 'image deleted Sucessfully'
        ]);
    }
}