<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Product $product
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('สินค้าของคุณได้รับการอนุมัติแล้ว')
            ->greeting('สวัสดี ' . $notifiable->name)
            ->line('สินค้า "' . $this->product->name . '" ได้รับการอนุมัติแล้ว')
            ->line('สินค้าของคุณพร้อมจำหน่ายในร้านค้าแล้ว')
            ->action('ดูสินค้า', url('/vendor/products/' . $this->product->id))
            ->line('ขอบคุณที่ใช้บริการของเรา!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'message' => 'สินค้า "' . $this->product->name . '" ได้รับการอนุมัติแล้ว',
            'type' => 'product_approved',
        ];
    }
}
