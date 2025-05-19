<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\Onboarding;
use Illuminate\Support\Facades\File;
use Crypt;
use App\Models\TempImage;
class onboardingController extends Controller
{
    public function index(Request $request)
    {
        $onboarding = Onboarding::latest();
        if (!empty($request->get('keyword'))) {
            $onboarding = $onboarding->where('title', 'like', '%' . $request->get('keyword') . '%');
        }
        $onboarding = $onboarding->paginate(10);
        return view('admin.onboarding.list', compact('onboarding'));
    }
    public function create()
    {
        return view('admin.onboarding.create');
    }
    public function store(Request $request)
    {
        $validater = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'subtitle' => 'required',
            ]
        );
        if ($validater->passes()) {
            $Onboarding = new Onboarding();
            $Onboarding->title = $request->title;
            $Onboarding->subtitle = $request->subtitle;
            $Onboarding->image = "nanananana";
            // if (!empty($request->image_id)) {
            //     $tempimage = TempImage::find($request->image_id);
            //     $extarray = explode('.', $tempimage->name);
            //     $ext = last($extarray);
            //     $new_image_name = $category->id . '.' . $ext;
            //     $spath = public_path() . '/temp/' . $tempimage->name;
            //     $dpath = public_path() . '/upload/category/' . $new_image_name;
            //     File::copy($spath, $dpath);
            //     $category->image = $new_image_name;
            // }
            $Onboarding->save();
            $request->session()->flash("success", "Onboarding is added");
            return response()->json([
                'status' => true,
                'message' => 'Onboarding is added'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validater->errors()
            ]);
        }
    }
    public function edit($catid, Request $request)
    {
        $onboard_edit = Onboarding::find($catid);
        return view('admin.onboarding.edit', compact('onboard_edit'));
    }
    public function update($cat_id, Request $request)
    {
        $cat_edit = Category::find($cat_id);
        if (empty($cat_edit))
            return response()->json([
                'status' => false,
                'not found' => true,
                'message' => 'onboarding not found'
            ]);
        $validater = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'subtitle' => 'required',
            ]
        );
        if ($validater->passes()) {
            $Onboarding = new Onboarding();
            $Onboarding->title = $request->title;
            $Onboarding->subtitle = $request->subtitle;
            $Onboarding->image = "nanananana";
            $Onboarding->save();
            // $oldimage = $cat_edit->image;
            // if (!empty($request->image_id)) {
            //     $tempimage = TempImage::find($request->image_id);
            //     $extarray = explode('.', $tempimage->name);
            //     $ext = last($extarray);
            //     $new_image_name = $cat_edit->id . '-' . time() . '.' . $ext;
            //     $spath = public_path() . '/temp/' . $tempimage->name;
            //     $dpath = public_path() . '/upload/category/' . $new_image_name;
            //     File::copy($spath, $dpath);
            //     $cat_edit->image = $new_image_name;
            //     $cat_edit->save();
            //     /// delete old images heree
            //     File::delete(public_path() . '/upload/category/' . $oldimage);
            // }
            $request->session()->flash("success", "onboarding updated successfully");
            return response()->json([
                'status' => true,
                'message' => 'onboarding updated successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validater->errors()
            ]);
        }
    }
    public function destroy($cat_id, Request $request)
    {
        $cat_del = Category::find($cat_id);
        if (empty($cat_del)) {
            $request->session()->flash("Error", "Catagorie not found");
            return response()->json([
                'status' => true,
                'message' => 'Catagorie not found'
            ]);
        }
        File::delete(public_path() . '/upload/category/' . $cat_del->image);
        $cat_del->delete();
        $request->session()->flash("success", "Catagorie deleted successfully");
        return response()->json([
            'status' => true,
            'message' => 'Catagorie deleted successfully'
        ]);
    }
}