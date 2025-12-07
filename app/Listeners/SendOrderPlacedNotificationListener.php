<?php

namespace App\Listeners;

use App\Events\OrderPlacedNotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Order;
use App\Mail\OrderEmail;
use Illuminate\Support\Facades\Mail;

class SendOrderPlacedNotificationListener implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(OrderPlacedNotificationEvent $event): void
    {

        Mail::to($event->order->email)->send(new OrderEmail($event->order));
    }
}

