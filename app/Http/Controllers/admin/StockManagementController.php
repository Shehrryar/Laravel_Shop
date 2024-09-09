<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class StockManagementController extends Controller
{
    public function index(Request $request)
    {
        $stock = Stock::latest()->with('product');
        if(!empty($request->get('keyword'))){
            $stock = $stock->where('product_id','like','%'.$request->get('keyword').'%');
        }
        $stock = $stock->paginate(10);
        return view('admin.stocks.list', compact('stock'));
    }
    public function create()
    {
        $data = [];
        $products = Product::get();
        $data['products']=$products;
        return view('admin.stocks.create', $data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quantity'=>'required',
            'select_product' => 'required|array',
            'status' => 'required',
        ]);

        if ($validator->passes()) {
            $stock = new Stock();
            $stock->quantity = $request->quantity;
            $stock->product_id = implode(',' , $request->select_product);
            $stock->status = $request->status;
            $stock->remaning_quantity = $request->remaning_quantity;
            $stock->sold_quantity = $request->sold_quantity;
            $stock->save();

            $message = 'Stock added successfully';
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

        $stock_edit = Stock::find($id);    
        if ($stock_edit == null) {
            session()->flash('error', 'Record not found');
            return redirect()->route('coupon.index');
        }
        $products = Product::all();
        $data = [
            'stock_edit' => $stock_edit,
            'products' => $products
        ];
        return view('admin.stocks.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity'=>'required',
            'select_product' => 'required|array',
            'status' => 'required',
        ]);

        if ($validator->passes()) {
            $stock_update = Stock::find($id);
            $stock_update->quantity = $request->quantity;
            $stock_update->product_id = implode(',' , $request->select_product);
            $stock_update->status = $request->status;
            $stock_update->remaning_quantity = $request->remaning_quantity;
            $stock_update->sold_quantity = $request->sold_quantity;
            $stock_update->save();

            $message = 'Stock updated successfully';
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
        $stock = Stock::find($id);
        if($stock == null){
            session()->flash('error', 'Record not found');
            return response()->json([
                'status' => true,
                'message' => 'Record not found'
            ]);
        }
        $stock->delete();
        return response()->json([
            'status' => true,
            'message' => 'Record deleted successfully'
        ]);

    }
}
