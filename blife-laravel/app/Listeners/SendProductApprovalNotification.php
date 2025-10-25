<?php

namespace App\Listeners;

use App\Events\ProductApproved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendProductApprovalNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(ProductApproved $event): void
    {
        // ส่ง notification ไปยัง vendor ที่สร้าง product
        $vendor = $event->product->store->user;

        $vendor->notify(new \App\Notifications\ProductApprovedNotification($event->product));

        // ส่ง notification ไปยัง admin ที่ approve
        // หรือส่งไปยัง admin group
    }
}
