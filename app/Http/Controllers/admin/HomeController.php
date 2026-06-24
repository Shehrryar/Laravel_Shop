<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function dashborad()
    {
        $admin = Auth::guard('admin')->user();

        /*
        |--------------------------------------------------------------------------
        | Vendor Dashboard
        |--------------------------------------------------------------------------
        | Vendor can see only own store data.
        */
        if ($admin && (int) $admin->role === 3) {
            $storeId = $admin->store_id;

            if (empty($storeId)) {
                abort(403, 'Vendor account is not connected with any store.');
            }

            // Orders that contain this vendor's products
            $vendorOrderIds = OrderItem::join('products', 'orders_items.product_id', '=', 'products.id')
                ->where('products.store_id', $storeId)
                ->distinct()
                ->pluck('orders_items.order_id');

            // Customers who ordered this vendor's products
            $vendorCustomerIds = Order::whereIn('id', $vendorOrderIds)
                ->whereNotNull('user_id')
                ->distinct()
                ->pluck('user_id');

            $data['order_count'] = Order::whereIn('id', $vendorOrderIds)->count();

            $data['user_count'] = User::whereIn('id', $vendorCustomerIds)
                ->where('role', 1)
                ->count();

            $data['product_count'] = Product::where('store_id', $storeId)->count();

            // Vendor total sales from only vendor products
            $data['totalSales'] = OrderItem::join('products', 'orders_items.product_id', '=', 'products.id')
                ->join('orders', 'orders_items.order_id', '=', 'orders.id')
                ->where('products.store_id', $storeId)
                ->where('orders.payment_status', 'paid')
                ->sum('orders_items.total');

            // Vendor stock quantity from vendor products
            $data['stock_count'] = DB::table('stocks')
                ->join('products', 'stocks.product_id', '=', 'products.id')
                ->where('products.store_id', $storeId)
                ->sum('stocks.quantity');

            return view('admin.dashboard.list', $data);
        }

        /*
        |--------------------------------------------------------------------------
        | Super Admin Dashboard
        |--------------------------------------------------------------------------
        | Super admin can see all platform data.
        */
        $data['order_count'] = Order::count();
        $data['user_count'] = User::where('role', 1)->count();
        $data['product_count'] = Product::count();

        $data['totalSales'] = Order::where('payment_status', 'paid')
            ->sum('grandtotal');

        $data['stock_count'] = DB::table('stocks')->sum('quantity');

        return view('admin.dashboard.list', $data);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login');
    }
}