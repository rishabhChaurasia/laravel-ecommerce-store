<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Notifications\OrderConfirmationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendOrderConfirmationEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        // Send order confirmation notification to the customer
        if ($event->order->user) {
            $event->order->user->notify(new OrderConfirmationNotification($event->order));
        }
    }
}
