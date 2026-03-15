<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductRequestItem extends Model
{
    /** @use HasFactory<\Database\Factories\ProductRequestItemFactory> */
    use HasFactory;

    protected $fillable = [
        'product_request_id',
        'product_id',
        'quantity_requested',
        'quantity_fulfilled',
    ];

    public function request(): BelongsTo
    {
        return $this->belongsTo(ProductRequest::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function outbounds(): HasMany
    {
        return $this->hasMany(ProductOutbound::class);
    }

    public function returns(): HasMany
    {
        return $this->hasMany(ProductReturn::class);
    }

    public function getRemainingAttribute(): int
    {
        return $this->quantityRequested - $this->quantityFulfilled;
    }
}
