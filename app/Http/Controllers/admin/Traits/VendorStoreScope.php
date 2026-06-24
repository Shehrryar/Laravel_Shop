<?php

namespace App\Http\Controllers\admin\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait VendorStoreScope
{
    protected function adminUser()
    {
        return Auth::guard('admin')->user();
    }

    protected function isMainAdmin(): bool
    {
        $admin = $this->adminUser();

        return $admin && (int) $admin->role === 2;
    }

    protected function isVendor(): bool
    {
        $admin = $this->adminUser();

        return $admin && (int) $admin->role === 3;
    }

    protected function vendorStoreId()
    {
        return $this->adminUser()?->store_id;
    }

    protected function applyStoreScope($query)
    {
        if ($this->isVendor()) {
            return $query->where('store_id', $this->vendorStoreId());
        }

        return $query;
    }

    protected function assignStoreId($model, Request $request = null)
    {
        if ($this->isVendor()) {
            $model->store_id = $this->vendorStoreId();
            return;
        }

        if ($request && $request->has('store_id')) {
            $model->store_id = $request->store_id;
        }
    }

    protected function ensureOwnStoreRecord($model)
    {
        if ($this->isVendor() && (int) $model->store_id !== (int) $this->vendorStoreId()) {
            abort(403, 'You cannot manage another vendor record.');
        }
    }
}