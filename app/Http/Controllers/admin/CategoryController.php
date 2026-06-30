<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\admin\Traits\VendorStoreScope;
use App\Models\Category;
use App\Models\TempImage;
use Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use VendorStoreScope;

    public function index(Request $request)
    {
        $categories = Category::latest('id');

        /*
        |--------------------------------------------------------------------------
        | Vendor Category Filter
        |--------------------------------------------------------------------------
        | Vendor can see only own store categories.
        */
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
        $request->merge([
            'slug' => $request->slug ?: Str::slug($request->name),
            'status' => $request->status ?? 1,
        ]);

        $validater = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'slug' => 'required|unique:categories,slug',
                'status' => 'required|in:0,1',
            ]
        );

        if ($validater->passes()) {
            $category = new Category();

            /*
            |--------------------------------------------------------------------------
            | Important for Vendor
            |--------------------------------------------------------------------------
            | Vendor category will be saved with logged-in vendor store_id.
            | Super admin category will have null store_id unless you add store dropdown.
            */
            $this->assignStoreId($category, $request);

            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->image = null;

            /*
            |--------------------------------------------------------------------------
            | Important Fix
            |--------------------------------------------------------------------------
            | Your old code saved category only inside image condition.
            | This save must happen even when no image is uploaded.
            */
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
            'errors' => $validater->errors(),
        ]);
    }

    public function slug_function(Request $request)
    {
        $slug = '';

        if (!empty($request->title)) {
            $slug = Str::slug($request->title);
        }

        return response()->json([
            'status' => true,
            'slug' => $slug,
        ]);
    }

    public function edit($catid, Request $request)
    {
        $catid = Crypt::decrypt($catid);

        $cat_edit = Category::find($catid);

        if (empty($cat_edit)) {
            $request->session()->flash('error', 'Category not found');

            return redirect()->route('categories.index');
        }

        /*
        |--------------------------------------------------------------------------
        | Vendor Protection
        |--------------------------------------------------------------------------
        | Vendor cannot edit another vendor category.
        */
        $this->ensureOwnStoreRecord($cat_edit);

        return view('admin.category.edit', compact('cat_edit'));
    }

    public function update($cat_id, Request $request)
    {
        $cat_edit = Category::find($cat_id);

        if (empty($cat_edit)) {
            return response()->json([
                'status' => false,
                'not found' => true,
                'message' => 'Category not found',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Vendor Protection
        |--------------------------------------------------------------------------
        | Vendor cannot update another vendor category.
        */
        $this->ensureOwnStoreRecord($cat_edit);

        $request->merge([
            'slug' => $request->slug ?: Str::slug($request->name),
            'status' => $request->status ?? 1,
        ]);

        $validater = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'slug' => 'required|unique:categories,slug,' . $cat_edit->id . ',id',
                'status' => 'required|in:0,1',
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

                if (!empty($tempimage)) {
                    $extarray = explode('.', $tempimage->name);
                    $ext = last($extarray);

                    $new_image_name = $cat_edit->id . '-' . time() . '.' . $ext;

                    $spath = public_path() . '/temp/' . $tempimage->name;
                    $dpath = public_path() . '/upload/category/' . $new_image_name;

                    if (File::exists($spath)) {
                        File::copy($spath, $dpath);

                        $cat_edit->image = $new_image_name;
                        $cat_edit->save();

                        if (!empty($oldimage)) {
                            $oldImagePath = public_path() . '/upload/category/' . $oldimage;

                            if (File::exists($oldImagePath)) {
                                File::delete($oldImagePath);
                            }
                        }
                    }
                }
            }

            $request->session()->flash('success', 'Category updated successfully');

            return response()->json([
                'status' => true,
                'message' => 'Category updated successfully',
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validater->errors(),
        ]);
    }

    public function destroy($cat_id, Request $request)
    {
        $cat_del = Category::find($cat_id);

        if (empty($cat_del)) {
            $request->session()->flash('error', 'Category not found');

            return response()->json([
                'status' => false,
                'message' => 'Category not found',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Vendor Protection
        |--------------------------------------------------------------------------
        | Vendor cannot delete another vendor category.
        */
        $this->ensureOwnStoreRecord($cat_del);

        if (!empty($cat_del->image)) {
            $imagePath = public_path() . '/upload/category/' . $cat_del->image;

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $cat_del->delete();

        $request->session()->flash('success', 'Category deleted successfully');

        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully',
        ]);
    }
}