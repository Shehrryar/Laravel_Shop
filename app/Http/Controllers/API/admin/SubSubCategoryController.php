<?php
namespace App\Http\Controllers\API\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Validator;
use App\Models\SubSubCategory;
class SubSubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $subsubcategories = SubSubCategory::select(
            'sub_sub_categories.*',
            'sub_categories.name as subcatname',
            'categories.name as catnami'
        )
            ->leftJoin('sub_categories', 'sub_categories.id', '=', 'sub_sub_categories.subcategory_id')
            ->leftJoin('categories', 'categories.id', '=', 'sub_categories.category_id')
            ->latest('sub_sub_categories.id')->paginate(10);
        if (!empty($request->get('keyword'))) {
            $subsubcategories = $subsubcategories->where('sub_categories.name', 'like', '%' . $request->get('keyword') . '%');
        }
        if (!empty($request->get('keyword'))) {
            $subsubcategories = $subsubcategories->orwhere('categories.name', 'like', '%' . $request->get('keyword') . '%');
        }
        if (!empty($request->get('keyword'))) {
            $subsubcategories = $subsubcategories->orwhere('sub_sub_categories.name', 'like', '%' . $request->get('keyword') . '%');
        }
        $totalPages = $subsubcategories->lastPage(); // Total number of pages
        $currentPage = $subsubcategories->currentPage(); // Current page number
        $subsubcategoriesData = $subsubcategories->items(); // Extract subsubcategories as an array
        $newsubsubcategories['current_page'] = $currentPage;
        $newsubsubcategories['totalPages'] = $totalPages;
        $newsubsubcategories['subsubcategoriesData'] = $subsubcategoriesData;
        return response()->json([$newsubsubcategories]);
    }
    public function create()
    {
        $data = [];
        $cat_data = Category::orderBy('name', 'ASC')->get();
        $subcat_data = SubCategory::orderBy('name', 'ASC')->get();
        $data['cat_data'] = $cat_data;
        $data['subcat_data'] = $subcat_data;
        return response()->json([
            'data' => $data,
        ]);
    }
    public function store(Request $request)
    {
        $validater = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:sub_sub_categories',
            'category' => 'required',
            'subcategory' => 'required',
            'status' => 'required',
        ]);
        if ($validater->passes()) {
            $subsubcategory = new SubSubCategory();
            $subsubcategory->name = $request->name;
            $subsubcategory->slug = $request->slug;
            $subsubcategory->category_id = $request->category;
            $subsubcategory->subcategory_id = $request->subcategory;
            $subsubcategory->status = $request->status;
            $subsubcategory->save();
            // $request->session()->flash("success", "Sub SubCatagory is added");
            return response()->json([
                'status' => true,
                'message' => 'Sub SubCatagory is added'
            ]);
        } else {
            return response([
                'status' => false,
                'error' => $validater->errors()
            ]);
        }
    }
    public function edit($id, Request $request)
    {
        $subsubcat = SubSubCategory::find($id);
        if (empty($subsubcat)) {
            // $request->session()->flash("error", "level 3 Subcategory is not found");
            return redirect()->route('subsubcategories.index');
        }
        $cat_data = Category::orderBy('name', 'ASC')->get();
        $subcat_data = SubCategory::orderBy('name', 'ASC')->get();
        $data['cat_data'] = $cat_data;
        $data['subcat_data'] = $subcat_data;
        $data['subsubcat'] = $subsubcat;
        return response()->json([
            'data' => $data,
        ]);
    }
    public function update($id, Request $request)
    {
        $subsubcategory = SubSubCategory::find($id);
        if (empty($subsubcategory)) {
            return response([
                'status' => false,
                'notfound' => true,
            ]);
        }
        $validater = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:sub_sub_categories,slug,' . $subsubcategory->id . ',id',
            'category' => 'required',
            'subcategory' => 'required',
            'status' => 'required',
        ]);
        if ($validater->passes()) {
            $subsubcategory->name = $request->name;
            $subsubcategory->slug = $request->slug;
            $subsubcategory->category_id = $request->category;
            $subsubcategory->subcategory_id = $request->subcategory;
            $subsubcategory->status = $request->status;
            $subsubcategory->save();
            // $request->session()->flash("success", "Level 3 SubCatagory is updated successfully");
            return response()->json([
                'status' => true,
                'message' => 'Level 3 SubCatagory is updated successfully'
            ]);
        } else {
            return response([
                'status' => false,
                'error' => $validater->errors()
            ]);
        }
    }
    public function destroy($id, Request $request)
    {
        $scat_del = SubSubCategory::find($id);
        if (empty($scat_del)) {
            // $request->session()->flash("Error", "Level 3 SubCatagory not found");
            return response()->json([
                'status' => true,
                'notfound' => true,
            ]);
        }
        $scat_del->delete();
        // $request->session()->flash("success", "Level 3 SubCatagory deleted successfully");
        return response()->json([
            'status' => true,
            'message' => 'Level 3 SubCatagory deleted successfully'
        ]);
    }
}