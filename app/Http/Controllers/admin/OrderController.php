<?php

namespace App\Http\Controllers\admin;

use App\Events\OrderPlacedNotificationEvent;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    private function adminUser()
    {
        return Auth::guard('admin')->user();
    }

    private function isVendor(): bool
    {
        $admin = $this->adminUser();

        return $admin && (int) $admin->role === 3;
    }

    private function vendorStoreId()
    {
        return $this->adminUser()?->store_id;
    }

    private function vendorOrderIds(): array
    {
        if (!$this->isVendor()) {
            return [];
        }

        return OrderItem::join('products', 'orders_items.product_id', '=', 'products.id')
            ->where('products.store_id', $this->vendorStoreId())
            ->distinct()
            ->pluck('orders_items.order_id')
            ->toArray();
    }

    private function ensureVendorCanAccessOrder($orderId): void
    {
        if (!$this->isVendor()) {
            return;
        }

        if (empty($this->vendorStoreId())) {
            abort(403, 'Vendor account is not connected with any store.');
        }

        if (!in_array((int) $orderId, array_map('intval', $this->vendorOrderIds()))) {
            abort(403, 'You cannot access another vendor order.');
        }
    }

    private function orderItemsQuery($orderId)
    {
        $query = OrderItem::where('orders_items.order_id', $orderId);

        if ($this->isVendor()) {
            $query = $query
                ->join('products', 'orders_items.product_id', '=', 'products.id')
                ->where('products.store_id', $this->vendorStoreId())
                ->select('orders_items.*');
        }

        return $query;
    }

    public function index(Request $request)
    {
        $admin = $this->adminUser();

        $orders = Order::latest('orders.created_at')
            ->select('orders.*', 'users.name', 'users.email')
            ->leftJoin('users', 'users.id', '=', 'orders.user_id');

        /*
        |--------------------------------------------------------------------------
        | Vendor Order Filter
        |--------------------------------------------------------------------------
        | Vendor can see only orders that contain products from his own store.
        */
        if ($this->isVendor()) {
            if (empty($admin->store_id)) {
                abort(403, 'Vendor account is not connected with any store.');
            }

            $storeId = (int) $admin->store_id;

            $orders = $orders->whereIn('orders.id', $this->vendorOrderIds());

            // Vendor amount should be only vendor product amount, not full order grandtotal.
            $orders = $orders->addSelect(DB::raw("
                (
                    SELECT COALESCE(SUM(oi.total), 0)
                    FROM orders_items oi
                    INNER JOIN products p ON p.id = oi.product_id
                    WHERE oi.order_id = orders.id
                    AND p.store_id = {$storeId}
                ) as vendor_total
            "));
        }

        if ($request->get('keyword') != "") {
            $orders = $orders->where(function ($query) use ($request) {
                $query->where('users.name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('users.email', 'like', '%' . $request->keyword . '%')
                    ->orWhere('users.id', 'like', '%' . $request->keyword . '%')
                    ->orWhere('orders.id', 'like', '%' . $request->keyword . '%');
            });
        }

        $orders = $orders->paginate(10);

        return view('admin.orders.list', compact('orders'));
    }

    public function detail($orderid)
    {
        $this->ensureVendorCanAccessOrder($orderid);

        $order = Order::select('orders.*', 'countries.name as countryName')
            ->where('orders.id', $orderid)
            ->leftJoin('countries', 'countries.id', 'orders.country_id')
            ->first();

        if (empty($order)) {
            abort(404, 'Order not found.');
        }

        $orderitems = $this->orderItemsQuery($orderid)->get();

        $isVendor = $this->isVendor();
        $vendorTotal = $isVendor ? $orderitems->sum('total') : null;

        return view('admin.orders.detail', [
            'order' => $order,
            'orderitems' => $orderitems,
            'isVendor' => $isVendor,
            'vendorTotal' => $vendorTotal,
        ]);
    }

    public function getOrderDetailPdf($orderid)
    {
        $this->ensureVendorCanAccessOrder($orderid);

        $order = Order::select('orders.*', 'countries.name as countryName')
            ->where('orders.id', $orderid)
            ->leftJoin('countries', 'countries.id', 'orders.country_id')
            ->first();

        if (empty($order)) {
            abort(404, 'Order not found.');
        }

        $orderitems = $this->orderItemsQuery($orderid)->get();

        $isVendor = $this->isVendor();
        $vendorTotal = $isVendor ? $orderitems->sum('total') : null;

        $pdf = Pdf::loadView('admin.orders.pdf', [
            'order' => $order,
            'orderitems' => $orderitems,
            'isVendor' => $isVendor,
            'vendorTotal' => $vendorTotal,
        ]);

        return $pdf->download('order_' . $order->id . '_details.pdf');
    }

    public function changeOrderStatus(Request $request, $id)
    {
        /*
        |--------------------------------------------------------------------------
        | Important Safety Rule
        |--------------------------------------------------------------------------
        | orders.status is global for the full order.
        | If one order contains products from multiple vendors,
        | vendor must not change the full order status.
        */
        if ($this->isVendor()) {
            abort(403, 'Vendor cannot change global order status. Only super admin can update full order status.');
        }

        $order = Order::find($id);

        if (empty($order)) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found.',
            ]);
        }

        $order->status = $request->status;
        $order->payment_status = $request->payment_status;
        $order->shipping_date = $request->shipped_date;
        $order->save();

        $message = 'Order status changed successfully';
        session()->flash('success', $message);

        return response()->json([
            'status' => true,
            'message' => $message,
        ]);
    }

    public function sendInvoiceEmail(Request $request, $order_id)
    {
        /*
        |--------------------------------------------------------------------------
        | Important Safety Rule
        |--------------------------------------------------------------------------
        | Current invoice email sends the full order invoice.
        | Vendor should not send full order invoice if order has multiple stores.
        */
        if ($this->isVendor()) {
            abort(403, 'Vendor cannot send full order invoice. Only super admin can send invoice email.');
        }

        $message = 'Order email sent successfully';

        event(new OrderPlacedNotificationEvent($order_id));

        session()->flash('success', $message);

        return response()->json([
            'status' => true,
            'message' => $message,
        ]);
    }
}