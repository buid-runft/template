<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreProfile extends Model
{
    protected $fillable = [
        'store_id', 'description', 'story', 'mission', 'logo_image',
        'cover_image', 'banner_images', 'contact_email', 'contact_phone', 'social_links'
    ];

    protected $casts = [
        'banner_images' => 'array',
        'social_links' => 'array',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
