<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageLabel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HomepageLabelController extends Controller
{
    private function adminUser()
    {
        return Auth::guard('admin')->user();
    }

    private function isVendor(): bool
    {
        $admin = $this->adminUser();

        return $admin && (int) $admin->role === 3;
    }

    private function vendorStoreId()
    {
        return $this->adminUser()?->store_id;
    }

    private function ensureVendorHasStore(): void
    {
        if ($this->isVendor() && empty($this->vendorStoreId())) {
            abort(403, 'Vendor account is not connected with any store.');
        }
    }

    private function assignStoreId(HomepageLabel $label): void
    {
        if ($this->isVendor()) {
            $label->store_id = $this->vendorStoreId();
        }
    }

    private function ensureOwnLabel(HomepageLabel $label): void
    {
        if (!$this->isVendor()) {
            return;
        }

        if ((int) $label->store_id !== (int) $this->vendorStoreId()) {
            abort(403, 'You cannot manage another vendor homepage label.');
        }
    }

    private function labelKeyRule($ignoreId = null)
    {
        $rule = Rule::unique('homepage_labels', 'label_key');

        if ($ignoreId) {
            $rule->ignore($ignoreId);
        }

        if ($this->isVendor()) {
            return $rule->where(function ($query) {
                return $query->where('store_id', $this->vendorStoreId());
            });
        }

        return $rule->where(function ($query) {
            return $query->whereNull('store_id');
        });
    }

    public function index(Request $request)
    {
        $this->ensureVendorHasStore();

        $labels = HomepageLabel::latest('id');

        /*
        |--------------------------------------------------------------------------
        | Vendor Filter
        |--------------------------------------------------------------------------
        | Vendor can see only own store homepage labels.
        */
        if ($this->isVendor()) {
            $labels->where('store_id', $this->vendorStoreId());
        }

        if (!empty($request->get('keyword'))) {
            $keyword = $request->get('keyword');

            $labels->where(function ($query) use ($keyword) {
                $query->where('label_name', 'like', '%' . $keyword . '%')
                    ->orWhere('label_key', 'like', '%' . $keyword . '%');
            });
        }

        $labels = $labels->paginate(10);

        return view('admin.homepagelabels.list', compact('labels'));
    }

    public function create()
    {
        $this->ensureVendorHasStore();

        return view('admin.homepagelabels.create');
    }

    public function store(Request $request)
    {
        $this->ensureVendorHasStore();

        $validator = Validator::make($request->all(), [
            'label_name' => 'required|string|max:255',
            'label_key' => [
                'required',
                'string',
                'max:255',
                $this->labelKeyRule(),
            ],
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->passes()) {
            $label = new HomepageLabel();

            $this->assignStoreId($label);

            $label->label_name = $request->label_name;
            $label->label_key = $request->label_key;
            $label->sort_order = $request->sort_order ?? 0;
            $label->is_active = $request->has('is_active') ? 1 : 0;
            $label->save();

            session()->flash('success', 'Homepage label added successfully');

            return response()->json([
                'status' => true,
                'message' => 'Homepage label added successfully',
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }

    public function edit($id, Request $request)
    {
        $this->ensureVendorHasStore();

        $label = HomepageLabel::find($id);

        if (!$label) {
            $request->session()->flash('error', 'Homepage label not found');

            return redirect()->route('homepage-labels.index');
        }

        /*
        |--------------------------------------------------------------------------
        | Vendor Protection
        |--------------------------------------------------------------------------
        | Vendor cannot edit another vendor homepage label.
        */
        $this->ensureOwnLabel($label);

        return view('admin.homepagelabels.edit', compact('label'));
    }

    public function update($id, Request $request)
    {
        $this->ensureVendorHasStore();

        $label = HomepageLabel::find($id);

        if (!$label) {
            return response()->json([
                'status' => false,
                'notfound' => true,
                'message' => 'Homepage label not found',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Vendor Protection
        |--------------------------------------------------------------------------
        | Vendor cannot update another vendor homepage label.
        */
        $this->ensureOwnLabel($label);

        $validator = Validator::make($request->all(), [
            'label_name' => 'required|string|max:255',
            'label_key' => [
                'required',
                'string',
                'max:255',
                $this->labelKeyRule($label->id),
            ],
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->passes()) {
            $label->label_name = $request->label_name;
            $label->label_key = $request->label_key;
            $label->sort_order = $request->sort_order ?? 0;
            $label->is_active = $request->has('is_active') ? 1 : 0;
            $label->save();

            session()->flash('success', 'Homepage label updated successfully');

            return response()->json([
                'status' => true,
                'message' => 'Homepage label updated successfully',
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }

    public function destroy($id, Request $request)
    {
        $this->ensureVendorHasStore();

        $label = HomepageLabel::find($id);

        if (!$label) {
            $request->session()->flash('error', 'Homepage label not found');

            return response()->json([
                'status' => false,
                'message' => 'Homepage label not found',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Vendor Protection
        |--------------------------------------------------------------------------
        | Vendor cannot delete another vendor homepage label.
        */
        $this->ensureOwnLabel($label);

        $label->delete();

        $request->session()->flash('success', 'Homepage label deleted successfully');

        return response()->json([
            'status' => true,
            'message' => 'Homepage label deleted successfully',
        ]);
    }
}