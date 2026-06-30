<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductSubCategoryController extends Controller
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

    public function index(Request $request)
    {
        if (!empty($request->category_id)) {
            $subcategories = SubCategory::where('category_id', $request->category_id)
                ->orderBy('name', 'ASC');

            if ($this->isVendor()) {
                $subcategories->where('store_id', $this->vendorStoreId());
            }

            return response()->json([
                'status' => true,
                'SubCategory' => $subcategories->get(),
            ]);
        }

        return response()->json([
            'status' => true,
            'SubCategory' => [],
        ]);
    }

    public function subcategory(Request $request)
    {
        if (!empty($request->subcategory_id)) {
            $subsubcategories = SubSubCategory::where('subcategory_id', $request->subcategory_id)
                ->orderBy('name', 'ASC');

            if ($this->isVendor()) {
                $subsubcategories->where('store_id', $this->vendorStoreId());
            }

            return response()->json([
                'status' => true,
                'SubSubCategory' => $subsubcategories->get(),
            ]);
        }

        return response()->json([
            'status' => true,
            'SubSubCategory' => [],
        ]);
    }
}