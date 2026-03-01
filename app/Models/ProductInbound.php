<?php

namespace App\Models;

use App\Enums\ProductionSession;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductInbound extends Model
{
    /** @use HasFactory<\Database\Factories\ProductInboundFactory> */
    use HasFactory;

    protected $fillable = [
        'product_id',
        'production_date',
        'session',
        'quantity_in',
        'quantity_remaining',
        'barcode',
    ];

    protected function casts(): array
    {
        return [
            'session' => ProductionSession::class,
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
