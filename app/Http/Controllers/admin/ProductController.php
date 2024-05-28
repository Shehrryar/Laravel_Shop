<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\TempImage;
use App\Models\SubCategory;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::latest('id')->with('product_images');
        if(!empty($request->get('keyword'))){
            $products = $products->where('title','like','%'.$request->get('keyword').'%');
        }
        $products = $products->paginate(10);
        $data['product'] = $products;
        return view('admin.products.list', $data);
    }
    public function create(){

        $data = [];
        $categories = Category::orderBy('name', 'ASC')->get();
        // $subcategories = SubCategory::where('category_id', $product->categories_id)->get();
        $brands = Brand::orderBy('name', 'ASC')->get();
        $data['categories'] = $categories;
        // $data['subcategories'] = $subcategories;
        $data['brands'] = $brands;
        return view('admin.products.create', $data);
    }


    public function store(Request $request){
        $values = [
            'title' => 'required',
            'slug' => 'required|unique:products',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products',
            'track_qty' => 'required|in:Yes,No',
            'category' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',            
        ];

        if(!empty($request->track_qty) && $request->track_qty == 'Yes'){
            $values['qty'] = 'required|numeric';
        }
        $validator = Validator::make($request->all(),$values);
        if($validator->passes()){
            $product = new Product;
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_qty = $request->track_qty;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->categories_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->brands_id = $request->brand;
            $product->is_featured = $request->is_featured;
            $product->short_description = $request->short_description;
            $product->description = $request->description;
            $product->shipping_returns = $request->shipping_return;
            $product->save();
            /// save gallery pics
            if(!empty($request->image_array)){
                foreach ($request->image_array as $temp_value) {
                    $tempimage = TempImage::find($temp_value);
                    $extarray = explode(',' , $tempimage->name);
                    $ext = last($extarray);
                    $productimage = new ProductImage();
                    $productimage->product_id = $product->id;
                    $new_image_name = $product->id.'-'.$productimage->id.'-'.time().'.'.$ext;
                    $productimage->image = $new_image_name;
                    $productimage->save();
                    $spath = public_path().'/temp/'.$tempimage->name;
                    $dpath = public_path().'/upload/products/'.$new_image_name;
                    File::copy($spath,$dpath);
                }
            }
            $request->session()->flash('success','product data is saved sucessufully');
            return response()->json([
                'status' => true,
                'message' => "data is saved sucessufully",
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'error' => $validator->errors(),
            ]);
        }
    }
    public function edit($id, Request $request){
        $product = Product::find($id);
        if(empty($product)){
            return redirect()->route('product.index')->with('error','product not found');
        }
        $productimage = ProductImage::where('product_id',$product->id)->get();
        $subcategories = SubCategory::where('category_id', $product->categories_id)->get();
        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();
        $data['categories'] = $categories;
        $data['brands'] = $brands;
        $data['product'] = $product;
        $data['productimage'] = $productimage;
        $data['subcategories'] = $subcategories;



        return view('admin.products.edit', $data);
    }
    public function update($id, Request $request){

        $product = Product::find($id);
        $values = [
            'title' => 'required',
            'slug' => 'required|unique:products,slug,'.$product->id.',id',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products,sku,'.$product->id.',id',
            'track_qty' => 'required|in:Yes,No',
            'category' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',            
        ];
        if(!empty($request->track_qty) && $request->track_qty == 'Yes'){
            $values['qty'] = 'required|numeric';
        }
        $validator = Validator::make($request->all(),$values);
        if($validator->passes()){
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_qty = $request->track_qty;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->categories_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->brands_id = $request->brand;
            $product->is_featured = $request->is_featured;
            $product->short_description = $request->short_description;
            $product->description = $request->description;
            $product->shipping_returns = $request->shipping_return;
            $product->save();

            $request->session()->flash('success','product data is updated sucessufully');

            return response()->json([
                'status' => true,
                'message' => "data is updated sucessufully",
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'error' => $validator->errors(),
            ]);
        }
    }

 public function delete($id, Request $request)
{
    $product = Product::find($id);
    
    if (empty($product)){
        $request->session()->flash('error','Product not found');
        return response()->json([
            'status'=> false,
            'notfound'=>true
        ]);
    }
    
    // Retrieve product images
    $productImages = ProductImage::where('product_id', $id)->get();
    
    if(!empty($productImages)){
        foreach ($productImages as $image) {
            // Delete image file
            File::delete(public_path('/upload/products/'.$image->image));
        }

        ProductImage::where('product_id', $id)->delete();
    }
    $product->delete();
    
    $request->session()->flash('success','Product deleted successfully');
    
    return response()->json([
        'status'=> true,
        'message'=>'Product deleted successfully'
    ]);
}

}
