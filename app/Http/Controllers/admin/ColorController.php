<?php
namespace App\Http\Controllers\admin;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\Size;
use App\Models\Product;
class ColorController extends Controller
{
    public function index(Request $request)
    {
        $colors = Color::latest('id');
        if (!empty($request->get('keyword'))) {
            $colors = $colors->where('name', 'like', '%' . $request->get('keyword') . '%');
        }
        $products = Product::orderBy('title', 'ASC')->get();
        $colors = $colors->paginate(10);
        $Size = Size::orderBy('name', 'ASC')->get();
        $data['products'] = $products;
        $data['colors'] = $colors;
        $data['Size'] = $Size;
        return view('admin.colors.list', $data);
    }
    public function create()
    {
        $products = Product::orderBy('title', 'ASC')->get();
        $Size = Size::orderBy('name', 'ASC')->get();
        $data['products'] = $products;
        $data['Size'] = $Size;
        return view('admin.colors.create', $data);
    }
    public function store(Request $request)
    {
        $validater = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                // 'product_id' => 'required',
                'price' => 'required',
                'status' => 'required',
            ]
        );
        if ($validater->passes()) {
            $colors = Color::latest('id')->get();
            foreach ($colors as $c) {
                if ($c->value == $request->value && $c->product_id == $request->product_id) {
                    return response()->json([
                        'status' => false,
                        'exist' => true,
                        'message' => 'Color value already exists'
                    ]);
                }
            }
            $colors = new Color();
            $colors->name = $request->name;
            $colors->value = $request->value;
            $colors->product_id = $request->product_id;
            $colors->size_id = $request->size_id;
            $colors->price = $request->price;
            $colors->status = $request->status;
            $colors->save();
            $request->session()->flash('success', 'Color added sucessfully');
            return response()->json([
                'status' => true,
                'message' => 'Color added sucessfully'
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
        $products = Product::orderBy('title', 'ASC')->get();
        $Size = Size::orderBy('name', 'ASC')->get();
        $color = Color::find($id);
        if (empty($color)) {
            $request->session()->flash('error', 'Record not found');
            return redirect()->route('colorss.index');
        }
        $data['color'] = $color;
        $data['Size'] = $Size;
        $data['products'] = $products;
        return view('admin.colors.edit', $data);
    }
    public function update($id, Request $request)
    {
        $color_edit = Color::find($id);
        if (empty($color_edit)) {
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
                // 'product_id' => 'required',
                'price' => 'required',
                // 'value' => 'required|unique:color,value,' . $color_edit->id . ',id',
                'status' => 'required',
            ]
        );
        if ($validater->passes()) {
            $colors = Color::latest('id')->get();
            foreach ($colors as $c) {
                if ($c->value == $request->value && $c->product_id == $request->product_id) {
                    return response()->json([
                        'status' => false,
                        'exist' => true,
                        'message' => 'Color value already exists'
                    ]);
                }
            }
            $color_edit->name = $request->name;
            $color_edit->value = $request->value;
            $color_edit->status = $request->status;
            $color_edit->size_id = $request->size_id;
            // $color_edit->product_id = $request->product_id;
            $color_edit->price = $request->price;
            $color_edit->save();
            $message = 'Color updated sucessfully';
            $request->session()->flash('success', $message);
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
    public function destroy($color_id, Request $request)
    {
        $color_del = Color::find($color_id);
        if (empty($color_del)) {
            $request->session()->flash("Error", "Color not found");
            return response()->json([
                'status' => true,
                'message' => 'Color not found'
            ]);
        }
        $color_del->delete();
        $request->session()->flash("success", "Color deleted successfully");
        return response()->json([
            'status' => true,
            'message' => 'Color deleted successfully'
        ]);
    }
}