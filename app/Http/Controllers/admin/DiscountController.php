<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class DiscountController extends Controller
{
    public function index(Request $request)
    {
        $Discount = Discount::latest();
        if(!empty($request->get('keyword'))){
            $Discount = $Discount->where('name','like','%'.$request->get('keyword').'%');
        }
        $Discount = $Discount->paginate(10);
        return view('admin.discount.list', compact('Discount'));
    }

    public function create()
    {
        $data = [];
        $products = Product::get();
        $data['products']=$products;
        return view('admin.discount.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'discount_name'=>'required',
            'type' => 'required',
            'select_product' => 'required|array',
            'discount_amount' => 'required|numeric',
            'status' => 'required',
        ]);

        if ($validator->passes()) {
            $discount = new Discount();
            $discount->name = $request->discount_name;
            $discount->type = $request->type;
            $discount->value = $request->discount_amount;
            $discount->product_ids = implode(',' , $request->select_product);
            $discount->status = $request->status;
            $discount->start_at = $request->starts_at;
            $discount->expires_at = $request->expires_at;
            $discount->save();

            $message = 'Discount added successfully';
            session()->flash('success', $message);
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

        $discount_edit = Discount::find($id);    
        if ($discount_edit == null) {
            session()->flash('error', 'Record not found');
            return redirect()->route('coupon.index');
        }
        $discount_edit->start_at = $discount_edit->start_at ? \Carbon\Carbon::parse($discount_edit->start_at)->format('Y-m-d') : null;
        $discount_edit->expires_at = $discount_edit->expires_at ? \Carbon\Carbon::parse($discount_edit->expires_at)->format('Y-m-d') : null;    
        $products = Product::all();
        $data = [
            'discount_edit' => $discount_edit,
            'products' => $products
        ];
        return view('admin.discount.edit', $data);
    }
    

    public function destroy(Request $request, $id)
    {
        $discount = Discount::find($id);
        if($discount == null){
            session()->flash('error', 'Record not found');
            return response()->json([
                'status' => true,
                'message' => 'Record not found'
            ]);
        }
        $discount->delete();
        return response()->json([
            'status' => true,
            'message' => 'Record deleted successfully'
        ]);

    }
}