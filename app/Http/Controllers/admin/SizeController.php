<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
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

    private function ensureVendorHasStore(): void
    {
        if ($this->isVendor() && empty($this->vendorStoreId())) {
            abort(403, 'Vendor account is not connected with any store.');
        }
    }

    private function ensureOwnProduct($productId): void
    {
        if (!$this->isVendor()) {
            return;
        }

        $exists = Product::where('id', $productId)
            ->where('store_id', $this->vendorStoreId())
            ->exists();

        if (!$exists) {
            abort(403, 'You cannot use another vendor product.');
        }
    }

    private function ensureOwnSize(Size $size): void
    {
        if (!$this->isVendor()) {
            return;
        }

        if ((int) $size->store_id !== (int) $this->vendorStoreId()) {
            abort(403, 'You cannot manage another vendor size.');
        }
    }

    private function productStoreId($productId)
    {
        return Product::where('id', $productId)->value('store_id');
    }

    private function productsForForm()
    {
        $products = Product::orderBy('title', 'ASC');

        if ($this->isVendor()) {
            $products->where('store_id', $this->vendorStoreId());
        }

        return $products->get();
    }

    public function index(Request $request)
    {
        $this->ensureVendorHasStore();

        $size = Size::with('product')->latest('id');

        /*
        |--------------------------------------------------------------------------
        | Vendor Size Filter
        |--------------------------------------------------------------------------
        | Vendor can see only sizes connected with own store products.
        */
        if ($this->isVendor()) {
            $size->where('store_id', $this->vendorStoreId());
        }

        if (!empty($request->get('keyword'))) {
            $keyword = $request->get('keyword');

            $size->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('code', 'like', '%' . $keyword . '%')
                    ->orWhereHas('product', function ($productQuery) use ($keyword) {
                        $productQuery->where('title', 'like', '%' . $keyword . '%');
                    });
            });
        }

        $sizes = $size->paginate(10);

        return view('admin.size.list', [
            'sizes' => $sizes,
        ]);
    }

    public function create()
    {
        $this->ensureVendorHasStore();

        return view('admin.size.create', [
            'products' => $this->productsForForm(),
        ]);
    }

    public function store(Request $request)
    {
        $this->ensureVendorHasStore();

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'product_id' => 'required|exists:products,id',
                'price' => 'required|numeric|min:0',
                'code' => 'required',
                'status' => 'required|in:0,1',
            ]
        );

        if ($validator->passes()) {
            $this->ensureOwnProduct($request->product_id);

            $exists = Size::where('code', $request->code)
                ->where('product_id', $request->product_id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'status' => false,
                    'exist' => true,
                    'message' => 'Size code already exists for this product.',
                ]);
            }

            $size = new Size();
            $size->store_id = $this->productStoreId($request->product_id);
            $size->name = $request->name;
            $size->code = $request->code;
            $size->product_id = $request->product_id;
            $size->price = $request->price;
            $size->status = $request->status;
            $size->save();

            $request->session()->flash('success', 'Size added successfully');

            return response()->json([
                'status' => true,
                'message' => 'Size added successfully',
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }

    public function edit($id, Request $request)
    {
        $this->ensureVendorHasStore();

        $size = Size::find($id);

        if (empty($size)) {
            $request->session()->flash('error', 'Record not found');

            return redirect()->route('sizes.index');
        }

        $this->ensureOwnSize($size);

        return view('admin.size.edit', [
            'size' => $size,
            'products' => $this->productsForForm(),
        ]);
    }

    public function update($id, Request $request)
    {
        $this->ensureVendorHasStore();

        $size_edit = Size::find($id);

        if (empty($size_edit)) {
            $request->session()->flash('error', 'Record not found');

            return response()->json([
                'status' => false,
                'notfound' => true,
            ]);
        }

        $this->ensureOwnSize($size_edit);

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'product_id' => 'required|exists:products,id',
                'price' => 'required|numeric|min:0',
                'code' => 'required',
                'status' => 'required|in:0,1',
            ]
        );

        if ($validator->passes()) {
            $this->ensureOwnProduct($request->product_id);

            $exists = Size::where('code', $request->code)
                ->where('product_id', $request->product_id)
                ->where('id', '!=', $size_edit->id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'status' => false,
                    'exist' => true,
                    'message' => 'Size code already exists for this product.',
                ]);
            }

            $size_edit->store_id = $this->productStoreId($request->product_id);
            $size_edit->name = $request->name;
            $size_edit->code = $request->code;
            $size_edit->product_id = $request->product_id;
            $size_edit->price = $request->price;
            $size_edit->status = $request->status;
            $size_edit->save();

            $message = 'Size updated successfully';
            $request->session()->flash('success', $message);

            return response()->json([
                'status' => true,
                'message' => $message,
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }

    public function destroy($size_id, Request $request)
    {
        $this->ensureVendorHasStore();

        $size_del = Size::find($size_id);

        if (empty($size_del)) {
            $request->session()->flash('error', 'Size not found');

            return response()->json([
                'status' => false,
                'message' => 'Size not found',
            ]);
        }

        $this->ensureOwnSize($size_del);

        $size_del->delete();

        $request->session()->flash('success', 'Size deleted successfully');

        return response()->json([
            'status' => true,
            'message' => 'Size deleted successfully',
        ]);
    }
}