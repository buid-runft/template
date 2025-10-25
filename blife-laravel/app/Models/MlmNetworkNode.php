<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MlmNetworkNode extends Model
{
    protected $fillable = ['user_id', 'sponsor_id', 'placement_id', 'position', 'level'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sponsor_id');
    }

    public function placement(): BelongsTo
    {
        return $this->belongsTo(User::class, 'placement_id');
    }
}
