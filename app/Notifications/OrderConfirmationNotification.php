<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderConfirmationNotification extends Notification
{
    use Queueable;

    public $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
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
        return (new MailMessage)
                    ->subject('Order Confirmation - Order #' . $this->order->order_number)
                    ->greeting('Thank you for your order!')
                    ->line('Your order has been placed successfully.')
                    ->line('Order Number: ' . $this->order->order_number)
                    ->line('Order Date: ' . $this->order->created_at->format('M d, Y h:i A'))
                    ->line('Total Amount: $' . number_format($this->order->grand_total / 100, 2))
                    ->line('Payment Method: ' . ucfirst(str_replace('_', ' ', $this->order->payment_method)))
                    ->line('Payment Status: ' . ucfirst($this->order->payment_status))
                    ->line('Order Status: ' . ucfirst($this->order->status))
                    ->line('Shipping Address: ' . $this->order->shipping_address['address'] . ', ' .
                           $this->order->shipping_address['city'] . ', ' .
                           $this->order->shipping_address['state'] . ' ' .
                           $this->order->shipping_address['zipcode'])
                    ->line('Thank you for shopping with us!')
                    ->action('View Order Details', url('/account/orders/' . $this->order->id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'total_amount' => $this->order->grand_total,
            'payment_method' => $this->order->payment_method,
            'payment_status' => $this->order->payment_status,
            'status' => $this->order->status,
            'message' => 'Order confirmation for #' . $this->order->order_number,
        ];
    }
}
