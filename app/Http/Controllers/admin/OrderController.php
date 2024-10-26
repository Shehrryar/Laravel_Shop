<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
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


    public function getOrderDetailPdf($orderid){

        $order = Order::select('orders.*', 'countries.name as countryName')
        ->where('orders.id', $orderid)
        ->leftJoin('countries', 'countries.id','orders.country_id')
        ->first();
        $orderitems = OrderItem::where('order_id', $orderid)->get();
        $pdf = Pdf::loadView('admin.orders.pdf', [
            'order' => $order,
            'orderitems' => $orderitems
        ]);
        // Return PDF for download
        return $pdf->download('order_' . $order->id . '_details.pdf');
    }


    public function changeOrderStatus(Request $request, $id){
        $order = Order::find($id);
        $order->status = $request->status;
        $order->shipping_date = $request->shipped_date;
        $order->save();
        $message = 'Order status changed successfully';
        session()->flash('success', $message);
        return response()->json([
            'status'=>true,
            'message'=> $message
        ]);
    }

    public function sendInvoiceEmail(Request $request, $order_id){
        $message = 'Order email sent successfully';
        orderEmail($order_id, $request->userType);
        
        session()->flash('success', $message);
        return response()->json([
            'status'=>true,
            'message'=> $message
        ]);
    }  
}