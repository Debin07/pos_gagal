<?php

namespace App\Actions\Transaction;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Actions\Stock\DecreaseStock;
use Filament\Notifications\Notification;

class CreateTransaction
{
    public function execute(array $data): Transaction
    {
        return DB::transaction(function () use ($data) {

            $total = 0;

            foreach ($data['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                $total += $product->price * $item['qty'];
            }

            $transaction = Transaction::create([
                'code' => $this->generateCode(),
                'customer_id' => $data['customer_id'] ?? null,
                'total_amount' => $total,
                'payment_status' => $data['payment_status'],
                'transaction_date' => now(),
            ]);

            $decreaseStock = new DecreaseStock();

            foreach ($data['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                $subtotal = $product->price * $item['qty'];

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'qty' => $item['qty'],
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $product = \App\Models\Product::findOrFail($item['product_id']);

                $stock = \App\Models\Stock::where('product_id', $product->id)->first();

                if (!$stock || $stock->current_stock < $item['qty']) {
                    throw new \Exception("Stok tidak cukup untuk produk {$product->name}");
                }

                $decreaseStock->execute(
                    $product->id,
                    $item['qty'],
                    $transaction->code
                );
                $currentStock = \App\Models\Stock::where('product_id', $product->id)->first();

                if ($currentStock && $currentStock->current_stock <= 0) {
                    Notification::make()
                        ->title('Stok Habis')
                        ->body("Produk {$product->name} sudah habis")
                        ->danger()
                        ->send();
                }
            }

            return $transaction;
        });
    }

    private function generateCode(): string
    {
        return 'TRX-' . str_pad(Transaction::count() + 1, 5, '0', STR_PAD_LEFT);
    }
}
