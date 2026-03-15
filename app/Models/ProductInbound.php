<?php

namespace App\Models;

use App\Enums\ProductionSession;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Milon\Barcode\DNS1D;

class ProductInbound extends Model
{
    /** @use HasFactory<\Database\Factories\ProductInboundFactory> */
    use HasFactory;

    protected $fillable = [
        'product_id',
        'production_date',
        'session',
        'expired_date',
        'quantity_in',
        'quantity_remaining',
        'barcode',
    ];

    protected function casts(): array
    {
        return [
            'session' => ProductionSession::class,
            'production_date' => 'date',
        ];
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

    public function getBarcodeImageAttribute(): string
    {
        $dns = new DNS1D();
        $svg = $dns->getBarcodeHTML($this->barcode, 'C128');
        return $svg;
    }
}
