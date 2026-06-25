<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private function adminUser()
    {
        return Auth::guard('admin')->user();
    }

    private function isMainAdmin(): bool
    {
        $admin = $this->adminUser();

        return $admin && (int) $admin->role === 2;
    }

    private function isVendor(): bool
    {
        $admin = $this->adminUser();

        return $admin && (int) $admin->role === 3;
    }

    private function vendorCustomerIds()
    {
        $admin = $this->adminUser();

        if (!$admin || (int) $admin->role !== 3) {
            return collect();
        }

        return DB::table('orders')
            ->join('orders_items', 'orders.id', '=', 'orders_items.order_id')
            ->join('products', 'orders_items.product_id', '=', 'products.id')
            ->where('products.store_id', $admin->store_id)
            ->whereNotNull('orders.user_id')
            ->distinct()
            ->pluck('orders.user_id');
    }

    public function index(Request $request)
    {
        $admin = $this->adminUser();

        /*
        |--------------------------------------------------------------------------
        | Super Admin
        |--------------------------------------------------------------------------
        | Super admin can see all normal customers.
        */
        if ($this->isMainAdmin()) {
            $users = User::where('role', 1)->latest();

            if (!empty($request->get('keyword'))) {
                $users = $users->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->get('keyword') . '%')
                        ->orWhere('email', 'like', '%' . $request->get('keyword') . '%')
                        ->orWhere('phone', 'like', '%' . $request->get('keyword') . '%');
                });
            }

            $users = $users->paginate(10);

            return view('admin.users.list', compact('users'));
        }

        /*
        |--------------------------------------------------------------------------
        | Vendor
        |--------------------------------------------------------------------------
        | Vendor can see only customers who ordered products from this vendor store.
        */
        if ($this->isVendor()) {
            if (empty($admin->store_id)) {
                abort(403, 'Vendor account is not connected with any store.');
            }

            $customerIds = $this->vendorCustomerIds();

            $users = User::whereIn('id', $customerIds)
                ->where('role', 1)
                ->latest();

            if (!empty($request->get('keyword'))) {
                $users = $users->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->get('keyword') . '%')
                        ->orWhere('email', 'like', '%' . $request->get('keyword') . '%')
                        ->orWhere('phone', 'like', '%' . $request->get('keyword') . '%');
                });
            }

            $users = $users->paginate(10);

            return view('admin.users.list', compact('users'));
        }

        abort(403, 'Unauthorized access.');
    }

    public function create(Request $request)
    {
        if (!$this->isMainAdmin()) {
            abort(403, 'Only super admin can create users.');
        }

        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        if (!$this->isMainAdmin()) {
            abort(403, 'Only super admin can create users.');
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required',
                'password' => 'required|min:6',
            ]
        );

        if ($validator->passes()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->status = $request->status ?? 1;
            $user->role = 1;
            $user->save();

            $message = "User is added successfully";
            session()->flash('success', $message);

            return response()->json([
                'status' => true,
                'message' => $message,
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }

    public function edit($userid, Request $request)
    {
        if (!$this->isMainAdmin()) {
            abort(403, 'Only super admin can edit users.');
        }

        $user_edit = User::where('role', 1)->findOrFail($userid);

        return view('admin.users.edit', compact('user_edit'));
    }

    public function update(Request $request, $user_id)
    {
        if (!$this->isMainAdmin()) {
            abort(403, 'Only super admin can update users.');
        }

        $user_edit = User::where('role', 1)->find($user_id);

        if (empty($user_edit)) {
            return response()->json([
                'status' => false,
                'not_found' => true,
                'message' => 'User not found',
            ]);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $user_edit->id . ',id',
                'phone' => 'required',
                'password' => 'nullable|min:6',
            ]
        );

        if ($validator->passes()) {
            $user_edit->name = $request->name;
            $user_edit->email = $request->email;
            $user_edit->phone = $request->phone;

            if (!empty($request->password)) {
                $user_edit->password = Hash::make($request->password);
            }

            $user_edit->status = $request->status ?? 1;
            $user_edit->role = 1;
            $user_edit->save();

            $message = "User is updated successfully";
            session()->flash('success', $message);

            return response()->json([
                'status' => true,
                'message' => $message,
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }

    public function destroy($user_id, Request $request)
    {
        if (!$this->isMainAdmin()) {
            abort(403, 'Only super admin can delete users.');
        }

        $user_del = User::where('role', 1)->find($user_id);

        if (empty($user_del)) {
            session()->flash("error", "User not found");

            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ]);
        }

        $user_del->delete();

        session()->flash("success", "User deleted successfully");

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully',
        ]);
    }
}