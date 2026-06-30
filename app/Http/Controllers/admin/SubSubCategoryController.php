<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\admin\Traits\VendorStoreScope;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SubSubCategoryController extends Controller
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

    private function subcategoriesForForm()
    {
        $subcategories = SubCategory::orderBy('name', 'ASC');

        if ($this->isVendor()) {
            $subcategories->where('store_id', $this->vendorStoreId());
        }

        return $subcategories->get();
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

    private function ensureOwnSubCategory($subcategoryId, $categoryId = null): void
    {
        if (!$this->isVendor()) {
            return;
        }

        $query = SubCategory::where('id', $subcategoryId)
            ->where('store_id', $this->vendorStoreId());

        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        if (!$query->exists()) {
            abort(403, 'You cannot use another vendor sub category.');
        }
    }

    private function subCategoryStoreId($subcategoryId)
    {
        return SubCategory::where('id', $subcategoryId)->value('store_id');
    }

    public function index(Request $request)
    {
        $subsubcategories = SubSubCategory::select(
                'sub_sub_categories.*',
                'categories.name as category_name',
                'sub_categories.name as subcategory_name'
            )
            ->leftJoin('categories', 'categories.id', '=', 'sub_sub_categories.category_id')
            ->leftJoin('sub_categories', 'sub_categories.id', '=', 'sub_sub_categories.subcategory_id')
            ->latest('sub_sub_categories.id');

        /*
        |--------------------------------------------------------------------------
        | Vendor Filter
        |--------------------------------------------------------------------------
        | Vendor can see only own store level 3 categories.
        */
        if ($this->isVendor()) {
            $subsubcategories->where('sub_sub_categories.store_id', $this->vendorStoreId());
        }

        if (!empty($request->get('keyword'))) {
            $keyword = $request->get('keyword');

            $subsubcategories->where(function ($query) use ($keyword) {
                $query->where('sub_sub_categories.name', 'like', '%' . $keyword . '%')
                    ->orWhere('sub_sub_categories.slug', 'like', '%' . $keyword . '%')
                    ->orWhere('categories.name', 'like', '%' . $keyword . '%')
                    ->orWhere('sub_categories.name', 'like', '%' . $keyword . '%');
            });
        }

        $subsubcategories = $subsubcategories->paginate(10);

        return view('admin.subsubcategory.list', compact('subsubcategories'));
    }

    public function create()
    {
        $cat_data = $this->categoriesForForm();
        $subcat_data = $this->subcategoriesForForm();

        return view('admin.subsubcategory.create', compact('cat_data', 'subcat_data'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'slug' => $request->slug ?: Str::slug($request->name),
            'status' => $request->status ?? 1,
        ]);

        $validater = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:sub_sub_categories,slug',
            'category' => 'required|exists:categories,id',
            'subcategory' => 'required|exists:sub_categories,id',
            'status' => 'required|in:0,1',
        ]);

        if ($validater->passes()) {
            /*
            |--------------------------------------------------------------------------
            | Vendor Protection
            |--------------------------------------------------------------------------
            | Vendor cannot create level 3 category under another vendor category/subcategory.
            */
            $this->ensureOwnCategory($request->category);
            $this->ensureOwnSubCategory($request->subcategory, $request->category);

            $subsubcategory = new SubSubCategory();
            $subsubcategory->store_id = $this->subCategoryStoreId($request->subcategory);
            $subsubcategory->name = $request->name;
            $subsubcategory->slug = $request->slug;
            $subsubcategory->category_id = $request->category;
            $subsubcategory->subcategory_id = $request->subcategory;
            $subsubcategory->status = $request->status;
            $subsubcategory->save();

            $request->session()->flash('success', 'Sub Sub Category is added');

            return response()->json([
                'status' => true,
                'message' => 'Sub Sub Category is added',
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validater->errors(),
        ]);
    }

    public function edit($id, Request $request)
    {
        $subsubcat = SubSubCategory::find($id);

        if (empty($subsubcat)) {
            $request->session()->flash('error', 'Sub Sub Category not found');

            return redirect()->route('subsubcategories.index');
        }

        /*
        |--------------------------------------------------------------------------
        | Vendor Protection
        |--------------------------------------------------------------------------
        | Vendor cannot edit another vendor level 3 category.
        */
        $this->ensureOwnStoreRecord($subsubcat);

        $cat_data = $this->categoriesForForm();
        $subcat_data = $this->subcategoriesForForm();

        return view('admin.subsubcategory.edit', [
            'cat_data' => $cat_data,
            'subcat_data' => $subcat_data,
            'subsubcat' => $subsubcat,
        ]);
    }

    public function update($id, Request $request)
    {
        $subsubcategory = SubSubCategory::find($id);

        if (empty($subsubcategory)) {
            return response()->json([
                'status' => false,
                'notfound' => true,
                'message' => 'Sub Sub Category not found',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Vendor Protection
        |--------------------------------------------------------------------------
        | Vendor cannot update another vendor level 3 category.
        */
        $this->ensureOwnStoreRecord($subsubcategory);

        $request->merge([
            'slug' => $request->slug ?: Str::slug($request->name),
            'status' => $request->status ?? 1,
        ]);

        $validater = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:sub_sub_categories,slug,' . $subsubcategory->id . ',id',
            'category' => 'required|exists:categories,id',
            'subcategory' => 'required|exists:sub_categories,id',
            'status' => 'required|in:0,1',
        ]);

        if ($validater->passes()) {
            /*
            |--------------------------------------------------------------------------
            | Vendor Protection
            |--------------------------------------------------------------------------
            | Vendor cannot move level 3 category to another vendor category/subcategory.
            */
            $this->ensureOwnCategory($request->category);
            $this->ensureOwnSubCategory($request->subcategory, $request->category);

            $subsubcategory->store_id = $this->subCategoryStoreId($request->subcategory);
            $subsubcategory->name = $request->name;
            $subsubcategory->slug = $request->slug;
            $subsubcategory->category_id = $request->category;
            $subsubcategory->subcategory_id = $request->subcategory;
            $subsubcategory->status = $request->status;
            $subsubcategory->save();

            $request->session()->flash('success', 'Sub Sub Category is updated successfully');

            return response()->json([
                'status' => true,
                'message' => 'Sub Sub Category is updated successfully',
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validater->errors(),
        ]);
    }

    public function destroy($id, Request $request)
    {
        $subsubcat = SubSubCategory::find($id);

        if (empty($subsubcat)) {
            $request->session()->flash('error', 'Sub Sub Category not found');

            return response()->json([
                'status' => false,
                'notfound' => true,
                'message' => 'Sub Sub Category not found',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Vendor Protection
        |--------------------------------------------------------------------------
        | Vendor cannot delete another vendor level 3 category.
        */
        $this->ensureOwnStoreRecord($subsubcat);

        $subsubcat->delete();

        $request->session()->flash('success', 'Sub Sub Category deleted successfully');

        return response()->json([
            'status' => true,
            'message' => 'Sub Sub Category deleted successfully',
        ]);
    }
}