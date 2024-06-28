<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class DiscountCodeController extends Controller
{
    public function index()
    {

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
            $discountcode->discont_amount = $request->discont_amount;
            $discountcode->min_amount = $request->min_amount;
            $discountcode->status = $request->status;
            $discountcode->start_at = $request->start_at;
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
    public function edit()
    {

    }
    public function update()
    {

    }
    public function destroy()
    {

    }
}
