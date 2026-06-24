<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;




class AdminLoginController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::guard('admin')->user();

            // Allow only main admin and vendor
            if (!in_array((int) $user->role, [2, 3])) {
                Auth::guard('admin')->logout();

                return redirect()
                    ->back()
                    ->with('error', 'You are not authorized to access admin panel.');
            }

            // Vendor must be connected with one store
            if ((int) $user->role === 3 && empty($user->store_id)) {
                Auth::guard('admin')->logout();

                return redirect()
                    ->back()
                    ->with('error', 'Vendor account is not connected with any store.');
            }

            // Check active account
            if (isset($user->status) && (int) $user->status !== 1) {
                Auth::guard('admin')->logout();

                return redirect()
                    ->back()
                    ->with('error', 'Your account is inactive.');
            }

            return redirect()->route('dashboard.index');
        }

        return redirect()
            ->back()
            ->with('error', 'Invalid email or password.');
    }

}