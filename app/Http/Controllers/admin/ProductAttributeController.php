<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use App\Models\Size;
use App\Models\Color;
use App\Models\Product;


class ProductAttributeController extends Controller
{
    public function index()
    {
        $data[] = "";
        $product_attributes = ProductAttribute::latest('id')
            ->with('product')  // Eager load the 'product' relationship
            ->paginate(10);
        $data['product_attributes'] = $product_attributes;
        return view('admin.ProductAttributes.list', $data);
    }
    public function create()
    {
        $data = [];
        $products = Product::orderBy('title', 'ASC')->get();
        $colors = Color::orderBy('name', 'ASC')->get();
        $sizes = Size::orderBy('name', 'ASC')->get();
        $data['colors'] = $colors;
        $data['sizes'] = $sizes;
        $data['products'] = $products;
        return view('admin.ProductAttributes.create' , $data);
    }


    public function edit(Request $request,$id)
    {

    }






    public function destroy($id)
    {
        $ProductAttribute_del = ProductAttribute::find($id);

        if($ProductAttribute_del == null){
            session()->flash('error', 'Product Attribute is Not Found');
            return response()->json([
                'status' => true,
            ]);
        }
        $ProductAttribute_del->delete();

        session()->flash('success', 'Product Attribute Deleted Successfully');

        return response()->json([
            'status' => true,
        ]);
    }
}
