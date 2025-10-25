<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductReview extends Model
{
    protected $fillable = [
        'product_id', 'user_id', 'rating', 'title', 'comment', 'is_verified',
        'helpful_count', 'status'
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_verified' => 'boolean',
        'helpful_count' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
