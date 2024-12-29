<?php

namespace App\Http\Controllers\API\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index(){
        return response()->json([
            'success' => true,
            'message' => 'Admin Dashboard',
        ]);
    }

    public function logout(){
            $admin = Auth::guard('admin')->logout();
             return redirect()->route('admin.login');

    }
}
