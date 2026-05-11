<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Product;

class LowStockAlert extends BaseWidget
{
    protected static ?string $heading = '⚠️ Peringatan Stok Menipis';
    
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(
                Product::query()
                    ->with('stock')
                    ->whereHas('stock', function (Builder $query) {
                        $query->where('current_stock', '<=', 10);
                    })
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Produk')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('type')
                    ->label('Kategori')
                    ->formatStateUsing(fn($state) => strtoupper($state)),

                Tables\Columns\TextColumn::make('stock.current_stock')
                    ->label('Sisa Stok')
                    ->badge()
                    ->color(fn ($state) => $state <= 5 ? 'danger' : 'warning'),
            ])
            ->actions([
                Tables\Actions\Action::make('restock')
                    ->label('Restock')
                    ->url(fn (Product $record) => \App\Filament\Resources\ProductResource::getUrl('index', ['tableSearch' => $record->name]))
                    ->icon('heroicon-m-arrow-path')
                    ->color('emerald')
                    ->button(),
            ])
            ->paginated(false);
    }
}
