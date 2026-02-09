<?php
namespace App\Listeners;
use App\Events\OrderPlacedNotificationEvent;
use App\Mail\OrderEmail;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
class SendOrderPlacedNotificationListener implements ShouldQueue
{
    public function handle(OrderPlacedNotificationEvent $event): void
    {
        $order = Order::with('orderItems')->find($event->orderId);
        if (! $order) {
            return;
        }
        Mail::to($order->email)->queue(new OrderEmail($order));
    }
}