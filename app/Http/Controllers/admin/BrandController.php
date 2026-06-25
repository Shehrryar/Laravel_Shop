<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    private function adminUser()
    {
        return Auth::guard('admin')->user();
    }

    private function isVendor(): bool
    {
        $admin = $this->adminUser();

        return $admin && (int) $admin->role === 3;
    }

    private function vendorStoreId()
    {
        return $this->adminUser()?->store_id;
    }

    private function ensureVendorHasStore(): void
    {
        if ($this->isVendor() && empty($this->vendorStoreId())) {
            abort(403, 'Vendor account is not connected with any store.');
        }
    }

    private function ensureOwnBrand(Brand $brand): void
    {
        if (!$this->isVendor()) {
            return;
        }

        if ((int) $brand->store_id !== (int) $this->vendorStoreId()) {
            abort(403, 'You cannot manage another vendor brand.');
        }
    }

    private function assignStoreId(Brand $brand): void
    {
        if ($this->isVendor()) {
            $brand->store_id = $this->vendorStoreId();
        }
    }

    public function index(Request $request)
    {
        $this->ensureVendorHasStore();

        $brands = Brand::latest('id');

        /*
        |--------------------------------------------------------------------------
        | Vendor Brand Filter
        |--------------------------------------------------------------------------
        | Vendor can see only own store brands.
        */
        if ($this->isVendor()) {
            $brands->where('store_id', $this->vendorStoreId());
        }

        if (!empty($request->get('keyword'))) {
            $keyword = $request->get('keyword');

            $brands->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('slug', 'like', '%' . $keyword . '%');
            });
        }

        $brands = $brands->paginate(10);

        return view('admin.brands.list', compact('brands'));
    }

    public function create()
    {
        $this->ensureVendorHasStore();

        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $this->ensureVendorHasStore();

        $request->merge([
            'slug' => $request->slug ?: Str::slug($request->name),
            'status' => $request->status ?? 1,
        ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->passes()) {
            $brand = new Brand();

            $this->assignStoreId($brand);

            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->image = null;

            /*
            |--------------------------------------------------------------------------
            | Important
            |--------------------------------------------------------------------------
            | Save first so brand ID exists before image name is created.
            */
            $brand->save();

            if (!empty($request->image_id)) {
                $tempimage = TempImage::find($request->image_id);

                if (!empty($tempimage)) {
                    $extarray = explode('.', $tempimage->name);
                    $ext = last($extarray);

                    $new_image_name = $brand->id . '-' . time() . '.' . $ext;

                    $sourcePath = public_path() . '/temp/' . $tempimage->name;
                    $destinationPath = public_path() . '/upload/brands/' . $new_image_name;

                    if (File::exists($sourcePath)) {
                        File::copy($sourcePath, $destinationPath);

                        $brand->image = $new_image_name;
                        $brand->save();
                    }
                }
            }

            $message = 'Brand added successfully';
            session()->flash('success', $message);

            return response()->json([
                'status' => true,
                'message' => $message,
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }

    public function edit($id, Request $request)
    {
        $this->ensureVendorHasStore();

        $brand = Brand::find($id);

        if (empty($brand)) {
            session()->flash('error', 'Brand not found');

            return redirect()->route('brands.index');
        }

        $this->ensureOwnBrand($brand);

        return view('admin.brands.edit', compact('brand'));
    }

    public function update($id, Request $request)
    {
        $this->ensureVendorHasStore();

        $brand = Brand::find($id);

        if (empty($brand)) {
            return response()->json([
                'status' => false,
                'notfound' => true,
                'message' => 'Brand not found',
            ]);
        }

        $this->ensureOwnBrand($brand);

        $request->merge([
            'slug' => $request->slug ?: Str::slug($request->name),
            'status' => $request->status ?? 1,
        ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->passes()) {
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;

            if (!empty($request->image_id)) {
                $tempimage = TempImage::find($request->image_id);

                if (!empty($tempimage)) {
                    $oldImage = $brand->image;

                    $extarray = explode('.', $tempimage->name);
                    $ext = last($extarray);

                    $new_image_name = $brand->id . '-' . time() . '.' . $ext;

                    $sourcePath = public_path() . '/temp/' . $tempimage->name;
                    $destinationPath = public_path() . '/upload/brands/' . $new_image_name;

                    if (File::exists($sourcePath)) {
                        File::copy($sourcePath, $destinationPath);

                        $brand->image = $new_image_name;

                        if (!empty($oldImage)) {
                            $oldImagePath = public_path() . '/upload/brands/' . $oldImage;

                            if (File::exists($oldImagePath)) {
                                File::delete($oldImagePath);
                            }
                        }
                    }
                }
            }

            $brand->save();

            $message = 'Brand updated successfully';
            session()->flash('success', $message);

            return response()->json([
                'status' => true,
                'message' => $message,
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }

    public function destroy($id, Request $request)
    {
        $this->ensureVendorHasStore();

        $brand = Brand::find($id);

        if (empty($brand)) {
            session()->flash('error', 'Brand not found');

            return response()->json([
                'status' => false,
                'message' => 'Brand not found',
            ]);
        }

        $this->ensureOwnBrand($brand);

        if (!empty($brand->image)) {
            $imagePath = public_path() . '/upload/brands/' . $brand->image;

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $brand->delete();

        session()->flash('success', 'Brand deleted successfully');

        return response()->json([
            'status' => true,
            'message' => 'Brand deleted successfully',
        ]);
    }
}