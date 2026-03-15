<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductRequest extends Model
{
    /** @use HasFactory<\Database\Factories\ProductRequestFactory> */
    use HasFactory;

    protected $fillable = [
        'request_number',
        'type',
        'customer_id',
        'created_by',
        'status',
        'notes',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(ProductRequestItem::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
