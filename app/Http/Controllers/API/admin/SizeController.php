<?php
namespace App\Http\Controllers\API\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Size;
use App\Models\Product;
class SizeController extends Controller
{
    public function index(Request $request)
    {
        $size = Size::latest('id');
        if (!empty($request->get('keyword'))) {
            $size = $size->where('name', 'like', '%' . $request->get('keyword') . '%');
        }
        $sizes = $size->paginate(10);
        $products = Product::orderBy('title', 'ASC')->get();
        $totalPages = $sizes->lastPage(); // Total number of pages
        $currentPage = $sizes->currentPage(); // Current page number
        $sizesData = $sizes->items(); // Extract sizes as an array
        $newsizes['current_page'] = $currentPage;
        $newsizes['totalPages'] = $totalPages;
        $newsizes['sizesData'] = $sizesData;
        $newsizes['products'] = $products;
        return response()->json([$newsizes]);
    }
    public function create()
    {
        $products = Product::orderBy('title', 'ASC')->get();
        $data['products'] = $products;
        return view('admin.size.create', $data);
    }
    public function store(Request $request)
    {
        $validater = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'product_id' => 'required',
                'price' => 'required',
                'code' => 'required',
                'status' => 'required',
            ]
        );
        if ($validater->passes()) {
            $size = new Size();
            $size->name = $request->name;
            $size->code = $request->code;
            $size->product_id = $request->product_id;
            $size->price = $request->price;
            $size->status = $request->status;
            $size->save();
            // $request->session()->flash('success', 'Size added sucessfully');
            return response()->json([
                'status' => true,
                'message' => 'Size added sucessfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validater->errors()
            ]);
        }
    }
    public function edit($id, Request $request)
    {
        $size = Size::find($id);
        if (empty($size)) {
            $request->session()->flash('error', 'Record not found');
            return redirect()->route('sizess.index');
        }
        $products = Product::orderBy('title', 'ASC')->get();
        $data['products'] = $products;
        $data['size'] = $size;
        return view('admin.size.edit', $data);
    }
    public function update($id, Request $request)
    {
        $size_edit = Size::find($id);
        if (empty($size_edit)) {
            $request->session()->flash('error', 'Record not found');
            return response()->json([
                'status' => false,
                'notfound' => true
            ]);
        }
        $validater = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'product_id' => 'required',
                'price' => 'required',
                'code' => 'required|unique:size,code,' . $size_edit->id . ',id',
                'status' => 'required',
            ]
        );
        if ($validater->passes()) {
            $size_edit->name = $request->name;
            $size_edit->code = $request->code;
            $size_edit->product_id = $request->product_id;
            $size_edit->price = $request->price;
            $size_edit->status = $request->status;
            $size_edit->save();
            $message = 'Size updated sucessfully';
            // $request->session()->flash('success', $message);
            return response()->json([
                'status' => true,
                'message' => $message
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => $validater->errors()
            ]);
        }
    }
    public function destroy($size_id, Request $request)
    {
        $size_del = Size::find($size_id);
        if (empty($size_del)) {
            // $request->session()->flash("Error", "Size not found");
            return response()->json([
                'status' => true,
                'message' => 'Size not found'
            ]);
        }
        $size_del->delete();
        // $request->session()->flash("success", "Size deleted successfully");
        return response()->json([
            'status' => true,
            'message' => 'Size deleted successfully'
        ]);
    }
}