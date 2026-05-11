<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\Stock;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '15s';

    protected function getStats(): array
    {
        $today = now()->startOfDay();

        return [
            Stat::make('Total Penjualan', 'Rp ' . number_format(Transaction::where('payment_status', 'paid')->sum('total_amount'), 0, ',', '.'))
                ->description('Total pendapatan lunas')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success')
                ->chart([7, 10, 5, 2, 10, 3, 15]),

            Stat::make('Transaksi Hari Ini', Transaction::whereDate('transaction_date', $today)->count())
                ->description('Jumlah transaksi masuk hari ini')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('info'),

            Stat::make('Stok Gas', Stock::whereHas('product', fn($q) => $q->where('name', 'like', '%Gas%'))->sum('current_stock'))
                ->description('Total tabung tersedia')
                ->descriptionIcon('heroicon-m-fire')
                ->color('warning'),

            Stat::make('Stok Galon', Stock::whereHas('product', fn($q) => $q->where('name', 'like', '%Galon%'))->sum('current_stock'))
                ->description('Total galon tersedia')
                ->descriptionIcon('heroicon-m-beaker')
                ->color('primary'),
        ];
    }
}
