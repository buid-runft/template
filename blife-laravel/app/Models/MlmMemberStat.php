<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MlmMemberStat extends Model
{
    protected $fillable = [
        'user_id', 'total_earnings', 'total_commissions', 'total_referrals',
        'active_referrals', 'network_size', 'current_rank', 'next_rank_threshold'
    ];

    protected $casts = [
        'total_earnings' => 'decimal:2',
        'total_commissions' => 'decimal:2',
        'total_referrals' => 'integer',
        'active_referrals' => 'integer',
        'network_size' => 'integer',
        'next_rank_threshold' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
