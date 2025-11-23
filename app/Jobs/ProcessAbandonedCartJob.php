<?php

namespace App\Jobs;

use App\Models\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AbandonedCartNotification; // We'll create this

class ProcessAbandonedCartJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Find carts that have not been updated in the last 24 hours and still have items
        $abandonedCarts = Cart::where('updated_at', '<', now()->subHours(24))
            ->whereHas('items') // Only carts with items
            ->get();

        foreach ($abandonedCarts as $cart) {
            // Check if the cart has a user associated with it
            if ($cart->user) {
                // Send abandoned cart notification to the user
                // For now, we'll just send a simple notification
                // In a real app, this could be an email with cart contents
                $cart->user->notify(new \App\Notifications\AbandonedCartNotification($cart));
            }
        }
    }
}
