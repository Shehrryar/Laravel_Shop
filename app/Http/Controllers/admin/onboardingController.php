<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Onboarding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class onboardingController extends Controller
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

    private function assignStoreId(Onboarding $onboarding): void
    {
        if ($this->isVendor()) {
            $onboarding->store_id = $this->vendorStoreId();
        }
    }

    private function ensureOwnOnboarding(Onboarding $onboarding): void
    {
        if (!$this->isVendor()) {
            return;
        }

        if ((int) $onboarding->store_id !== (int) $this->vendorStoreId()) {
            abort(403, 'You cannot manage another vendor onboarding.');
        }
    }

    public function index(Request $request)
    {
        $this->ensureVendorHasStore();

        $onboarding = Onboarding::latest('id');

        if ($this->isVendor()) {
            $onboarding->where('store_id', $this->vendorStoreId());
        }

        if (!empty($request->get('keyword'))) {
            $keyword = $request->get('keyword');

            $onboarding->where(function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%')
                    ->orWhere('subtitle', 'like', '%' . $keyword . '%');
            });
        }

        $onboarding = $onboarding->paginate(10);

        return view('admin.onboarding.list', compact('onboarding'));
    }

    public function create()
    {
        $this->ensureVendorHasStore();

        return view('admin.onboarding.create');
    }

    public function store(Request $request)
    {
        $this->ensureVendorHasStore();

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        if ($validator->passes()) {
            $onboarding = new Onboarding();

            $this->assignStoreId($onboarding);

            $onboarding->title = $request->title;
            $onboarding->subtitle = $request->subtitle;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());

                $destinationPath = public_path('upload/onboarding/');

                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                $image->move($destinationPath, $imageName);

                $onboarding->image = $imageName;
            }

            $onboarding->save();

            session()->flash('success', 'Onboarding added successfully');

            return response()->json([
                'status' => true,
                'message' => 'Onboarding added successfully',
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

        $onboard_edit = Onboarding::find($id);

        if (empty($onboard_edit)) {
            $request->session()->flash('error', 'Onboarding not found');

            return redirect()->route('onboarding.index');
        }

        $this->ensureOwnOnboarding($onboard_edit);

        return view('admin.onboarding.edit', compact('onboard_edit'));
    }

    public function update($id, Request $request)
    {
        $this->ensureVendorHasStore();

        $onboard_edit = Onboarding::find($id);

        if (empty($onboard_edit)) {
            return response()->json([
                'status' => false,
                'notfound' => true,
                'message' => 'Onboarding not found',
            ]);
        }

        $this->ensureOwnOnboarding($onboard_edit);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        if ($validator->passes()) {
            $onboard_edit->title = $request->title;
            $onboard_edit->subtitle = $request->subtitle;

            $oldimage = $onboard_edit->image;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());

                $destinationPath = public_path('upload/onboarding/');

                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                $image->move($destinationPath, $imageName);

                $onboard_edit->image = $imageName;

                if (!empty($oldimage)) {
                    $oldImagePath = public_path('upload/onboarding/' . $oldimage);

                    if (File::exists($oldImagePath)) {
                        File::delete($oldImagePath);
                    }
                }
            }

            $onboard_edit->save();

            session()->flash('success', 'Onboarding updated successfully');

            return response()->json([
                'status' => true,
                'message' => 'Onboarding updated successfully',
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

        $onboarding = Onboarding::find($id);

        if (empty($onboarding)) {
            $request->session()->flash('error', 'Onboarding not found');

            return response()->json([
                'status' => false,
                'message' => 'Onboarding not found',
            ]);
        }

        $this->ensureOwnOnboarding($onboarding);

        if (!empty($onboarding->image)) {
            $imagePath = public_path('upload/onboarding/' . $onboarding->image);

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $onboarding->delete();

        $request->session()->flash('success', 'Onboarding deleted successfully');

        return response()->json([
            'status' => true,
            'message' => 'Onboarding deleted successfully',
        ]);
    }
}