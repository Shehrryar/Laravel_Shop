<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class promotionController extends Controller
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

    private function isMainAdmin(): bool
    {
        $admin = $this->adminUser();

        return $admin && (int) $admin->role === 2;
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

    private function ensureOwnPromotion(Promotion $promotion): void
    {
        if (!$this->isVendor()) {
            return;
        }

        if ((int) $promotion->store_id !== (int) $this->vendorStoreId()) {
            abort(403, 'You cannot manage another vendor promotion.');
        }
    }

    private function assignStoreId(Promotion $promotion): void
    {
        if ($this->isVendor()) {
            $promotion->store_id = $this->vendorStoreId();
        }
    }

    private function firebaseTopic(): string
    {
        /*
        |--------------------------------------------------------------------------
        | Important
        |--------------------------------------------------------------------------
        | Main admin promotion can go to global topic.
        | Vendor promotion should go to store-specific topic.
        |
        | For vendor notification to work properly, your front/mobile app must
        | subscribe users to this same topic: store_1, store_2, etc.
        */
        if ($this->isVendor()) {
            return 'store_' . $this->vendorStoreId();
        }

        return 'global';
    }

    private function sendPromotionNotification(string $description): void
    {
        /*
        |--------------------------------------------------------------------------
        | Safe Firebase Send
        |--------------------------------------------------------------------------
        | If Firebase file is missing or Firebase fails, promotion still saves.
        */
        $firebasePath = base_path('config/firebase_credentials.json');

        if (!file_exists($firebasePath)) {
            return;
        }

        try {
            $firebase = (new Factory)->withServiceAccount($firebasePath);
            $messaging = $firebase->createMessaging();

            $message = CloudMessage::fromArray([
                'notification' => [
                    'title' => $this->isVendor() ? 'Store Promotion' : 'New Promotion',
                    'body' => $description,
                ],
                'topic' => $this->firebaseTopic(),
            ]);

            $messaging->send($message);
        } catch (\Throwable $e) {
            // Do not break promotion saving if notification fails.
        }
    }

    public function index(Request $request)
    {
        $this->ensureVendorHasStore();

        $promotions = Promotion::latest('id');

        /*
        |--------------------------------------------------------------------------
        | Vendor Filter
        |--------------------------------------------------------------------------
        | Vendor can see only own store promotions.
        */
        if ($this->isVendor()) {
            $promotions->where('store_id', $this->vendorStoreId());
        }

        if (!empty($request->get('keyword'))) {
            $promotions->where('description', 'like', '%' . $request->get('keyword') . '%');
        }

        $promotions = $promotions->paginate(10);

        return view('admin.promotions.list', compact('promotions'));
    }

    public function create()
    {
        $this->ensureVendorHasStore();

        return view('admin.promotions.create');
    }

    public function store(Request $request)
    {
        $this->ensureVendorHasStore();

        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255',
        ]);

        if ($validator->passes()) {
            $promotion = new Promotion();

            $this->assignStoreId($promotion);

            $promotion->description = $request->description;
            $promotion->save();

            $this->sendPromotionNotification($request->description);

            session()->flash('success', 'Promotion added successfully');

            return response()->json([
                'status' => true,
                'message' => 'Promotion added successfully',
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

        $promotion = Promotion::find($id);

        if (empty($promotion)) {
            $request->session()->flash('error', 'Promotion not found');

            return redirect()->route('promotion.index');
        }

        /*
        |--------------------------------------------------------------------------
        | Vendor Protection
        |--------------------------------------------------------------------------
        | Vendor cannot edit another vendor promotion.
        */
        $this->ensureOwnPromotion($promotion);

        return view('admin.promotions.edit', compact('promotion'));
    }

    public function update(Request $request, $id)
    {
        $this->ensureVendorHasStore();

        $promotion = Promotion::find($id);

        if (empty($promotion)) {
            return response()->json([
                'status' => false,
                'notfound' => true,
                'message' => 'Promotion not found',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Vendor Protection
        |--------------------------------------------------------------------------
        | Vendor cannot update another vendor promotion.
        */
        $this->ensureOwnPromotion($promotion);

        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255',
        ]);

        if ($validator->passes()) {
            $promotion->description = $request->description;
            $promotion->save();

            $this->sendPromotionNotification($request->description);

            session()->flash('success', 'Promotion updated successfully');

            return response()->json([
                'status' => true,
                'message' => 'Promotion updated successfully',
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

        $promotion = Promotion::find($id);

        if (empty($promotion)) {
            $request->session()->flash('error', 'Promotion not found');

            return response()->json([
                'status' => false,
                'message' => 'Promotion not found',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Vendor Protection
        |--------------------------------------------------------------------------
        | Vendor cannot delete another vendor promotion.
        */
        $this->ensureOwnPromotion($promotion);

        $promotion->delete();

        $request->session()->flash('success', 'Promotion deleted successfully');

        return response()->json([
            'status' => true,
            'message' => 'Promotion deleted successfully',
        ]);
    }
}