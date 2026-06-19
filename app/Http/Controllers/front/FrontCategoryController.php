<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\SubCategory;
class FrontCategoryController extends Controller
{
    public function getAllCategory()
    {
        return Inertia::render('Front/Categaries');
    }
    public function getInnerCategory(Request $request, $category_id)
    {

        $brands = Brand::OrderBy('name', 'ASC')->where('status', 1)->get();
        $subcategories = SubCategory::where('category_id', $category_id)->with('sub_sub_category')->latest()->get();
        // Optionally, also fetch the main category
        $category = Category::find($category_id);


        // echo '<pre>';
        // print_r($subcategories);
        // echo '</pre>';
        // exit;
        
        return Inertia::render('Front/InnerCategaries', [
            'category' => $category,
            'subcategories' => $subcategories,
            'brands' => $brands,
        ]);
    }
}