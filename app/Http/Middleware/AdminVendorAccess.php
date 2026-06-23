<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminVendorAccess
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('admin')->user() ?? Auth::user();

        if (!$user) {
            return redirect('/admin/login');
        }

        // Main Admin can access admin panel
        if ((int) $user->role === 2) {
            return $next($request);
        }

        // Vendor can access admin panel only if connected with store
        if ((int) $user->role === 3 && !empty($user->store_id)) {
            return $next($request);
        }

        Auth::guard('admin')->logout();

        return redirect('/admin/login')
            ->with('error', 'You are not authorized to access admin panel.');
    }
}