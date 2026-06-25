<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Crypt;
use Illuminate\Support\Str;
use App\Models\TempImage;
use App\Http\Controllers\admin\Traits\VendorStoreScope;
class CategoryController extends Controller
{
    use VendorStoreScope;
    public function index(Request $request)
    {
        $categories = Category::latest();
        $categories = $this->applyStoreScope($categories);
        if (!empty($request->get('keyword'))) {
            $categories = $categories->where('name', 'like', '%' . $request->get('keyword') . '%');
        }
        $categories = $categories->paginate(10);
        return view('admin.category.list', compact('categories'));
    }
    public function create()
    {
        return view('admin.category.create');
    }
    public function store(Request $request)
    {
        // If slug is empty, generate it on the server side.
        // This prevents validation failure when the JavaScript slug event does not run.
        $request->merge([
            'slug' => $request->slug ?: Str::slug($request->name),
            'status' => $request->status ?? 1,
        ]);

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'slug' => 'required|unique:categories,slug',
                'status' => 'required|in:0,1',
            ]
        );

        if ($validator->passes()) {
            $category = new Category();
            $this->assignStoreId($category, $request);

            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->image = null;

            // IMPORTANT: save first so category ID exists.
            // Your old code saved only inside the image block, so categories without image were never saved.
            $category->save();

            if (!empty($request->image_id)) {
                $tempimage = TempImage::find($request->image_id);

                if (!empty($tempimage)) {
                    $extarray = explode('.', $tempimage->name);
                    $ext = last($extarray);

                    $new_image_name = $category->id . '-' . time() . '.' . $ext;
                    $spath = public_path() . '/temp/' . $tempimage->name;
                    $dpath = public_path() . '/upload/category/' . $new_image_name;

                    if (File::exists($spath)) {
                        File::copy($spath, $dpath);
                        $category->image = $new_image_name;
                        $category->save();
                    }
                }
            }

            $request->session()->flash('success', 'Category is added');

            return response()->json([
                'status' => true,
                'message' => 'Category is added',
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }
    public function slug_function(Request $request)
    {
        $slug = '';
        if (!empty($request->title)) {
            $slug = $request->title;
        }
        return response()->json([
            'status' => true,
            'slug' => $slug,
        ]);
    }
    public function edit($catid, Request $request)
    {
        $catid = Crypt::decrypt($catid);
        $category = Category::find($catid);
        $this->ensureOwnStoreRecord($category);
        return view('admin.category.edit', compact('category'));
    }
    public function update($cat_id, Request $request)
    {
        $cat_edit = Category::find($cat_id);
        $this->ensureOwnStoreRecord($cat_edit);
        if (empty($cat_edit))
            return response()->json([
                'status' => false,
                'not found' => true,
                'message' => 'Category not found'
            ]);
        $validater = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'slug' => 'required|unique:categories,slug,' . $cat_edit->id . ',id',
            ]
        );
        if ($validater->passes()) {
            $cat_edit->name = $request->name;
            $cat_edit->slug = $request->slug;
            $cat_edit->status = $request->status;
            $cat_edit->save();
            $oldimage = $cat_edit->image;
            if (!empty($request->image_id)) {
                $tempimage = TempImage::find($request->image_id);
                $extarray = explode('.', $tempimage->name);
                $ext = last($extarray);
                $new_image_name = $cat_edit->id . '-' . time() . '.' . $ext;
                $spath = public_path() . '/temp/' . $tempimage->name;
                $dpath = public_path() . '/upload/category/' . $new_image_name;
                File::copy($spath, $dpath);
                $cat_edit->image = $new_image_name;
                $cat_edit->save();
                /// delete old images heree
                File::delete(public_path() . '/upload/category/' . $oldimage);
            }
            $request->session()->flash("success", "Category updated successfully");
            return response()->json([
                'status' => true,
                'message' => 'Category updated successfully'
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
        $this->ensureOwnStoreRecord($cat_del);
        if (empty($cat_del)) {
            $request->session()->flash("Error", "Category not found");
            return response()->json([
                'status' => true,
                'message' => 'Category not found'
            ]);
        }
        File::delete(public_path() . '/upload/category/' . $cat_del->image);
        $cat_del->delete();
        $request->session()->flash("success", "Category deleted successfully");
        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully'
        ]);
    }
}