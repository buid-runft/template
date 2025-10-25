<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SnowballPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_type',
        'plan_name',
        'description',
        'master_formula',
        'base_multiplier',
        'currency_factor',
        'time_limited',
        'valid_from',
        'valid_to',
        'min_order_amount',
        'max_points_per_transaction',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'base_multiplier' => 'decimal:4',
        'currency_factor' => 'decimal:4',
        'min_order_amount' => 'decimal:2',
        'max_points_per_transaction' => 'decimal:2',
        'time_limited' => 'boolean',
        'is_active' => 'boolean',
        'valid_from' => 'datetime',
        'valid_to' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function productSettings()
    {
        return $this->hasMany(ProductSnowballSetting::class, 'snowball_plan_type', 'plan_type');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeValid($query)
    {
        return $query->where(function ($q) {
            $q->where('time_limited', false)
              ->orWhere(function ($sub) {
                  $sub->where('time_limited', true)
                      ->where('valid_from', '<=', now())
                      ->where('valid_to', '>=', now());
              });
        });
    }
}
