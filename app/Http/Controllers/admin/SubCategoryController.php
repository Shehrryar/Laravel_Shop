<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\admin\Traits\VendorStoreScope;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    use VendorStoreScope;

    private function categoriesForForm()
    {
        $categories = Category::orderBy('name', 'ASC');

        if ($this->isVendor()) {
            $categories->where('store_id', $this->vendorStoreId());
        }

        return $categories->get();
    }

    private function ensureOwnCategory($categoryId): void
    {
        if (!$this->isVendor()) {
            return;
        }

        $exists = Category::where('id', $categoryId)
            ->where('store_id', $this->vendorStoreId())
            ->exists();

        if (!$exists) {
            abort(403, 'You cannot use another vendor category.');
        }
    }

    private function categoryStoreId($categoryId)
    {
        return Category::where('id', $categoryId)->value('store_id');
    }

    public function index(Request $request)
    {
        $subcategories = SubCategory::select('sub_categories.*', 'categories.name as catnami')
            ->leftJoin('categories', 'categories.id', '=', 'sub_categories.category_id')
            ->latest('sub_categories.id');

        /*
        |--------------------------------------------------------------------------
        | Vendor Filter
        |--------------------------------------------------------------------------
        | Vendor can see only own store subcategories.
        */
        if ($this->isVendor()) {
            $subcategories->where('sub_categories.store_id', $this->vendorStoreId());
        }

        if (!empty($request->get('keyword'))) {
            $keyword = $request->get('keyword');

            $subcategories->where(function ($query) use ($keyword) {
                $query->where('sub_categories.name', 'like', '%' . $keyword . '%')
                    ->orWhere('categories.name', 'like', '%' . $keyword . '%')
                    ->orWhere('sub_categories.slug', 'like', '%' . $keyword . '%');
            });
        }

        $subcategories = $subcategories->paginate(10);

        return view('admin.subcategory.list', compact('subcategories'));
    }

    public function create()
    {
        $cat_data = $this->categoriesForForm();

        return view('admin.subcategory.create', compact('cat_data'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'slug' => $request->slug ?: Str::slug($request->name),
            'status' => $request->status ?? 1,
        ]);

        $validater = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:sub_categories,slug',
            'category' => 'required|exists:categories,id',
            'status' => 'required|in:0,1',
        ]);

        if ($validater->passes()) {
            /*
            |--------------------------------------------------------------------------
            | Vendor Protection
            |--------------------------------------------------------------------------
            | Vendor cannot create subcategory under another vendor category.
            */
            $this->ensureOwnCategory($request->category);

            $subcategory = new SubCategory();
            $subcategory->store_id = $this->categoryStoreId($request->category);
            $subcategory->name = $request->name;
            $subcategory->slug = $request->slug;
            $subcategory->category_id = $request->category;
            $subcategory->status = $request->status;
            $subcategory->save();

            $request->session()->flash('success', 'Sub Category is added');

            return response()->json([
                'status' => true,
                'message' => 'Sub Category is added',
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validater->errors(),
        ]);
    }

    public function edit($id, Request $request)
    {
        $subcat = SubCategory::find($id);

        if (empty($subcat)) {
            $request->session()->flash('error', 'Sub Category not found');

            return redirect()->route('subcategories.index');
        }

        /*
        |--------------------------------------------------------------------------
        | Vendor Protection
        |--------------------------------------------------------------------------
        | Vendor cannot edit another vendor subcategory.
        */
        $this->ensureOwnStoreRecord($subcat);

        $cat_data = $this->categoriesForForm();

        return view('admin.subcategory.edit', [
            'cat_data' => $cat_data,
            'subcat' => $subcat,
        ]);
    }

    public function update($id, Request $request)
    {
        $subcategory = SubCategory::find($id);

        if (empty($subcategory)) {
            return response()->json([
                'status' => false,
                'notfound' => true,
                'message' => 'Sub Category not found',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Vendor Protection
        |--------------------------------------------------------------------------
        | Vendor cannot update another vendor subcategory.
        */
        $this->ensureOwnStoreRecord($subcategory);

        $request->merge([
            'slug' => $request->slug ?: Str::slug($request->name),
            'status' => $request->status ?? 1,
        ]);

        $validater = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:sub_categories,slug,' . $subcategory->id . ',id',
            'category' => 'required|exists:categories,id',
            'status' => 'required|in:0,1',
        ]);

        if ($validater->passes()) {
            /*
            |--------------------------------------------------------------------------
            | Vendor Protection
            |--------------------------------------------------------------------------
            | Vendor cannot move subcategory to another vendor category.
            */
            $this->ensureOwnCategory($request->category);

            $subcategory->store_id = $this->categoryStoreId($request->category);
            $subcategory->name = $request->name;
            $subcategory->slug = $request->slug;
            $subcategory->category_id = $request->category;
            $subcategory->status = $request->status;
            $subcategory->save();

            $request->session()->flash('success', 'SubCategory is updated successfully');

            return response()->json([
                'status' => true,
                'message' => 'SubCategory is updated successfully',
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validater->errors(),
        ]);
    }

    public function destroy($id, Request $request)
    {
        $scat_del = SubCategory::find($id);

        if (empty($scat_del)) {
            $request->session()->flash('error', 'SubCategory not found');

            return response()->json([
                'status' => false,
                'notfound' => true,
                'message' => 'SubCategory not found',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Vendor Protection
        |--------------------------------------------------------------------------
        | Vendor cannot delete another vendor subcategory.
        */
        $this->ensureOwnStoreRecord($scat_del);

        $scat_del->delete();

        $request->session()->flash('success', 'SubCategory deleted successfully');

        return response()->json([
            'status' => true,
            'message' => 'SubCategory deleted successfully',
        ]);
    }
}