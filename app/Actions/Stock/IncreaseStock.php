<?php

namespace App\Actions\Stock;

use App\Models\Stock;
use App\Models\StockMovement;

class IncreaseStock
{
    public function execute(int $productId, int $qty, string $reference = null): void
    {
        $stock = Stock::firstOrCreate(
            ['product_id' => $productId],
            ['current_stock' => 0]
        );

        $before = $stock->current_stock;
        $after = $before + $qty;

        $stock->update([
            'current_stock' => $after
        ]);

        StockMovement::create([
            'product_id' => $productId,
            'type' => 'in',
            'qty' => $qty,
            'stock_before' => $before,
            'stock_after' => $after,
            'reference' => $reference,
            'created_at' => now(),
        ]);
    }
}