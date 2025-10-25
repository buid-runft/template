<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreVerification extends Model
{
    protected $fillable = [
        'store_id', 'document_type', 'document_number', 'document_file',
        'verification_status', 'verified_at', 'rejected_reason'
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
