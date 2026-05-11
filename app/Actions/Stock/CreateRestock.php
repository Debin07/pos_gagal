<?php

namespace App\Actions\Stock;

use App\Models\Restock;
use App\Models\RestockItem;
use App\Models\Product;

class CreateRestock
{
    public function execute(array $data): Restock
    {
        $restock = Restock::create([
            'supplier_id' => $data['supplier_id'],
            'code' => 'RST-' . now()->timestamp,
            'restock_date' => $data['restock_date'],
        ]);

        $increaseStock = app(IncreaseStock::class);

        foreach ($data['items'] as $item) {
            $product = Product::findOrFail($item['product_id']);

            RestockItem::create([
                'restock_id' => $restock->id,
                'product_id' => $product->id,
                'qty' => $item['qty'],
            ]);

            $increaseStock->execute(
                $product->id,
                $item['qty'],
                $restock->code
            );
        }

        return $restock;
    }
}