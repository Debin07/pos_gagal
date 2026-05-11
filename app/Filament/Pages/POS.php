<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Product;
use App\Models\Customer;
use App\Actions\Transaction\CreateTransaction;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;

class POS extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';
    protected static string $view = 'filament.pages.pos';
    protected static ?string $title = 'Kasir Pintar';
    protected static ?string $navigationLabel = 'POS';

    public $search = '';
    public $cart = [];
    public $customer_id = null;
    public $payment_status = 'paid';
    public $payment_method = 'cash';

    public function mount()
    {
        // Initial setup if needed
    }

    public function getProductsProperty(): Collection
    {
        return Product::where('is_active', true)
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('code', 'like', '%' . $this->search . '%');
            })
            ->with('stock')
            ->get();
    }

    public function getCustomersProperty(): Collection
    {
        return Customer::all();
    }

    public function addToCart($productId)
    {
        $product = Product::with('stock')->find($productId);

        if (!$product) return;

        if ($product->stock && $product->stock->current_stock <= 0) {
            Notification::make()
                ->title('Stok Habis')
                ->danger()
                ->send();
            return;
        }

        if (isset($this->cart[$productId])) {
            if ($product->stock && $this->cart[$productId]['qty'] >= $product->stock->current_stock) {
                Notification::make()
                    ->title('Stok Terbatas')
                    ->body("Maksimal stok tersedia: {$product->stock->current_stock}")
                    ->warning()
                    ->send();
                return;
            }
            $this->cart[$productId]['qty']++;
        } else {
            $this->cart[$productId] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'qty' => 1,
                'image' => $product->image_url ?? null, // Fallback if image exists
            ];
        }
        
        $this->dispatch('cart-updated');
    }

    public function incrementQty($productId)
    {
        $product = Product::find($productId);
        if ($product->stock && $this->cart[$productId]['qty'] >= $product->stock->current_stock) {
            Notification::make()->title('Stok Terbatas')->warning()->send();
            return;
        }
        $this->cart[$productId]['qty']++;
    }

    public function decrementQty($productId)
    {
        if ($this->cart[$productId]['qty'] > 1) {
            $this->cart[$productId]['qty']--;
        } else {
            unset($this->cart[$productId]);
        }
    }

    public function removeFromCart($productId)
    {
        unset($this->cart[$productId]);
    }

    public function getTotalProperty()
    {
        return collect($this->cart)->sum(fn ($item) => $item['price'] * $item['qty']);
    }

    public function checkout()
    {
        if (empty($this->cart)) {
            Notification::make()->title('Keranjang masih kosong')->danger()->send();
            return;
        }

        try {
            $createTransaction = new CreateTransaction();
            $transaction = $createTransaction->execute([
                'customer_id' => $this->customer_id,
                'payment_status' => $this->payment_status,
                'items' => array_values($this->cart)
            ]);

            $this->reset(['cart', 'customer_id', 'payment_status', 'search']);
            
            Notification::make()
                ->title('Transaksi Berhasil')
                ->success()
                ->send();

            return redirect()->route('transactions.print', $transaction);

        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal Memproses Transaksi')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
