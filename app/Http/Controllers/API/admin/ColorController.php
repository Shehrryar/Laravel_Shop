<?php
namespace App\Http\Controllers\API\admin;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;
class ColorController extends Controller
{
    public function index(Request $request)
    {
        $colors = Color::latest('id');
        if (!empty($request->get('keyword'))) {
            $colors = $colors->where('name', 'like', '%' . $request->get('keyword') . '%');
        }
        $colors = $colors->paginate(10);
        return response()->json([
            'colors' => $colors,
        ]);
    }
    public function create()
    {
        return view('admin.colors.create');
    }
    public function store(Request $request)
    {
        $validater = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'value' => 'required|unique:color',
                'status' => 'required',
            ]
        );
        if ($validater->passes()) {
            $colors = new Color();
            $colors->name = $request->name;
            $colors->value = $request->value;
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
        $color = Color::find($id);
        if (empty($color)) {
            $request->session()->flash('error', 'Record not found');
            return redirect()->route('colorss.index');
        }
        $data['color'] = $color;
        return response()->json([
            'data' => $data,
        ]);
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
                'value' => 'required|unique:color,value,' . $color_edit->id . ',id',
                'status' => 'required',
            ]
        );
        if ($validater->passes()) {
            $color_edit->name = $request->name;
            $color_edit->value = $request->value;
            $color_edit->status = $request->status;
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