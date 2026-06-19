<?php
namespace App\Http\Controllers\API\admin;
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
        if (!empty($request->get('keyword'))) {
            $Discount = $Discount->where('name', 'like', '%' . $request->get('keyword') . '%');
        }
        $Discount = $Discount->paginate(10);
        $totalPages = $Discount->lastPage(); // Total number of pages
        $currentPage = $Discount->currentPage(); // Current page number
        $DiscountData = $Discount->items(); // Extract Discount as an array
        $newDiscount['current_page'] = $currentPage;
        $newDiscount['totalPages'] = $totalPages;
        $newDiscount['DiscountData'] = $DiscountData;
        return response()->json([$newDiscount]);
    }
    public function create()
    {
        $data = [];
        $products = Product::get();
        $data['products'] = $products;
        return response()->json([
            'data' => $data,
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'discount_name' => 'required',
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
            $discount->product_ids = implode(',', $request->select_product);
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
        return response()->json([
            'data' => $data,
        ]);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'discount_name' => 'required',
            'type' => 'required',
            'select_product' => 'required|array',
            'discount_amount' => 'required|numeric',
            'status' => 'required',
        ]);
        $discount_edit = Discount::find($id);
        if ($validator->passes()) {
            $discount_edit->name = $request->discount_name;
            $discount_edit->type = $request->type;
            $discount_edit->value = $request->discount_amount;
            $discount_edit->product_ids = implode(',', $request->select_product);
            $discount_edit->status = $request->status;
            $discount_edit->start_at = $request->starts_at;
            $discount_edit->expires_at = $request->expires_at;
            $discount_edit->save();
            $message = 'Discount Updated successfully';
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
    public function destroy(Request $request, $id)
    {
        $discount = Discount::find($id);
        if ($discount == null) {
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