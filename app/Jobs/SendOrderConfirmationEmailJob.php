<?php

namespace App\Jobs;

use App\Models\Order;
use App\Notifications\OrderConfirmationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendOrderConfirmationEmailJob implements ShouldQueue
{
    use Queueable;

    public $order;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Send order confirmation notification to the customer
        if ($this->order->user) {
            $this->order->user->notify(new OrderConfirmationNotification($this->order));
        }
    }
}
