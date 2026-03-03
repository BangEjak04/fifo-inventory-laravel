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
        'product_inbound_id',
        'quantity_out',
        'outbound_date',
    ];

    public function inbounds(): BelongsTo
    {
        return $this->belongsTo(ProductInbound::class);
    }
}
