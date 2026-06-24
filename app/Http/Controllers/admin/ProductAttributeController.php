<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use App\Models\Size;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
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
        return view('admin.ProductAttributes.create', $data);
    }

    public function store(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Ensure file is an image with specific formats and size limit
            'stock_quantity' => 'required|integer|min:1', // Ensure stock quantity is a positive integer
            'price' => 'required|numeric|min:0', // Ensure price is a positive number
            'compare_price' => 'nullable|numeric|min:0', // Optional field but must be numeric if provided
        ]);

        // If validation passes, proceed to store data
        if ($validator->passes()) {
            // Create a new ProductAttribute instance
            $productattribute = new ProductAttribute();

            // Handle file upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $request->product_id . '_' . $image->getClientOriginalName() . '_' . time() . '.' . $image->getClientOriginalExtension(); // Create a unique filename
                $image->move(public_path('/upload/products/Attributes_images/'), $imageName); // Move the image to the 'public/images' directory
                $productattribute->image = $imageName; // Store the image name in the model
            }

            // Assign other request values to the product attribute
            $productattribute->product_id = $request->product_id;
            $productattribute->quantity = $request->stock_quantity;
            $productattribute->original_price = $request->price;
            $productattribute->saling_price = $request->compare_price;
            $productattribute->color_id = $request->color; // Assuming a relationship exists
            $productattribute->size_id = $request->size; // Assuming a relationship exists

            // Save the product attribute
            $this->ensureOwnProduct($request->product_id);
            $productattribute->save();

            // Flash success message
            session()->flash('success', 'Product Attribute Added Successfully');

            // Return JSON response
            return response()->json([
                'status' => true,
                'message' => 'Product Attribute saved successfully',
            ]);
        } else {
            // Return validation errors as JSON response
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }


    public function edit(Request $request, $id)
    {
        $data = [];
        $ProductAttribute_edit = ProductAttribute::find($id);
        $this->ensureOwnProduct($ProductAttribute_edit->product_id);
        $products = Product::orderBy('title', 'ASC')->get();
        $colors = Color::orderBy('name', 'ASC')->get();
        $sizes = Size::orderBy('name', 'ASC')->get();
        $data['colors'] = $colors;
        $data['sizes'] = $sizes;
        $data['products'] = $products;
        $data['ProductAttribute_edit'] = $ProductAttribute_edit;
        return view('admin.ProductAttributes.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $productattribute_up = ProductAttribute::find($id);
        $validator = Validator::make($request->all(), [
            'product_id' => 'required', // Optional field but must be numeric if provided
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Ensure file is an image with specific formats and size limit
            'stock_quantity' => 'required|integer|min:1', // Ensure stock quantity is a positive integer
            'price' => 'required|numeric|min:0', // Ensure price is a positive number
            'compare_price' => 'nullable|numeric|min:0', // Optional field but must be numeric if provided
        ]);
        // If validation passes, proceed to store data
        if ($validator->passes()) {
            // Handle file upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $request->product_id . '_' . $image->getClientOriginalName() . '_' . time() . '.' . $image->getClientOriginalExtension(); // Create a unique filename
                $image->move(public_path('/upload/products/Attributes_images/'), $imageName); // Move the image to the 'public/images' directory
                $productattribute_up->image = $imageName; // Store the image name in the model
            }

            // Assign other request values to the product attribute
            $productattribute_up->product_id = $request->product_id;
            $productattribute_up->quantity = $request->stock_quantity;
            $productattribute_up->original_price = $request->price;
            $productattribute_up->saling_price = $request->compare_price;
            $productattribute_up->color_id = $request->color; // Assuming a relationship exists
            $productattribute_up->size_id = $request->size; // Assuming a relationship exists

            // Save the product attribute
            $this->ensureOwnProduct($request->product_id);
            $productattribute_up->save();

            // Flash success message
            session()->flash('success', 'Product Attribute Added Successfully');

            // Return JSON response
            return response()->json([
                'status' => true,
                'message' => 'Product Attribute saved successfully',
            ]);
        } else {
            // Return validation errors as JSON response
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy($id)
    {
        $ProductAttribute_del = ProductAttribute::find($id);
        $this->ensureOwnProduct($ProductAttribute_del->product_id);
        if ($ProductAttribute_del == null) {
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

    private function ensureOwnProduct($productId)
    {
        $admin = Auth::guard('admin')->user();

        if ($admin && (int) $admin->role === 3) {
            $exists = Product::where('id', $productId)
                ->where('store_id', $admin->store_id)
                ->exists();

            if (!$exists) {
                abort(403, 'You cannot manage attributes of another vendor product.');
            }
        }
    }



}
