<?php

namespace App\Actions\Stock;

use App\Models\Stock;
use App\Models\StockMovement;
use Exception;

class DecreaseStock
{
    public function execute(int $productId, int $qty, ?string $reference = null): void
    {
        $stock =  Stock::where('product_id', $productId)->first();

        if (!$stock || $stock->current_stock < $qty) {
            throw new Exception('Insufficient stock');
        }

        $before = $stock->current_stock;
        $after = $before - $qty;

        $stock->update([
            'current_stock' => $after
        ]);

        StockMovement::create([
            'product_id' => $productId,
            'type' => 'out',
            'qty' => $qty,
            'stock_before' => $before,
            'stock_after' => $after,
            'reference' => $reference,
        ]);
    }
}