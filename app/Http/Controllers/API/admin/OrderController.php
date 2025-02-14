<?php

namespace App\Http\Controllers\API\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::latest('orders.created_at')->select('orders.*', 'users.name', 'users.email')
            ->leftJoin('users', 'users.id', '=', 'orders.user_id');
        if ($request->get('keyword') != "") {
            $orders = $orders->where(function ($query) use ($request) {
                $query->where('users.name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('users.email', 'like', '%' . $request->keyword . '%')
                    ->orWhere('users.id', 'like', '%' . $request->keyword . '%');
            });
        }
        $orders = $orders->paginate(10);
        $totalPages = $orders->lastPage(); // Total number of pages
        $currentPage = $orders->currentPage(); // Current page number
        $ordersData = $orders->items(); // Extract orders as an array
        $neworders['current_page'] = $currentPage;
        $neworders['totalPages'] = $totalPages;
        $neworders['ordersData'] = $ordersData;
        return response()->json([$neworders]);
    }
    public function detail($orderid)
    {
        $order = Order::select('orders.*', 'countries.name as countryName')
            ->where('orders.id', $orderid)
            ->leftJoin('countries', 'countries.id', 'orders.country_id')
            ->first();

        $orderitems = OrderItem::where('order_id', $orderid)->get();
        $data = [];

        $data['order'] = $order;
        $data['orderitems'] = $orderitems;
        return response()->json([
            'data' => $data,
        ]);
    }
    public function changeOrderStatus(Request $request, $id)
    {
        $order = Order::find($id);
        $order->status = $request->status;
        $order->shipping_date = $request->shipped_date;
        $order->save();
        $message = 'Order status changed successfully';
        session()->flash('success', $message);
        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }
    public function sendInvoiceEmail(Request $request, $order_id)
    {
        $message = 'Order email sent successfully';
        orderEmail($order_id, $request->userType);

        session()->flash('success', $message);
        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }
}