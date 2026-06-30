<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
{
    public function index(Request $request)
    {
        $language = Language::latest('id');

        if (!empty($request->get('keyword'))) {
            $language = $language->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->get('keyword') . '%')
                    ->orWhere('slug', 'like', '%' . $request->get('keyword') . '%')
                    ->orWhere('Isocode', 'like', '%' . $request->get('keyword') . '%');
            });
        }

        $language = $language->paginate(10);

        return view('admin.languages.list', compact('language'));
    }

    public function create()
    {
        $this->ensureMainAdmin();
        return view('admin.languages.create');
    }

    public function store(Request $request)
    {
        $this->ensureMainAdmin();
        $request->merge([
            'slug' => $request->slug ?: Str::slug($request->name),
            'status' => $request->status ?? 1,
        ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:languages,slug',
            'isocode' => 'required',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->passes()) {
            $language = new Language();
            $language->name = $request->name;
            $language->slug = $request->slug;
            $language->Isocode = $request->isocode;
            $language->status = $request->status;
            $language->save();

            session()->flash('success', 'Language added successfully');

            return response()->json([
                'status' => true,
                'message' => 'Language added successfully',
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }

    public function edit($id, Request $request)
    {
        $this->ensureMainAdmin();
        $language = Language::find($id);

        if (empty($language)) {
            $request->session()->flash('error', 'Record not found');

            return redirect()->route('language.index');
        }

        return view('admin.languages.edit', compact('language'));
    }

    public function update($id, Request $request)
    {
        $this->ensureMainAdmin();
        $language = Language::find($id);

        if (empty($language)) {
            session()->flash('error', 'Record not found');

            return response()->json([
                'status' => false,
                'notfound' => true,
            ]);
        }

        $request->merge([
            'slug' => $request->slug ?: Str::slug($request->name),
            'status' => $request->status ?? 1,
        ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:languages,slug,' . $language->id . ',id',
            'isocode' => 'required',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->passes()) {
            $language->name = $request->name;
            $language->slug = $request->slug;
            $language->Isocode = $request->isocode;
            $language->status = $request->status;
            $language->save();

            session()->flash('success', 'Language updated successfully');

            return response()->json([
                'status' => true,
                'message' => 'Language updated successfully',
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }

    public function destroy($id, Request $request)
    {
        $this->ensureMainAdmin();
        $language = Language::find($id);

        if (empty($language)) {
            $request->session()->flash('error', 'Language not found');

            return response()->json([
                'status' => false,
                'message' => 'Language not found',
            ]);
        }

        $language->delete();

        $request->session()->flash('success', 'Language deleted successfully');

        return response()->json([
            'status' => true,
            'message' => 'Language deleted successfully',
        ]);
    }
    private function ensureMainAdmin(): void
    {
        $user = Auth::guard('admin')->user();

        if (!$user || (int) $user->role !== 2) {
            abort(403, 'Only main admin can manage languages.');
        }
    }
}