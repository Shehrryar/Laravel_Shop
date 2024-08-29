<?php
use App\Mail\OrderEmail;
use App\Models\Category;
use App\Models\Order;
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


function orderEmail($orderId)
{
    $order = Order::where('id', $orderId)->with('items')->first();
    $maildata = [
        'subject' => 'Thanks for your order',
        'order'=>$order,
    ];
    Mail::to($order->email)->send(new OrderEmail($maildata));
    // dd($order);

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