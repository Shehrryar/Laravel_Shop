<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class DiscountCodeController extends Controller
{
    public function index(Request $request)
    {
        $DiscountCoupon = DiscountCoupon::latest();
        if(!empty($request->get('keyword'))){
            $DiscountCoupon = $DiscountCoupon->where('name','like','%'.$request->get('keyword').'%');
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
            'type' => 'required',
            'discount_amount' => 'required|numeric',
            'status' => 'required',
        ]);
        if ($validator->passes()) {

            $discountcode = new DiscountCoupon();
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

            $message = 'Discount Coupon added successfully';

            session()->flash('sucess', $message);

            return response()->json([
                'status' => true,
                'message' => $message
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function edit(Request $request, $id)
    {
        $coupon_edit = DiscountCoupon::find($id);

        if($coupon_edit == null){
            session()->flash('error', 'Record not found');
            return redirect()->route('coupon.index');
        }
        return view('admin.discount_coupon.edit', compact('coupon_edit'));
    }
    public function update(Request $request, $id)
    {
        $discountcode = DiscountCoupon::find($id);

        if($discountcode == null){
            session()->flash('error', 'Record not found');
            return response()->json([
                'status' => true,
                'message' => 'Record not found'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'type' => 'required',
            'discount_amount' => 'required|numeric',
            'status' => 'required',
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

            $message = 'Discount Coupon updated successfully';
            session()->flash('sucess', $message);
            return response()->json([
                'status' => true,
                'message' => $message
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function destroy(Request $request, $id)
    {
        $discountcode = DiscountCoupon::find($id);
        if($discountcode == null){
            session()->flash('error', 'Record not found');
            return response()->json([
                'status' => true,
                'message' => 'Record not found'
            ]);
        }
        $discountcode->delete();
        return response()->json([
            'status' => true,
            'message' => 'Record deleted successfully'
        ]);

    }
}
