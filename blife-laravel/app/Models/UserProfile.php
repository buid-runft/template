<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'date_of_birth', 'gender', 'profile_image',
        'address_line_1', 'address_line_2', 'city', 'state', 'postal_code', 'country',
        'bank_name', 'bank_account_number', 'bank_account_name'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
