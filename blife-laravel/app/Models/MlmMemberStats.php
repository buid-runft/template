<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MlmMemberStats extends Model
{
    protected $fillable = [
        'user_id', 'total_pv', 'total_commission', 'current_balance',
        'team_size', 'left_team_size', 'right_team_size', 'last_calculation_at'
    ];

    protected $casts = [
        'last_calculation_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
