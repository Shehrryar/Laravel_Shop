<?php
namespace App\Services;
use App\Models\Cart;
use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\Shipping;
use Illuminate\Support\Facades\Auth;
class CartService
{
    public function calculateCartTotals($couponApplied = false, $newTotal = null)
    {
        $countries = Country::orderBy('name', 'ASC')->get();
        $customerAddresses = Auth::check()
            ? CustomerAddress::where('user_id', Auth::id())->get()
            : collect();
        $customerFirstAddress = Auth::check()
            ? CustomerAddress::where('user_id', Auth::id())->first()
            : null;
        $cartcontent = Cart::where('user_id', auth()->id())
            ->with(['product', 'size'])
            ->get();
        $cartTotalAmount = $cartcontent->sum(fn($item) => $item->price);
        $cartTotalDiscountAmount = $cartcontent->sum(fn($item) => $item->discounted_price);
        $bagSavingValue = $cartTotalDiscountAmount > 0
            ? $cartTotalAmount - $cartTotalDiscountAmount
            : 0;
        // Shipping
        $shippingAmount = 100;
        if ($customerFirstAddress && $customerFirstAddress->country_id) {
            $shipping = Shipping::where('country_id', $customerFirstAddress->country_id)->first();
            if ($shipping) {
                foreach ($cartcontent as $item) {
                    $shippingAmount += $shipping->amount * $item->quantity;
                }
            }
        }
        // Total payable
        $total = $couponApplied
            ? $newTotal + $shippingAmount - $bagSavingValue
            : $cartTotalAmount + $shippingAmount - $bagSavingValue;
        return [
            'countries' => $countries,
            'customerAddresses' => $customerAddresses,
            'cartcontent' => $cartcontent,
            'cartTotalAmount' => $cartTotalAmount,
            'bagSavingValue' => $bagSavingValue,
            'shippingAmount' => $shippingAmount,
            'totalPayable' => $total,
        ];
    }
}