<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureVendorPermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        $user = Auth::guard('admin')->user() ?? Auth::user();

        if (!$user) {
            return redirect('/admin/login');
        }

        // Main admin can access everything
        if ((int) $user->role === 2) {
            return $next($request);
        }
        // Vendor permission checking
        if ((int) $user->role === 3) {
            $permissions = $user->permissions ?? [];

            if (!empty($permissions[$permission])) {
                return $next($request);
            }

            abort(403, 'You do not have permission to access this section.');
        }

        abort(403, 'Unauthorized access.');
    }
}