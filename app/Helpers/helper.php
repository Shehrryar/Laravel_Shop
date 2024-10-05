<?php
use App\Mail\OrderEmail;
use App\Models\Category;
use App\Models\Country;
use App\Models\Order;
use Carbon\Carbon;
use App\Models\ProductImage;
function getcategories()
{
    return Category::OrderBy('name', 'ASC')
        ->with('sub_category')
        ->where('status', 1)
        ->get();
}
function getProductImage($product_id)
{
    $image_data = ProductImage::where('product_id', $product_id)->first();
    return $image_data;
}
function country($id)
{
    $countryname = Country::where('id', $id)->value('name');
    return $countryname;
}
function orderEmail($orderId, $userType)
{
    $order = Order::where('id', $orderId)->with('items')->first();
    if ($userType == 'customer') {
        $subject = 'Thanks for your order';
        $email = $order->email;
    } else {
        $subject = 'You have received an Order';
        $email = env('ADMIN_EMAIL');
    }
    $maildata = [
        'subject' => $subject,
        'order' => $order,
        'userType' => $userType,
    ];
    Mail::to($email)->send(new OrderEmail($maildata));
}
function getDiscountedPrice($product, $discounts, $price)
{
    $discountedPrice = 0;
    $discountValue = 0;
    // Check if discounts array is not empty
    if (!empty($discounts)) {
        foreach ($discounts as $dis) {
            $product_ids = explode(',', $dis->product_ids);
            if (in_array($product, $product_ids) && $dis->type == 'percentage') {
                if (Carbon::now()->between($dis->start_at, $dis->expires_at)) {
                    $discountValue = $dis->value;
                    $discountedPrice = $price - ($price * ($dis->value / 100));
                    break; // Assuming only one discount should be applied
                }
            }
        }
    }
    return [
        'discount_value' => $discountValue,
        'discounted_price' => $discountedPrice,
        'actual_price' => $price,
    ];
}
if (!function_exists('transAdmin')) {
    function transAdmin($key, $replace = [], $locale = null)
    {
        return trans("admin::" . $key, $replace, $locale);
    }
}
if (!function_exists('transFront')) {
    function transFront($key, $replace = [], $locale = null)
    {
        return trans("front::" . $key, $replace, $locale);
    }
}
?>