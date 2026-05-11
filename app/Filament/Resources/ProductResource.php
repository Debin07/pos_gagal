<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Actions\Stock\IncreaseStock;
use Filament\Support\Colors\Color;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    
    protected static ?string $navigationLabel = 'Stok Produk';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Informasi Produk')
                ->description('Kelola detail produk gas atau galon Anda.')
                ->schema([
                    TextInput::make('name')
                        ->label('Nama Produk')
                        ->placeholder('Contoh: Gas LPG 3kg')
                        ->required(),

                    TextInput::make('code')
                        ->label('Kode Produk')
                        ->placeholder('Contoh: GAS-3KG')
                        ->unique(ignoreRecord: true)
                        ->required(),

                    Select::make('type')
                        ->label('Kategori')
                        ->options([
                            'gas' => 'Gas',
                            'gallon' => 'Galon',
                        ])
                        ->required(),

                    TextInput::make('price')
                        ->label('Harga Jual')
                        ->numeric()
                        ->prefix('Rp')
                        ->required(),

                    Select::make('is_active')
                        ->label('Status')
                        ->options([
                            1 => 'Aktif',
                            0 => 'Nonaktif',
                        ])
                        ->default(1),
                ])->columns(2)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\TextColumn::make('name')
                        ->weight('bold')
                        ->size('lg')
                        ->searchable(),
                    
                    Tables\Columns\TextColumn::make('code')
                        ->label('Kode')
                        ->color('gray')
                        ->size('sm')
                        ->searchable(),
                    
                    Tables\Columns\TextColumn::make('type')
                        ->formatStateUsing(fn ($state) => strtoupper($state))
                        ->color('gray')
                        ->size('sm'),
                    
                    Tables\Columns\TextColumn::make('price')
                        ->money('IDR')
                        ->color('emerald')
                        ->weight('semibold'),
                    
                    Tables\Columns\TextColumn::make('stock.current_stock')
                        ->label('Stok')
                        ->badge()
                        ->color(fn ($state) => match (true) {
                            $state <= 5 => 'danger',
                            $state <= 10 => 'warning',
                            default => 'success',
                        })
                        ->formatStateUsing(fn ($state) => "Sisa Stok: $state")
                        ->prefix(' '),
                ])->space(2),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'gas' => 'Gas',
                        'gallon' => 'Galon',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),
                Tables\Actions\Action::make('tambah_stok')
                    ->label('Tambah Stok')
                    ->icon('heroicon-o-plus')
                    ->color('success')
                    ->form([
                        TextInput::make('qty')
                            ->label('Jumlah')
                            ->numeric()
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        app(IncreaseStock::class)->execute(
                            $record->id,
                            $data['qty'],
                            'manual'
                        );
                    }),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
