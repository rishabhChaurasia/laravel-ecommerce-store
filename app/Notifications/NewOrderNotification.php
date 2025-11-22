<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
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
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('New Order Received - Order #' . $this->order->order_number)
                    ->line('A new order has been placed.')
                    ->line('Order Number: ' . $this->order->order_number)
                    ->line('Customer: ' . ($this->order->user->name ?? 'Guest'))
                    ->line('Total Amount: $' . number_format($this->order->grand_total / 100, 2))
                    ->line('Status: ' . ucfirst($this->order->status))
                    ->action('View Order', url('/admin/orders/' . $this->order->id))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification for database storage.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'customer_name' => $this->order->user->name ?? 'Guest',
            'total_amount' => $this->order->grand_total,
            'status' => $this->order->status,
            'message' => 'New order received: #' . $this->order->order_number,
        ];
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
            'customer_name' => $this->order->user->name ?? 'Guest',
            'total_amount' => $this->order->grand_total,
            'status' => $this->order->status,
            'message' => 'New order received: #' . $this->order->order_number,
        ];
    }
}
