<?php

namespace App\Notifications;

use App\Models\Cart;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AbandonedCartNotification extends Notification
{
    use Queueable;

    public $cart;

    /**
     * Create a new notification instance.
     */
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $cartItems = $this->cart->items;
        $totalItems = $cartItems->sum('quantity');
        $totalValue = 0;

        foreach ($cartItems as $item) {
            $totalValue += $item->product->price * $item->quantity;
        }

        return (new MailMessage)
                    ->subject('Your Cart is Waiting - Complete Your Purchase!')
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line('We noticed you left some items in your cart.')
                    ->line('Items in your cart: ' . $totalItems . ' item(s)')
                    ->line('Estimated total: $' . number_format($totalValue / 100, 2))
                    ->line('Don\'t forget to complete your purchase before these items sell out!')
                    ->action('Return to Cart', url('/cart'))
                    ->line('Thank you for considering us for your purchase. We hope to see you again soon!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'cart_id' => $this->cart->id,
            'items_count' => $this->cart->items->sum('quantity'),
            'message' => 'Reminder about items left in cart',
        ];
    }
}
