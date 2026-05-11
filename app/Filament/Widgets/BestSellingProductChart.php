<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\TransactionItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class BestSellingProductChart extends ChartWidget
{
    protected static ?string $heading = 'Produk Terlaris';
    
    protected static ?string $maxHeight = '250px';

    protected function getData(): array
    {
        $bestSellers = TransactionItem::select('product_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('product_id')
            ->orderBy('total_qty', 'desc')
            ->limit(5)
            ->get();

        $labels = $bestSellers->map(fn ($item) => Product::find($item->product_id)?->name ?? 'Unknown');
        $data = $bestSellers->pluck('total_qty');

        return [
            'datasets' => [
                [
                    'label' => 'Total Qty Terjual',
                    'data' => $data,
                    'backgroundColor' => [
                        '#10b981',
                        '#34d399',
                        '#6ee7b7',
                        '#a7f3d0',
                        '#d1fae5',
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
