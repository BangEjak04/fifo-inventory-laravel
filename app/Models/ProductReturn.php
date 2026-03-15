<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductReturn extends Model
{
    /** @use HasFactory<\Database\Factories\ProductReturnFactory> */
    use HasFactory;

    protected $fillable = [
        'request_item_id',
        'product_inbound_id',
        'quantity',
        'reason',
    ];

    public function requestItem(): BelongsTo
    {
        return $this->belongsTo(ProductRequestItem::class);
    }

    public function inbounds(): BelongsTo
    {
        return $this->belongsTo(ProductInbound::class);
    }
}
