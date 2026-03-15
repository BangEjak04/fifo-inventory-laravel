<?php

namespace App\Services;
use App\Models\ProductInbound;
use App\Models\ProductOutbound;
use App\Models\ProductRequestItem;
use Illuminate\Support\Facades\DB;

class FifoService
{
    public function process(ProductRequestItem $productRequestItem)
    {
        return DB::transaction(function () use ($productRequestItem) {
            $remaining = $productRequestItem->quantity_requested - $productRequestItem->quantity_fulfilled;

            if ($remaining <= 0) {
                throw new \Exception('Request already fulfilled');
            }

            $batches = ProductInbound::query()
                ->where('product_id', $productRequestItem->product_id)
                ->where('quantity_remaining', '>', 0)
                ->orderBy('production_date') // FIFO
                ->lockForUpdate()
                ->get();

            foreach ($batches as $batch) {

                if ($remaining <= 0) {
                    break;
                }

                $takeQty = min($batch->quantity_remaining, $remaining);

                ProductOutbound::create([
                    'request_item_id' => $productRequestItem->id,
                    'product_inbound_id' => $batch->id,
                    'quantity_out' => $takeQty,
                    'outbound_date' => now(),
                ]);

                $batch->decrement('quantity_remaining', $takeQty);

                $remaining -= $takeQty;
            }

            $fulfilled = $productRequestItem->quantity_requested - $remaining;

            $productRequestItem->update([
                'quantity_fulfilled' => $fulfilled,
            ]);

            if ($remaining > 0) {
                throw new \Exception('Stock not enough');
            }

            return true;
        });
    }
}
