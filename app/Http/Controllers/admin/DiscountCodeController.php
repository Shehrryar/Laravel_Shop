<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\admin\Traits\VendorStoreScope;
use App\Models\DiscountCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscountCodeController extends Controller
{
    use VendorStoreScope;

    public function index(Request $request)
    {
        $DiscountCoupon = DiscountCoupon::latest('id');

        // Vendor sees only own store coupons
        $DiscountCoupon = $this->applyStoreScope($DiscountCoupon);

        if (!empty($request->get('keyword'))) {
            $DiscountCoupon = $DiscountCoupon->where(function ($query) use ($request) {
                $query->where('code', 'like', '%' . $request->get('keyword') . '%')
                    ->orWhere('name', 'like', '%' . $request->get('keyword') . '%');
            });
        }

        $DiscountCoupon = $DiscountCoupon->paginate(10);

        return view('admin.discount_coupon.list', compact('DiscountCoupon'));
    }

    public function create()
    {
        return view('admin.discount_coupon.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'type' => 'required|in:percent,fixed',
            'discount_amount' => 'required|numeric|min:0',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->passes()) {
            $discountcode = new DiscountCoupon();

            // IMPORTANT: save vendor store_id
            $this->assignStoreId($discountcode, $request);

            $discountcode->code = $request->code;
            $discountcode->name = $request->name;
            $discountcode->description = $request->description;
            $discountcode->max_user = $request->max_uses;
            $discountcode->max_user_user = $request->max_uses_user;
            $discountcode->type = $request->type;
            $discountcode->discont_amount = $request->discount_amount;
            $discountcode->min_amount = $request->min_amount;
            $discountcode->status = $request->status;
            $discountcode->start_at = $request->starts_at;
            $discountcode->expires_at = $request->expires_at;
            $discountcode->save();

            session()->flash('success', 'Discount Coupon added successfully');

            return response()->json([
                'status' => true,
                'message' => 'Discount Coupon added successfully',
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }

    public function edit(Request $request, $id)
    {
        $coupon_edit = DiscountCoupon::find($id);

        if ($coupon_edit == null) {
            session()->flash('error', 'Record not found');
            return redirect()->route('coupon.index');
        }

        // Vendor cannot edit another vendor coupon
        $this->ensureOwnStoreRecord($coupon_edit);

        return view('admin.discount_coupon.edit', compact('coupon_edit'));
    }

    public function update(Request $request, $id)
    {
        $discountcode = DiscountCoupon::find($id);

        if ($discountcode == null) {
            session()->flash('error', 'Record not found');

            return response()->json([
                'status' => false,
                'message' => 'Record not found',
            ]);
        }

        // Vendor cannot update another vendor coupon
        $this->ensureOwnStoreRecord($discountcode);

        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'type' => 'required|in:percent,fixed',
            'discount_amount' => 'required|numeric|min:0',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->passes()) {
            $discountcode->code = $request->code;
            $discountcode->name = $request->name;
            $discountcode->description = $request->description;
            $discountcode->max_user = $request->max_uses;
            $discountcode->max_user_user = $request->max_uses_user;
            $discountcode->type = $request->type;
            $discountcode->discont_amount = $request->discount_amount;
            $discountcode->min_amount = $request->min_amount;
            $discountcode->status = $request->status;
            $discountcode->start_at = $request->starts_at;
            $discountcode->expires_at = $request->expires_at;
            $discountcode->save();

            session()->flash('success', 'Discount Coupon updated successfully');

            return response()->json([
                'status' => true,
                'message' => 'Discount Coupon updated successfully',
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $discountcode = DiscountCoupon::find($id);

        if ($discountcode == null) {
            session()->flash('error', 'Record not found');

            return response()->json([
                'status' => false,
                'message' => 'Record not found',
            ]);
        }

        // Vendor cannot delete another vendor coupon
        $this->ensureOwnStoreRecord($discountcode);

        $discountcode->delete();

        session()->flash('success', 'Discount Coupon deleted successfully');

        return response()->json([
            'status' => true,
            'message' => 'Record deleted successfully',
        ]);
    }
}