<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Store extends Model
{
    protected $fillable = [
        'user_id', 'mlm_member_id', 'store_slug', 'store_name', 'status',
        'approved_at', 'suspended_at', 'rejected_at'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'suspended_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mlmNode(): BelongsTo
    {
        return $this->belongsTo(MlmNetworkNode::class, 'mlm_member_id');
    }

    public function profile(): HasOne
    {
        return $this->hasOne(StoreProfile::class);
    }

    public function settings(): HasOne
    {
        return $this->hasOne(StoreSettings::class);
    }

    public function verification(): HasOne
    {
        return $this->hasOne(StoreVerification::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'related');
    }
}
