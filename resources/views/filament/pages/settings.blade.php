<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Akun Section -->
        <div class="fi-card p-6 bg-white dark:bg-gray-900 rounded-2xl shadow-soft">
            <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                <x-heroicon-o-user-circle class="w-6 h-6 text-emerald-500" />
                Profil Pengelola
            </h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-800">
                    <span class="text-gray-500">Nama Admin</span>
                    <span class="font-semibold">{{ auth()->user()->name }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-800">
                    <span class="text-gray-500">Email</span>
                    <span class="font-semibold">{{ auth()->user()->email }}</span>
                </div>
                <button class="mt-4 text-emerald-600 font-bold text-sm hover:underline">Ubah Kata Sandi</button>
            </div>
        </div>

        <!-- Toko/Outlet Section -->
        <div class="fi-card p-6 bg-white dark:bg-gray-900 rounded-2xl shadow-soft">
            <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                <x-heroicon-o-building-storefront class="w-6 h-6 text-emerald-500" />
                Informasi Toko
            </h3>
            <div class="space-y-4">
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-400 uppercase">Nama Toko</label>
                    <p class="font-bold">Gas & Galon Berkah</p>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-400 uppercase">Alamat</label>
                    <p class="text-sm">Jl. Raya Sukses No. 88, Jakarta Selatan</p>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-400 uppercase">Telepon</label>
                    <p class="text-sm">0812-9988-7766</p>
                </div>
            </div>
        </div>

        <!-- Backup Data -->
        <div class="fi-card p-6 bg-white dark:bg-gray-900 rounded-2xl shadow-soft">
            <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                <x-heroicon-o-cloud-arrow-up class="w-6 h-6 text-emerald-500" />
                Keamanan & Backup
            </h3>
            <div class="p-4 bg-emerald-50 dark:bg-emerald-950/30 rounded-xl border border-emerald-100 dark:border-emerald-900">
                <p class="text-sm text-emerald-800 dark:text-emerald-400">Terakhir backup otomatis: 2 jam yang lalu</p>
            </div>
            <div class="mt-4 flex gap-3">
                <button class="px-4 py-2 bg-emerald-600 text-white rounded-xl text-sm font-bold shadow-sm">Backup Sekarang</button>
                <button class="px-4 py-2 bg-gray-100 dark:bg-gray-800 rounded-xl text-sm font-bold">Download Database</button>
            </div>
        </div>

        <!-- Notifikasi -->
        <div class="fi-card p-6 bg-white dark:bg-gray-900 rounded-2xl shadow-soft">
            <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                <x-heroicon-o-bell class="w-6 h-6 text-emerald-500" />
                Notifikasi
            </h3>
            <div class="space-y-3">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox" checked class="w-5 h-5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                    <span class="text-sm font-medium">Notifikasi Stok Menipis</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox" checked class="w-5 h-5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                    <span class="text-sm font-medium">Laporan Harian via Email</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox" class="w-5 h-5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                    <span class="text-sm font-medium">Notifikasi Hutang Jatuh Tempo</span>
                </label>
            </div>
        </div>
    </div>
</x-filament-panels::page>
