<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Stock;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Clear Data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        TransactionItem::truncate();
        Transaction::truncate();
        StockMovement::truncate();
        Stock::truncate();
        Product::truncate();
        Customer::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Create Products
        $products = [
            ['name' => 'Gas LPG 3kg (Melon)', 'type' => 'gas', 'price' => 22000],
            ['name' => 'Gas LPG 12kg (Biru)', 'type' => 'gas', 'price' => 210000],
            ['name' => 'Bright Gas 5.5kg', 'type' => 'gas', 'price' => 105000],
            ['name' => 'Air Galon Aqua (Isi)', 'type' => 'gallon', 'price' => 20000],
            ['name' => 'Air Galon Le Minerale', 'type' => 'gallon', 'price' => 18000],
            ['name' => 'Isi Ulang Galon Biasa', 'type' => 'gallon', 'price' => 6000],
        ];

        foreach ($products as $p) {
            $product = Product::create($p);
            Stock::create([
                'product_id' => $product->id,
                'current_stock' => rand(20, 100),
            ]);
        }

        // 3. Create Customers
        $customers = ['Budi Santoso', 'Siti Aminah', 'Andi Wijaya', 'Dewi Lestari', 'Joko Susilo'];
        foreach ($customers as $name) {
            Customer::create([
                'name' => $name,
                'phone' => '0812' . rand(10000000, 99999999),
                'address' => 'Jl. Contoh No. ' . rand(1, 100),
            ]);
        }

        // 4. Create Transactions for last 10 days
        $allProducts = Product::all();
        $allCustomers = Customer::all();

        for ($i = 0; $i < 30; $i++) {
            $date = Carbon::now()->subDays(rand(0, 10))->subHours(rand(0, 23));
            $customer = (rand(0, 1) == 1) ? $allCustomers->random() : null;
            
            $transaction = Transaction::create([
                'code' => 'TRX-' . strtoupper(bin2hex(random_bytes(3))),
                'customer_id' => $customer?->id,
                'total_amount' => 0,
                'payment_status' => (rand(0, 5) > 0) ? 'paid' : 'debt',
                'transaction_date' => $date,
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            $total = 0;
            $itemsCount = rand(1, 3);
            $selectedProducts = $allProducts->random($itemsCount);

            foreach ($selectedProducts as $product) {
                $qty = rand(1, 5);
                $subtotal = $product->price * $qty;
                
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'qty' => $qty,
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }

            $transaction->update(['total_amount' => $total]);
        }
    }
}
