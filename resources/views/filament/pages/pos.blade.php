<x-filament-panels::page>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 pb-20 lg:pb-0">
        <!-- Panel Kiri: Produk -->
        <div class="lg:col-span-7 xl:col-span-8 space-y-6">
            <!-- Search & Filter -->
            <div class="relative group">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-emerald-500 transition-colors">
                    <x-heroicon-o-magnifying-glass class="w-5 h-5" />
                </span>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Cari Produk atau Barcode..." 
                    class="w-full pl-11 pr-4 py-4 bg-white dark:bg-gray-900 border-none rounded-2xl shadow-soft focus:ring-2 focus:ring-emerald-500 transition-all text-lg"
                >
            </div>

            <!-- Grid Produk -->
            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                @forelse($this->products as $product)
                    <div 
                        wire:click="addToCart({{ $product->id }})"
                        class="group cursor-pointer bg-white dark:bg-gray-900 p-4 rounded-2xl shadow-soft hover:shadow-xl hover:-translate-y-1 transition-all border-2 border-transparent hover:border-emerald-500 active:scale-95"
                    >
                        <div class="aspect-square bg-emerald-50 dark:bg-emerald-950 rounded-xl mb-4 flex items-center justify-center text-emerald-600">
                            @if(str_contains(strtolower($product->name), 'gas'))
                                <x-heroicon-o-fire class="w-12 h-12" />
                            @else
                                <x-heroicon-o-beaker class="w-12 h-12" />
                            @endif
                        </div>
                        <h3 class="font-bold text-gray-800 dark:text-white truncate" title="{{ $product->name }}">{{ $product->name }}</h3>
                        <p class="text-emerald-600 font-bold mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <div class="mt-3 flex justify-between items-center text-xs text-gray-500">
                            <span>Stok: {{ $product->stock->current_stock ?? 0 }}</span>
                            <span class="px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-800">{{ strtoupper($product->type) }}</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center space-y-4">
                        <div class="inline-flex p-6 bg-gray-100 dark:bg-gray-800 rounded-full text-gray-400">
                            <x-heroicon-o-face-frown class="w-12 h-12" />
                        </div>
                        <p class="text-gray-500 text-lg">Produk tidak ditemukan...</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Panel Kanan: Keranjang -->
        <div class="lg:col-span-5 xl:col-span-4 h-fit sticky top-6">
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-soft overflow-hidden flex flex-col max-h-[calc(100vh-120px)]">
                <!-- Header Keranjang -->
                <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
                    <h2 class="text-xl font-bold flex items-center gap-2">
                        <x-heroicon-o-shopping-bag class="w-6 h-6 text-emerald-500" />
                        Keranjang
                    </h2>
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full">
                        {{ count($cart) }} Item
                    </span>
                </div>

                <!-- List Item -->
                <div class="flex-1 overflow-y-auto p-6 space-y-4 min-h-[200px]">
                    @forelse($cart as $id => $item)
                        <div class="flex gap-4 items-center group animate-fade-in">
                            <div class="w-12 h-12 bg-gray-50 dark:bg-gray-800 rounded-xl flex-shrink-0 flex items-center justify-center text-gray-400 group-hover:bg-emerald-50 group-hover:text-emerald-500 transition-colors">
                                @if(str_contains(strtolower($item['name']), 'gas'))
                                    <x-heroicon-o-fire class="w-6 h-6" />
                                @else
                                    <x-heroicon-o-beaker class="w-6 h-6" />
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-sm truncate">{{ $item['name'] }}</h4>
                                <p class="text-emerald-600 text-xs font-semibold">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button wire:click="decrementQty({{ $id }})" class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center hover:bg-emerald-500 hover:text-white transition-all">-</button>
                                <span class="font-bold w-4 text-center">{{ $item['qty'] }}</span>
                                <button wire:click="incrementQty({{ $id }})" class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center hover:bg-emerald-500 hover:text-white transition-all">+</button>
                                <button wire:click="removeFromCart({{ $id }})" class="ml-2 text-gray-300 hover:text-red-500 transition-colors">
                                    <x-heroicon-o-trash class="w-5 h-5" />
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <x-heroicon-o-shopping-cart class="w-16 h-16 mx-auto text-gray-200 mb-4" />
                            <p class="text-gray-400 italic">Keranjang belanja kosong</p>
                        </div>
                    @endforelse
                </div>

                <!-- Footer Keranjang -->
                <div class="p-6 bg-gray-50 dark:bg-gray-800/50 space-y-4">
                    <!-- Customer Select -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Pelanggan</label>
                            <select wire:model="customer_id" class="w-full text-sm rounded-xl border-none shadow-sm dark:bg-gray-900 focus:ring-emerald-500">
                                <option value="">Umum</option>
                                @foreach($this->customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Status Bayar</label>
                            <select wire:model="payment_status" class="w-full text-sm rounded-xl border-none shadow-sm dark:bg-gray-900 focus:ring-emerald-500">
                                <option value="paid">Lunas</option>
                                <option value="debt">Hutang</option>
                            </select>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700 flex justify-between items-end">
                        <span class="text-gray-500 font-medium">Total Tagihan</span>
                        <span class="text-3xl font-black text-emerald-600">Rp {{ number_format($this->total, 0, ',', '.') }}</span>
                    </div>

                    <!-- Checkout Button -->
                    <button 
                        wire:click="checkout"
                        wire:loading.attr="disabled"
                        class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 disabled:bg-gray-300 text-white rounded-2xl font-black text-xl shadow-lg shadow-emerald-200 dark:shadow-none hover:shadow-xl transition-all active:scale-95 flex items-center justify-center gap-3 mt-4"
                        @if(empty($cart)) disabled @endif
                    >
                        <span wire:loading.remove>KONFIRMASI BAYAR</span>
                        <span wire:loading class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            MEMPROSES...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .animate-fade-in { animation: fadeIn 0.3s ease-out; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-filament-panels::page>
