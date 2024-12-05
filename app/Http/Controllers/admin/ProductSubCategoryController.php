<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\SubSubCategory;


class ProductSubCategoryController extends Controller
{
    public function index(Request $request)
    {
        if (!empty($request->category_id)) {
            $subcategories = SubCategory::where('category_id', $request->category_id)->orderBy('name', 'ASC')->get();
            return response()->json([
                'status' => true,
                'SubCategory' => $subcategories
            ]);
        } else {
            return response()->json([
                'status' => true,
                'SubCategory' => []
            ]);
        }
    }
    public function subcategory(Request $request)
    {


        $request->subcategory_id;
        if (!empty($request->subcategory_id)) {


            if (is_int($request->subcategory_id)) {
                $subsubcategories = SubSubCategory::where('subcategory_id', $request->subcategory_id)->orderBy('name', 'ASC')->get();
            } else {
                $subcategory_id = SubCategory::where('name', $request->subcategory_id)->value('id');
                $subsubcategories = SubSubCategory::where('subcategory_id', $subcategory_id)->orderBy('name', 'ASC')->get();

            }
            return response()->json([
                'status' => true,
                'SubSubCategory' => $subsubcategories
            ]);
        } else {
            return response()->json([
                'status' => true,
                'SubSubCategory' => []
            ]);
        }
    }
}
