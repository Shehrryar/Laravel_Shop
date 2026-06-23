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
use App\Models\Stock;
use App\Models\Size;
use App\Models\Color;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $products = Product::latest('id')
            ->with(['product_images', 'store']);

        // Vendor can see only his own store products
        if ($admin && (int) $admin->role === 3) {
            $products = $products->where('store_id', $admin->store_id);
        }

        if (!empty($request->get('keyword'))) {
            $products = $products->where('title', 'like', '%' . $request->get('keyword') . '%');
        }

        $products = $products->paginate(10);

        $data['product'] = $products;

        return view('admin.products.list', $data);
    }
    public function create()
    {
        $admin = Auth::guard('admin')->user();

        $data = [];

        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();
        $stocks = Stock::orderBy('id', 'ASC')->get();
        $colors = Color::orderBy('name', 'ASC')->get();
        $sizes = Size::orderBy('name', 'ASC')->get();

        $data['categories'] = $categories;
        $data['brands'] = $brands;
        $data['stocks'] = $stocks;
        $data['colors'] = $colors;
        $data['sizes'] = $sizes;

        // Only main admin needs store dropdown
        $data['stores'] = collect();

        if ($admin && (int) $admin->role === 2) {
            $data['stores'] = Store::where('status', 1)
                ->orderBy('store_name', 'ASC')
                ->get();
        }

        return view('admin.products.create', $data);
    }
    public function store(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $values = [
            'title' => 'required',
            'slug' => 'required|unique:products',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products',
            'category' => 'required|numeric',
            'is_featured' => 'required|in:1,0',
        ];

        if ($admin && (int) $admin->role === 2) {
            $values['store_id'] = 'required|exists:stores,id';
        }
        $validator = Validator::make($request->all(), $values);
        if ($validator->passes()) {
            $product = new Product;

            $admin = Auth::guard('admin')->user();

            if ($admin && (int) $admin->role === 3) {
                // Vendor product automatically belongs to vendor store
                $product->store_id = $admin->store_id;
            } else {
                // Main admin selects store from dropdown
                $product->store_id = $request->store_id;
            }

            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->price = $request->price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->status = $request->status;
            $product->categories_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->sub_sub_category_id = $request->subsub_category;
            $product->brands_id = $request->brand;
            $product->is_featured = $request->is_featured;
            $product->short_description = strip_tags($request->short_description);
            $product->description = strip_tags($request->description);
            $product->shipping_returns = strip_tags($request->shipping_return);
            if (!empty($request->related_product)) {
                $product->related_products = implode(',', $request->related_product);
            } else {
                $product->related_products = '';
            }
            $product->save();
            if (!empty($request->image_array)) {
                foreach ($request->image_array as $temp_value) {
                    $tempimage = TempImage::find($temp_value);
                    $productimage = new ProductImage();
                    $productimage->product_id = $product->id;
                    $productimage->image = $tempimage->name;
                    $productimage->size = $tempimage->size;
                    $productimage->save();
                    $spath = public_path() . '/temp/' . $tempimage->name;
                    $dpath = public_path() . '/upload/products/' . $tempimage->name;
                    File::copy($spath, $dpath);
                }
            }
            $request->session()->flash('success', 'product data is saved sucessufully');
            return response()->json([
                'status' => true,
                'message' => "data is saved sucessufully",
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => $validator->errors(),
            ]);
        }
    }
    public function edit($id, Request $request)
    {
        $product = Product::find($id);
        if (empty($product)) {
            return redirect()->route('product.index')->with('error', 'product not found');
        }
        $admin = Auth::guard('admin')->user();

        if ($admin && (int) $admin->role === 3 && (int) $product->store_id !== (int) $admin->store_id) {
            abort(403, 'You cannot edit another vendor product.');
        }
        if ($product != null) {
            $related_products = explode(',', $product->related_products);
            $showrelatedproduct = Product::whereIn('id', $related_products)->get();
        }
        $subcategories = SubCategory::where('category_id', $product->categories_id)->get();
        $susubcategories = SubSubCategory::where('subcategory_id', $product->sub_category_id)->get();
        $categories = Category::orderBy('name', 'ASC')->get();
        $stocks = Stock::orderBy('id', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();
        $productimage = ProductImage::where('product_id', $product->id)->get();
        $productImages = $productimage->map(function ($image) {
            $filePath = "upload/products/{$image->image}"; // Path relative to the 'public' folder
            return [
                'name' => $image->image, // Image filename
                'size' => $image->size, // Directly fetch size from the database
                'url' => asset($filePath), // Public URL
            ];
        });
        $data['categories'] = $categories;
        $data['brands'] = $brands;
        $data['stocks'] = $stocks;
        $data['product'] = $product;
        $data['productimage'] = $productimage;
        $data['productImages'] = $productImages;
        $data['subcategories'] = $subcategories;
        $data['susubcategories'] = $susubcategories;
        $data['showrelatedproduct'] = $showrelatedproduct;

        $data['stores'] = collect();

        if ($admin && (int) $admin->role === 2) {
            $data['stores'] = Store::where('status', 1)
                ->orderBy('store_name', 'ASC')
                ->get();
        }
        return view('admin.products.edit', $data);
    }
    public function update($id, Request $request)
    {
        $product = Product::find($id);
        if (empty($product)) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
            ]);
        }

        $admin = Auth::guard('admin')->user();

        if ($admin && (int) $admin->role === 3 && (int) $product->store_id !== (int) $admin->store_id) {
            abort(403, 'You cannot update another vendor product.');
        }
        $values = [
            'title' => 'required',
            'slug' => 'required|unique:products,slug,' . $product->id . ',id',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products,sku,' . $product->id . ',id',
            'category' => 'required|numeric',
            'is_featured' => 'required|in:1,0',
        ];
        if ($admin && (int) $admin->role === 2) {
            $values['store_id'] = 'required|exists:stores,id';
        }
        $validator = Validator::make($request->all(), $values);
        if ($validator->passes()) {
            if (is_numeric($request->sub_category) && is_int((int) $request->sub_category)) {
                $subcategory_id = (int) $request->sub_category;
            } else {
                $subcategory_id = SubCategory::where('name', $request->sub_category)->value('id');
            }
            if ($admin && (int) $admin->role === 2) {
                $product->store_id = $request->store_id;
            }
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->price = $request->price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->status = $request->status;
            $product->categories_id = $request->category;
            $product->sub_category_id = $subcategory_id;
            $product->sub_sub_category_id = $request->subsub_category;
            $product->brands_id = $request->brand;
            $product->is_featured = $request->is_featured;
            $product->short_description = strip_tags($request->short_description);
            $product->description = strip_tags($request->description);
            $product->shipping_returns = strip_tags($request->shipping_return);
            if (!empty($request->related_product)) {
                $product->related_products = implode(',', $request->related_product);
            } else {
                $product->related_products = '';
            }
            $product->save();
            $request->session()->flash('success', 'Product data is updated sucessufully');
            return response()->json([
                'status' => true,
                'message' => "Product data is updated sucessufully",
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => $validator->errors(),
            ]);
        }
    }
    public function delete($id, Request $request)
    {
        $product = Product::find($id);
        if (empty($product)) {
            $request->session()->flash('error', 'Product not found');
            return response()->json([
                'status' => false,
                'notfound' => true
            ]);
        }
        $admin = Auth::guard('admin')->user();

        if ($admin && (int) $admin->role === 3 && (int) $product->store_id !== (int) $admin->store_id) {
            abort(403, 'You cannot delete another vendor product.');
        }

        // Retrieve product images
        $productImages = ProductImage::where('product_id', $id)->get();
        if (!empty($productImages)) {
            foreach ($productImages as $image) {
                // Delete image file
                File::delete(public_path('/upload/products/' . $image->image));
            }
            ProductImage::where('product_id', $id)->delete();
        }
        $product->delete();
        $request->session()->flash('success', 'Product deleted successfully');
        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully'
        ]);
    }
    public function getProducts(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $tempproducts = [];

        if ($request->term != "") {
            $products = Product::where('title', 'like', '%' . $request->term . '%');

            if ($admin && (int) $admin->role === 3) {
                $products = $products->where('store_id', $admin->store_id);
            }

            $products = $products->get();

            if ($products != null) {
                foreach ($products as $keyprod) {
                    $tempproducts[] = [
                        'id' => $keyprod->id,
                        'text' => $keyprod->title,
                    ];
                }
            }
        }

        return response()->json([
            'tags' => $tempproducts,
            'status' => 'true',
        ]);
    }
    function importProducts(Request $request)
    {
        $file = $request->file('file');
        $validator = Validator::make(
            ['file' => $file],
            ['file' => 'required|mimes:csv,txt']
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator,
                'status' => 'false'
            ]);
        }
        $filePath = $file->getRealPath();
        $fileData = array_map('str_getcsv', file($filePath));
        $header = array_shift($fileData);
        $admin = Auth::guard('admin')->user();
        for ($i = 0; $i < count($fileData); $i++) {
            $data = array_combine($header, $fileData[$i]);
            $data = array_map(function ($value) {
                return $value === 'NULL' ? null : $value;
            }, $data);
            $data['is_featured'] = $data['is_featured'] === 'Yes' ? true : false;
            $data['status'] = $data['status'] === '1' ? true : false;
            Product::updateOrCreate(
                ['title' => $data['title']],
                [
                    'store_id' => ($admin && (int) $admin->role === 3)
                        ? $admin->store_id
                        : ($data['store_id'] ?? null),
                    'slug' => $data['slug'],
                    'description' => $data['description'],
                    'short_description' => $data['short_description'],
                    'shipping_returns' => $data['shipping_returns'],
                    'related_products' => $data['related_products'],
                    'saling_price' => $data['price'],
                    // 'compare_price' => $data['compare_price'],
                    'categories_id' => $data['categories_id'],
                    'sub_category_id' => $data['sub_category_id'],
                    // 'sub_sub_category_id' => $data['sub_sub_category_id'],
                    'brands_id' => $data['brands_id'],
                    'is_featured' => $data['is_featured'] === 'Yes' ? true : false,
                    'sku' => $data['sku'],
                    'barcode' => $data['barcode'],
                    // 'track_qty' => $data['track_qty'] === 'Yes' ? true : false,
                    // 'qty' => $data['qty'],
                    'status' => $data['status'] === '1' ? true : false,
                ]
            );
        }
        return response()->json([
            'status' => true,
            'message' => 'Prodcuts are import successfully'
        ]);
    }
}