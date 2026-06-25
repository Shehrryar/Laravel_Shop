<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StockManagementController extends Controller
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

    private function ensureOwnStock(Stock $stock): void
    {
        if (!$this->isVendor()) {
            return;
        }

        if ((int) $stock->store_id !== (int) $this->vendorStoreId()) {
            abort(403, 'You cannot manage another vendor stock.');
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
            abort(403, 'You cannot add stock for another vendor product.');
        }
    }

    private function getProductStoreId($productId)
    {
        return Product::where('id', $productId)->value('store_id');
    }

    private function formData(): array
    {
        $products = Product::orderBy('title', 'ASC');
        $colors = Color::orderBy('name', 'ASC');
        $sizes = Size::orderBy('name', 'ASC');

        if ($this->isVendor()) {
            $storeId = $this->vendorStoreId();

            $products->where('store_id', $storeId);

            // This needs store_id column in color table
            if (\Schema::hasColumn('color', 'store_id')) {
                $colors->where('store_id', $storeId);
            }

            // This needs store_id column in size table
            if (\Schema::hasColumn('size', 'store_id')) {
                $sizes->where('store_id', $storeId);
            }
        }

        return [
            'products' => $products->get(),
            'colors' => $colors->get(),
            'sizes' => $sizes->get(),
        ];
    }

    public function index(Request $request)
    {
        $this->ensureVendorHasStore();

        $stock = Stock::latest('stocks.id')
            ->with('product');

        /*
        |--------------------------------------------------------------------------
        | Vendor Stock Filter
        |--------------------------------------------------------------------------
        | Vendor can see only stock from own store.
        */
        if ($this->isVendor()) {
            $stock = $stock->where('store_id', $this->vendorStoreId());
        }

        if (!empty($request->get('keyword'))) {
            $keyword = $request->get('keyword');

            $stock = $stock->where(function ($query) use ($keyword) {
                $query->where('product_id', 'like', '%' . $keyword . '%')
                    ->orWhereHas('product', function ($productQuery) use ($keyword) {
                        $productQuery->where('title', 'like', '%' . $keyword . '%');
                    });
            });
        }

        $stock = $stock->paginate(10);

        $data = $this->formData();
        $data['stock'] = $stock;

        return view('admin.stocks.list', $data);
    }

    public function create()
    {
        $this->ensureVendorHasStore();

        $data = $this->formData();

        return view('admin.stocks.create', $data);
    }

    public function store(Request $request)
    {
        $this->ensureVendorHasStore();

        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|min:0',
            'select_product' => 'required|array',
            'select_product.0' => 'required|exists:products,id',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->passes()) {
            $productId = (int) $request->select_product[0];

            $this->ensureOwnProduct($productId);

            $stock = new Stock();
            $stock->store_id = $this->getProductStoreId($productId);
            $stock->quantity = $request->quantity;
            $stock->product_id = $productId;
            $stock->status = $request->status;
            $stock->color_id = $request->color_id ?? 0;
            $stock->size_id = $request->size_id ?? 0;
            $stock->sold_quantity = 0;
            $stock->save();

            $message = 'Stock added successfully';
            session()->flash('success', $message);

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

    public function edit(Request $request, $id)
    {
        $this->ensureVendorHasStore();

        $stock_edit = Stock::findOrFail($id);

        $this->ensureOwnStock($stock_edit);

        $data = $this->formData();
        $data['stock_edit'] = $stock_edit;

        return view('admin.stocks.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $this->ensureVendorHasStore();

        $stock_update = Stock::findOrFail($id);

        $this->ensureOwnStock($stock_update);

        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|min:0',
            'select_product' => 'required|array',
            'select_product.0' => 'required|exists:products,id',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->passes()) {
            $productId = (int) $request->select_product[0];

            $this->ensureOwnProduct($productId);

            $stock_update->store_id = $this->getProductStoreId($productId);
            $stock_update->quantity = $request->quantity;
            $stock_update->product_id = $productId;
            $stock_update->color_id = $request->color_id ?? 0;
            $stock_update->size_id = $request->size_id ?? 0;
            $stock_update->status = $request->status;
            $stock_update->save();

            $message = 'Stock updated successfully';
            session()->flash('success', $message);

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

    public function destroy(Request $request, $id)
    {
        $this->ensureVendorHasStore();

        $stock = Stock::find($id);

        if ($stock == null) {
            session()->flash('error', 'Record not found');

            return response()->json([
                'status' => false,
                'message' => 'Record not found',
            ]);
        }

        $this->ensureOwnStock($stock);

        $stock->delete();

        session()->flash('success', 'Stock deleted successfully');

        return response()->json([
            'status' => true,
            'message' => 'Record deleted successfully',
        ]);
    }
}