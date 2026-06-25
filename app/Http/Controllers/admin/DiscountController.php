<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\admin\Traits\VendorStoreScope;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    use VendorStoreScope;

    private function productsForForm()
    {
        $products = Product::orderBy('title', 'ASC');

        // Vendor sees only own products
        if ($this->isVendor()) {
            $products->where('store_id', $this->vendorStoreId());
        }

        return $products->get();
    }

    private function ensureOwnProducts(array $productIds): void
    {
        if (!$this->isVendor()) {
            return;
        }

        $count = Product::whereIn('id', $productIds)
            ->where('store_id', $this->vendorStoreId())
            ->count();

        if ($count !== count($productIds)) {
            abort(403, 'You cannot create discount for another vendor product.');
        }
    }

    public function index(Request $request)
    {
        $Discount = Discount::latest('id');

        // Vendor sees only own store discounts
        $Discount = $this->applyStoreScope($Discount);

        if (!empty($request->get('keyword'))) {
            $Discount = $Discount->where('name', 'like', '%' . $request->get('keyword') . '%');
        }

        $Discount = $Discount->paginate(10);

        $products = $this->productsForForm();

        return view('admin.discount.list', [
            'Discount' => $Discount,
            'products' => $products,
        ]);
    }

    public function create()
    {
        $products = $this->productsForForm();

        return view('admin.discount.create', [
            'products' => $products,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'discount_name' => 'required',
            'type' => 'required|in:percentage,fixed',
            'select_product' => 'required|array',
            'select_product.*' => 'exists:products,id',
            'discount_amount' => 'required|numeric|min:0',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->passes()) {
            $productIds = array_map('intval', $request->select_product);

            // Vendor cannot select another vendor product
            $this->ensureOwnProducts($productIds);

            $discount = new Discount();

            // IMPORTANT: save vendor store_id
            $this->assignStoreId($discount, $request);

            $discount->name = $request->discount_name;
            $discount->type = $request->type;
            $discount->value = $request->discount_amount;
            $discount->product_ids = $productIds;
            $discount->status = $request->status;
            $discount->start_at = $request->starts_at;
            $discount->expires_at = $request->expires_at;
            $discount->save();

            session()->flash('success', 'Discount added successfully');

            return response()->json([
                'status' => true,
                'message' => 'Discount added successfully',
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }

    public function edit(Request $request, $id)
    {
        $discount_edit = Discount::find($id);

        if ($discount_edit == null) {
            session()->flash('error', 'Record not found');
            return redirect()->route('discount.index');
        }

        // Vendor cannot edit another vendor discount
        $this->ensureOwnStoreRecord($discount_edit);

        $discount_edit->start_at = $discount_edit->start_at
            ? \Carbon\Carbon::parse($discount_edit->start_at)->format('Y-m-d')
            : null;

        $discount_edit->expires_at = $discount_edit->expires_at
            ? \Carbon\Carbon::parse($discount_edit->expires_at)->format('Y-m-d')
            : null;

        $products = $this->productsForForm();

        return view('admin.discount.edit', [
            'discount_edit' => $discount_edit,
            'products' => $products,
        ]);
    }

    public function update(Request $request, $id)
    {
        $discount_edit = Discount::find($id);

        if ($discount_edit == null) {
            session()->flash('error', 'Record not found');

            return response()->json([
                'status' => false,
                'message' => 'Record not found',
            ]);
        }

        // Vendor cannot update another vendor discount
        $this->ensureOwnStoreRecord($discount_edit);

        $validator = Validator::make($request->all(), [
            'discount_name' => 'required',
            'type' => 'required|in:percentage,fixed',
            'select_product' => 'required|array',
            'select_product.*' => 'exists:products,id',
            'discount_amount' => 'required|numeric|min:0',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->passes()) {
            $productIds = array_map('intval', $request->select_product);

            // Vendor cannot select another vendor product
            $this->ensureOwnProducts($productIds);

            $discount_edit->name = $request->discount_name;
            $discount_edit->type = $request->type;
            $discount_edit->value = $request->discount_amount;
            $discount_edit->product_ids = $productIds;
            $discount_edit->status = $request->status;
            $discount_edit->start_at = $request->starts_at;
            $discount_edit->expires_at = $request->expires_at;
            $discount_edit->save();

            session()->flash('success', 'Discount updated successfully');

            return response()->json([
                'status' => true,
                'message' => 'Discount updated successfully',
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $discount = Discount::find($id);

        if ($discount == null) {
            session()->flash('error', 'Record not found');

            return response()->json([
                'status' => false,
                'message' => 'Record not found',
            ]);
        }

        // Vendor cannot delete another vendor discount
        $this->ensureOwnStoreRecord($discount);

        $discount->delete();

        session()->flash('success', 'Discount deleted successfully');

        return response()->json([
            'status' => true,
            'message' => 'Record deleted successfully',
        ]);
    }
}