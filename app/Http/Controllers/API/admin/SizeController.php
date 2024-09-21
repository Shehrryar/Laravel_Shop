<?php
namespace App\Http\Controllers\API\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Size;
class SizeController extends Controller
{
    public function index(Request $request)
    {
        $size = Size::latest('id');
        if (!empty($request->get('keyword'))) {
            $size = $size->where('name', 'like', '%' . $request->get('keyword') . '%');
        }
        $sizes = $size->paginate(10);
        return response()->json([
            'sizes' => $sizes,
        ]);
    }
    public function create()
    {
        return view('admin.size.create');
    }
    public function store(Request $request)
    {
        $validater = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'code' => 'required|unique:size',
                'status' => 'required',
            ]
        );
        if ($validater->passes()) {
            $size = new Size();
            $size->name = $request->name;
            $size->code = $request->code;
            $size->status = $request->status;
            $size->save();
            $request->session()->flash('success', 'Size added sucessfully');
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
        $data['size'] = $size;
        return response()->json([
            'data' => $data,
        ]);
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
                'code' => 'required|unique:size,code,' . $size_edit->id . ',id',
                'status' => 'required',
            ]
        );
        if ($validater->passes()) {
            $size_edit->name = $request->name;
            $size_edit->code = $request->code;
            $size_edit->status = $request->status;
            $size_edit->save();
            $message = 'Size updated sucessfully';
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
    public function destroy($size_id, Request $request)
    {
        $size_del = Size::find($size_id);
        if (empty($size_del)) {
            $request->session()->flash("Error", "Size not found");
            return response()->json([
                'status' => true,
                'message' => 'Size not found'
            ]);
        }
        $size_del->delete();
        $request->session()->flash("success", "Size deleted successfully");
        return response()->json([
            'status' => true,
            'message' => 'Size deleted successfully'
        ]);
    }
}
