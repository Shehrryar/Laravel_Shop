<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function index(Request $request){
        $orders = Order::latest('orders.created_at')->select('orders.*','users.name','users.email')
        ->leftJoin('users', 'users.id', '=', 'orders.user_id');
        if ($request->get('keyword') != "") {
            $orders = $orders->where(function ($query) use ($request) {
                $query->where('users.name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('users.email', 'like', '%' . $request->keyword . '%')
                    ->orWhere('users.id', 'like', '%' . $request->keyword . '%');
            });
        }
        $orders = $orders->paginate(10);
        return view('admin.orders.list', compact('orders'));
    
    }
    public function detail($orderid){
        $order = Order::select('orders.*', 'countries.name as countryName')
        ->where('orders.id', $orderid)
        ->leftJoin('countries', 'countries.id','orders.country_id')
        ->first();

        $orderitems = OrderItem::where('order_id', $orderid)->get();
        return view('admin.orders.detail', 
        ['order'=>$order, 'orderitems'=> $orderitems]);
    }
}