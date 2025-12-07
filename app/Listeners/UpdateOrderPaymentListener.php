<?php

namespace App\Listeners;

use App\Events\OrderPaymentUpdateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Order;

class UpdateOrderPaymentListener implements ShouldQueue
{

    /**
     * Handle the event.
     */
    public function handle(OrderPaymentUpdateEvent $event): void
    {
        \Log::info('OrderPaymentUpdateEvent received', [
            'event' => $event,
            'orderId' => $event->orderId,
            'paymentMethod' => $event->paymentMethod,
            'paymentInfo' => $event->paymentInfo,
        ]);
        $order = $event->orderId;
        $orderId = $event->orderId;
        $order = Order::find($orderId);
        $order->payment_method = $event->paymentMethod;
        $order->payment_status = $event->paymentInfo['status'];
        $order->stripe_charge_id = $event->paymentInfo['transaction_id'];
        // $order->payment_currency = $event->paymentInfo['currency'];
        $order->save();
    }
}
