<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Transaction;
use App\Models\Expense;
use Carbon\Carbon;

class ProfitChart extends ChartWidget
{
    protected static ?string $heading = 'Profit 7 Hari Terakhir';

    protected function getData(): array
    {
        $data = collect(range(6, 0))->map(function ($day) {

            $date = Carbon::now()->subDays($day)->toDateString();

            $income = Transaction::whereDate('transaction_date', $date)
                ->where('payment_status', 'paid')
                ->sum('total_amount');

            $expense = Expense::whereDate('expense_date', $date)
                ->sum('amount');

            return [
                'date' => $date,
                'income' => $income,
                'expense' => $expense,
                'profit' => $income - $expense,
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Profit',
                    'data' => $data->pluck('profit'),
                ],
                [
                    'label' => 'Pendapatan',
                    'data' => $data->pluck('income'),
                ],
                [
                    'label' => 'Pengeluaran',
                    'data' => $data->pluck('expense'),
                ],
            ],
            'labels' => $data->pluck('date')
                ->map(fn ($d) => Carbon::parse($d)->format('d M')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}