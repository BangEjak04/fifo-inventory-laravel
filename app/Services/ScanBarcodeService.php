<?php

namespace App\Services;

use App\Models\ProductInbound;
use App\Models\ProductOutbound;
use App\Models\ProductRequestItem;
use Illuminate\Support\Facades\DB;

class ScanBarcodeService
{
    public function scan(ProductRequestItem $item, string $barcode, int $qty)
    {
        return DB::transaction(function () use ($item, $barcode, $qty) {

            $batch = ProductInbound::where('barcode', $barcode)->firstOrFail();

            if ($batch->product_id !== $item->product_id) {
                throw new \Exception('Barcode tidak sesuai dengan produk request');
            }

            if ($batch->quantity_remaining < $qty) {
                throw new \Exception('Stok batch tidak cukup');
            }

            ProductOutbound::create([
                'product_request_item_id' => $item->id,
                'product_inbound_id' => $batch->id,
                'quantity_out' => $qty,
                'outbound_date' => now(),
            ]);

            $batch->decrement('quantity_remaining', $qty);

            $item->increment('quantity_fulfilled', $qty);

            return true;
        });
    }
}