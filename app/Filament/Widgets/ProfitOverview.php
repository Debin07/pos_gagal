<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

use App\Models\Transaction;
use App\Models\Expense;

class ProfitOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $income = Transaction::where('payment_status', 'paid')->sum('total_amount');

        $expense = Expense::sum('amount');

        $profit = $income - $expense;

        return [

            Stat::make('Pendapatan', number_format($income)),

            Stat::make('Pengeluaran', number_format($expense)),

            Stat::make('Profit', number_format($profit))
                ->color($profit < 0 ? 'danger' : 'success'),
        ];
    }
}