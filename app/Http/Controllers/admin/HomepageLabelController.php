<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomepageLabel;
use Illuminate\Support\Facades\Validator;
class HomepageLabelController extends Controller
{
    public function index(Request $request)
    {
        $labels = HomepageLabel::latest();
        if (!empty($request->get('keyword'))) {
            $labels = $labels->where('label_name', 'like', '%' . $request->get('keyword') . '%');
        }
        $labels = $labels->paginate(perPage: 10);
        return view('admin.homepagelabels.list', compact('labels'));
    }
    // Show create form
    public function create()
    {
        return view('admin.homepagelabels.create');
    }
    // Store new label
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'label_name' => 'required|string|max:255',
            'label_key' => 'required|string|max:255|unique:homepage_labels,label_key',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
        if ($validator->passes()) {
            $label = new HomepageLabel();
            $label->label_name = $request->label_name;
            $label->label_key = $request->label_key;
            $label->sort_order = $request->sort_order ?? 0;
            $label->is_active = $request->has('is_active') ? 1 : 0;
            $label->save();
            return response()->json([
                'status' => true,
                'message' => 'Homepage label added successfully'
            ]);
        }
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }
    // Show edit form
    public function edit($id)
    {
        $label = HomepageLabel::find($id);
        if (!$label) {
            abort(404, 'Label not found');
        }
        return view('admin.homepagelabels.edit', compact('label'));
    }
    // Update label
    public function update($id, Request $request)
    {
        $label = HomepageLabel::find($id);
        if (!$label) {
            return response()->json([
                'status' => false,
                'not_found' => true,
                'message' => 'Label not found'
            ]);
        }
        $validator = Validator::make($request->all(), [
            'label_name' => 'required|string|max:255',
            'label_key' => 'required|string|max:255|unique:homepage_labels,label_key,' . $id,
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
        if ($validator->passes()) {
            $label->label_name = $request->label_name;
            $label->label_key = $request->label_key;
            $label->sort_order = $request->sort_order ?? 0;
            $label->is_active = $request->has('is_active') ? 1 : 0;
            $label->save();
            return response()->json([
                'status' => true,
                'message' => 'Homepage label updated successfully'
            ]);
        }
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }
    // Delete label
    public function destroy($id)
    {
        $label = HomepageLabel::find($id);
        if (!$label) {
            return response()->json([
                'status' => false,
                'message' => 'Label not found'
            ]);
        }
        $label->delete();
        return response()->json([
            'status' => true,
            'message' => 'Homepage label deleted successfully'
        ]);
    }
}