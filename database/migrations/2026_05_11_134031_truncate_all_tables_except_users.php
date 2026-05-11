<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Truncate all tables except users
        $tables = [
            'notifications',
            'expenses',
            'restock_items',
            'restocks',
            'suppliers',
            'stock_movements',
            'stocks',
            'transaction_items',
            'transactions',
            'customers',
            'products',
        ];

        foreach ($tables as $table) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table($table)->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cannot reverse truncate operation
        // This migration is irreversible
    }
};
