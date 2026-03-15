<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'type',
        'is_active'
    ];

    public function inbounds(): HasMany
    {
        return $this->hasMany(ProductInbound::class);
    }

    public function requestItems(): HasMany
    {
        return $this->hasMany(ProductRequestItem::class);
    }
}
