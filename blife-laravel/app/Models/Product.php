<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = [
        'store_id', 'category_id', 'name', 'slug', 'description', 'price',
        'sale_price', 'sku', 'stock_quantity', 'weight', 'dimensions',
        'status', 'featured', 'images', 'attributes', 'seo_title', 'seo_description',
        'is_approved', 'is_active', 'notes'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'featured' => 'boolean',
        'images' => 'array',
        'attributes' => 'array',
        'dimensions' => 'array',
        'is_approved' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'product_attributes');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items');
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'related');
    }
}
