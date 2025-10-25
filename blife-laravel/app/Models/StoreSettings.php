<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreSettings extends Model
{
    protected $fillable = [
        'store_id', 'theme_color', 'layout_type', 'products_per_page',
        'auto_approve_products', 'low_stock_notification',
        'email_notifications', 'sms_notifications',
        'meta_title', 'meta_description'
    ];

    protected $casts = [
        'auto_approve_products' => 'boolean',
        'low_stock_notification' => 'boolean',
        'email_notifications' => 'boolean',
        'sms_notifications' => 'boolean',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
