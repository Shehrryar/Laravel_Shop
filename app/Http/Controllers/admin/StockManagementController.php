<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Size;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\admin\Traits\VendorStoreScope;

class StockManagementController extends Controller
{
    use VendorStoreScope;
    public function index(Request $request)
    {
        $stock = Stock::latest()->with('product');
        $stock = $this->applyStoreScope($stock);
        if(!empty($request->get('keyword'))){
            $stock = $stock->where('product_id','like','%'.$request->get('keyword').'%');
        }
        $stock = $stock->paginate(10);
        $colors = Color::orderBy('name', 'ASC')->get();
        $sizes = Size::orderBy('name', 'ASC')->get();
        $data['colors'] = $colors;
        $data['sizes'] = $sizes;
        $data['stock'] = $stock;
        return view('admin.stocks.list', $data);
    }
    public function create()
    {
        $data = [];
        $colors = Color::orderBy('name', 'ASC')->get();
        $sizes = Size::orderBy('name', 'ASC')->get();
        $products = Product::orderBy('title', 'ASC')->get();
        $data['products']=$products;
        $data['colors'] = $colors;
        $data['sizes'] = $sizes;
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
            $stock->color_id = $request->color_id;
            $stock->size_id = $request->size_id;
            // $stock->remaning_quantity = $request->remaning_quantity;
            // $stock->sold_quantity = $request->sold_quantity;
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
        $this->ensureOwnStoreRecord($stock_edit);
        $products = Product::orderBy('title', 'ASC')->get();
        $colors = Color::orderBy('name', 'ASC')->get();
        $sizes = Size::orderBy('name', 'ASC')->get();
        $data = [
            'stock_edit' => $stock_edit,
            'products' => $products,
            'colors' => $colors,
            'sizes' => $sizes
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
            $this->ensureOwnStoreRecord($stock_update);
            $stock_update->quantity = $request->quantity;
            $stock_update->product_id = implode(',' , $request->select_product);
            $stock_update->color_id = $request->color_id;
            $stock_update->size_id = $request->size_id;
            $stock_update->status = $request->status;
            // $stock_update->remaning_quantity = $request->remaning_quantity;
            // $stock_update->sold_quantity = $request->sold_quantity;
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
        $this->ensureOwnStoreRecord($stock);
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
