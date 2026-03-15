<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductOutbound extends Model
{
    /** @use HasFactory<\Database\Factories\ProductOutboundFactory> */
    use HasFactory;

    protected $fillable = [
        'product_request_item_id',
        'product_inbound_id',
        'quantity_out',
        'outbound_date',
    ];

    protected function casts(): array
    {
        return [
            'outbound_date' => 'date',
        ];
    }

    public function inbounds(): BelongsTo
    {
        return $this->belongsTo(ProductInbound::class);
    }

    public function requestItem(): BelongsTo
    {
        return $this->belongsTo(ProductRequestItem::class);
    }
}
