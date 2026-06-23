<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureMainAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('admin')->user() ?? Auth::user();

        if (!$user) {
            return redirect('/admin/login');
        }

        // Only Main Admin can access this route
        if ((int) $user->role !== 2) {
            abort(403, 'Only main admin can access this page.');
        }

        return $next($request);
    }
}