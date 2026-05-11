<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Penjualan (7 Hari)';
    
    protected static string $color = 'success';

    protected function getData(): array
    {
        $data = collect(range(6, 0))->map(function ($day) {
            $date = Carbon::now()->subDays($day)->toDateString();

            return [
                'date' => $date,
                'total' => Transaction::whereDate('transaction_date', $date)->sum('total_amount'),
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Total Penjualan (Rp)',
                    'data' => $data->pluck('total'),
                    'fill' => 'start',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $data->pluck('date')->map(fn ($d) => Carbon::parse($d)->format('d M')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
