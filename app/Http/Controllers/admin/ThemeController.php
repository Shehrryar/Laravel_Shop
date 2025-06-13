<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Theme;
class ThemeController extends Controller
{
    public function index(Request $request)
    {
        $themes = Theme::latest('id');
        if (!empty($request->get('keyword'))) {
            $themes = $themes->where('name', 'like', '%' . $request->get('keyword') . '%');
        }
        $themes = $themes->paginate(10);
        $data['themes'] = $themes;
        return view('admin.themes.list', $data);
    }
    public function create()
    {
        return view('admin.themes.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'theme_name' => 'required',
            'theme_color_code' => 'required',
            'theme_status' => 'required',
            'theme_isset_status' => 'required',
        ]);
        $theme = new Theme();
        $theme->theme_name = $request->theme_name;
        $theme->theme_color_code = $request->theme_color_code;
        $theme->theme_status = $request->theme_status;
        $theme->theme_isset_status = $request->theme_isset_status;
        $theme->save();
        $request->session()->flash('success', 'Theme added successfully');
        return response()->json([
            'status' => true,
            'message' => 'Theme added successfully'
        ]);
    }
    public function edit($id)
    {
        $theme = Theme::findOrFail($id);
        return view('admin.themes.edit', compact('theme'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'theme_name' => 'required',
            'theme_color_code' => 'required',
            'theme_status' => 'required',
            'theme_isset_status' => 'required',
        ]);
        $theme = Theme::findOrFail($id);
        $theme->theme_name = $request->theme_name;
        $theme->theme_color_code = $request->theme_color_code;
        $theme->theme_status = $request->theme_status;
        $theme->theme_isset_status = $request->theme_isset_status;
        $theme->save();
        $request->session()->flash('success', 'Theme updated successfully');
        return response()->json([
            'status' => true,
            'message' => 'Theme updated successfully'
        ]);
    }
    public function destroy($id)
    {
        $theme = Theme::findOrFail($id);
        $theme->delete();
        session()->flash('success', 'Theme deleted successfully');
        return response()->json([
            'status' => true,
            'message' => 'Theme deleted successfully'
        ]);
    }
}