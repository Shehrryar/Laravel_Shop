<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VendorPermissionController extends Controller
{
    private function availablePermissions()
    {
        return [
            'dashboard' => 'Dashboard',
            'category' => 'Category',
            'sub_category_level_2' => 'Sub Category Level 2',
            'sub_category_level_3' => 'Sub Category Level 3',
            'brands' => 'Brands',
            'products' => 'Products',
            'colors' => 'Color',
            'themes' => 'Theme',
            'sizes' => 'Size',
            'stock' => 'Stock Management',
            'shipping' => 'Shipping',
            'orders' => 'Orders',
            'discount' => 'Discount',
            'users' => 'Users',
            'currencies' => 'Currencies',
            'language' => 'Language',
            'promotions' => 'Promotions',
            'chat' => 'Chat',
            'sockets_chat' => 'Sockets Chat',
            'web_services' => 'Web Services',
            'onboarding' => 'Onboarding',
            'homepage_labels' => 'Homepage Label',
        ];
    }

    public function index()
    {
        $vendors = User::with('store')
            ->where('role', 3)
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.vendorpermissions.index', compact('vendors'));
    }

    public function edit($id)
    {
        $vendor = User::with('store')
            ->where('role', 3)
            ->findOrFail($id);

        $availablePermissions = $this->availablePermissions();

        return view('admin.vendorpermissions.edit', compact('vendor', 'availablePermissions'));
    }

    public function update(Request $request, $id)
    {
        $vendor = User::where('role', 3)->findOrFail($id);

        $availablePermissions = $this->availablePermissions();

        $permissions = [];

        foreach ($availablePermissions as $key => $label) {
            $permissions[$key] = $request->has("permissions.$key");
        }

        // Dashboard should always be allowed for vendor
        $permissions['dashboard'] = true;

        $vendor->permissions = $permissions;
        $vendor->save();

        return redirect()
            ->route('vendor.permissions.index')
            ->with('success', 'Vendor permissions updated successfully.');
    }
}