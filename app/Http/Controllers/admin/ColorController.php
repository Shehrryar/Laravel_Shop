<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
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

    private function vendorProductIds()
    {
        if (!$this->isVendor()) {
            return collect();
        }

        return Product::where('store_id', $this->vendorStoreId())->pluck('id');
    }

    private function productsForForm()
    {
        $products = Product::orderBy('title', 'ASC');

        if ($this->isVendor()) {
            $products->where('store_id', $this->vendorStoreId());
        }

        return $products->get();
    }

    private function sizesForForm()
    {
        $sizes = Size::orderBy('name', 'ASC');

        if ($this->isVendor()) {
            $sizes->whereIn('product_id', $this->vendorProductIds());
        }

        return $sizes->get();
    }

    private function productStoreId($productId)
    {
        return Product::where('id', $productId)->value('store_id');
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

    private function ensureOwnSize($sizeId, $productId): void
    {
        $size = Size::find($sizeId);

        if (!$size) {
            abort(404, 'Size not found.');
        }

        if ((int) $size->product_id !== (int) $productId) {
            abort(403, 'Selected size does not belong to selected product.');
        }

        if ($this->isVendor()) {
            $this->ensureOwnProduct($size->product_id);
        }
    }

    private function ensureOwnColor(Color $color): void
    {
        if (!$this->isVendor()) {
            return;
        }

        if ((int) $color->store_id !== (int) $this->vendorStoreId()) {
            abort(403, 'You cannot manage another vendor color.');
        }
    }

    public function index(Request $request)
    {
        $this->ensureVendorHasStore();

        $colors = Color::with(['product', 'size'])->latest('id');

        if ($this->isVendor()) {
            $colors->where('store_id', $this->vendorStoreId());
        }

        if (!empty($request->get('keyword'))) {
            $keyword = $request->get('keyword');

            $colors->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('value', 'like', '%' . $keyword . '%')
                    ->orWhereHas('product', function ($productQuery) use ($keyword) {
                        $productQuery->where('title', 'like', '%' . $keyword . '%');
                    })
                    ->orWhereHas('size', function ($sizeQuery) use ($keyword) {
                        $sizeQuery->where('name', 'like', '%' . $keyword . '%');
                    });
            });
        }

        $colors = $colors->paginate(10);

        return view('admin.colors.list', compact('colors'));
    }

    public function create()
    {
        $this->ensureVendorHasStore();

        return view('admin.colors.create', [
            'products' => $this->productsForForm(),
            'Size' => $this->sizesForForm(),
        ]);
    }

    public function store(Request $request)
    {
        $this->ensureVendorHasStore();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'value' => 'required',
            'product_id' => 'required|exists:products,id',
            'size_id' => 'required|exists:size,id',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->passes()) {
            $this->ensureOwnProduct($request->product_id);
            $this->ensureOwnSize($request->size_id, $request->product_id);

            $exists = Color::where('value', $request->value)
                ->where('product_id', $request->product_id)
                ->where('size_id', $request->size_id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'status' => false,
                    'exist' => true,
                    'message' => 'This color already exists for this product and size.',
                ]);
            }

            $color = new Color();
            $color->store_id = $this->productStoreId($request->product_id);
            $color->name = $request->name;
            $color->value = $request->value;
            $color->product_id = $request->product_id;
            $color->size_id = $request->size_id;
            $color->price = $request->price;
            $color->status = $request->status;
            $color->save();

            $request->session()->flash('success', 'Color added successfully');

            return response()->json([
                'status' => true,
                'message' => 'Color added successfully',
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

        $color = Color::find($id);

        if (empty($color)) {
            $request->session()->flash('error', 'Record not found');

            return redirect()->route('colorss.index');
        }

        $this->ensureOwnColor($color);

        return view('admin.colors.edit', [
            'color' => $color,
            'products' => $this->productsForForm(),
            'Size' => $this->sizesForForm(),
        ]);
    }

    public function update($id, Request $request)
    {
        $this->ensureVendorHasStore();

        $color = Color::find($id);

        if (empty($color)) {
            $request->session()->flash('error', 'Record not found');

            return response()->json([
                'status' => false,
                'notfound' => true,
            ]);
        }

        $this->ensureOwnColor($color);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'value' => 'required',
            'product_id' => 'required|exists:products,id',
            'size_id' => 'required|exists:size,id',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->passes()) {
            $this->ensureOwnProduct($request->product_id);
            $this->ensureOwnSize($request->size_id, $request->product_id);

            $exists = Color::where('value', $request->value)
                ->where('product_id', $request->product_id)
                ->where('size_id', $request->size_id)
                ->where('id', '!=', $color->id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'status' => false,
                    'exist' => true,
                    'message' => 'This color already exists for this product and size.',
                ]);
            }

            $color->store_id = $this->productStoreId($request->product_id);
            $color->name = $request->name;
            $color->value = $request->value;
            $color->product_id = $request->product_id;
            $color->size_id = $request->size_id;
            $color->price = $request->price;
            $color->status = $request->status;
            $color->save();

            $message = 'Color updated successfully';
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

    public function destroy($color_id, Request $request)
    {
        $this->ensureVendorHasStore();

        $color = Color::find($color_id);

        if (empty($color)) {
            $request->session()->flash('error', 'Color not found');

            return response()->json([
                'status' => false,
                'message' => 'Color not found',
            ]);
        }

        $this->ensureOwnColor($color);

        $color->delete();

        $request->session()->flash('success', 'Color deleted successfully');

        return response()->json([
            'status' => true,
            'message' => 'Color deleted successfully',
        ]);
    }
}