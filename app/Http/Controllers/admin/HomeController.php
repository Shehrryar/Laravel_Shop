<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\User;


class HomeController extends Controller
{
    public function dashborad(){
        $data = [];
        $user_count = User::count();
        $order_count = Order::count();

        $data['order_count'] = $order_count;
        $data['user_count'] = $user_count;
        return view('admin.dashboard.list', $data);
    }

    public function logout(){
            $admin = Auth::guard('admin')->logout();
             return redirect()->route('admin.login');

    }
}
