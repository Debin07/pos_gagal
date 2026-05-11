<x-filament::page>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        {{-- KPI --}}
        <div class="grid grid-cols-2 gap-4">
            @livewire(\App\Filament\Widgets\StatsOverview::class)
        </div>

        {{-- Chart --}}
        <div class="bg-white p-4 rounded-xl shadow">
            @livewire(\App\Filament\Widgets\TransactionChart::class)
        </div>

        {{-- Profit Chart --}}
        <div class="bg-white p-4 rounded-xl shadow">
            @livewire(\App\Filament\Widgets\ProfitChart::class)
        </div>

        {{-- Low Stock --}}
        <div class="bg-white p-4 rounded-xl shadow">
            <h2 class="text-sm font-semibold mb-2">Stok Menipis</h2>
            @livewire(\App\Filament\Widgets\LowStockAlert::class)
        </div>

    </div>

</x-filament::page>