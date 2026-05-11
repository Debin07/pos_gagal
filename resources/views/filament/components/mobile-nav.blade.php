<div class="mobile-bottom-nav">
    <a href="{{ \App\Filament\Pages\Dashboard::getUrl() }}" class="mobile-nav-item {{ request()->routeIs('filament.admin.pages.dashboard') ? 'active' : '' }}">
        <x-heroicon-o-home class="w-6 h-6" />
        <span>Beranda</span>
    </a>
    <a href="{{ \App\Filament\Resources\TransactionResource::getUrl() }}" class="mobile-nav-item {{ request()->routeIs('filament.admin.resources.transactions.*') ? 'active' : '' }}">
        <x-heroicon-o-shopping-cart class="w-6 h-6" />
        <span>Transaksi</span>
    </a>
    <a href="{{ \App\Filament\Pages\POS::getUrl() }}" class="mobile-nav-item {{ request()->routeIs('filament.admin.pages.pos') ? 'active' : '' }}">
        <x-heroicon-o-computer-desktop class="w-6 h-6" />
        <span>POS</span>
    </a>
    <a href="{{ \App\Filament\Resources\ProductResource::getUrl() }}" class="mobile-nav-item {{ request()->routeIs('filament.admin.resources.products.*') ? 'active' : '' }}">
        <x-heroicon-o-archive-box class="w-6 h-6" />
        <span>Stok</span>
    </a>
    <a href="{{ \App\Filament\Resources\ReportResource::getUrl() }}" class="mobile-nav-item {{ request()->routeIs('filament.admin.resources.reports.*') ? 'active' : '' }}">
        <x-heroicon-o-chart-bar class="w-6 h-6" />
        <span>Laporan</span>
    </a>
</div>

<a href="{{ \App\Filament\Pages\POS::getUrl() }}" class="mobile-fab">
    <x-heroicon-o-plus class="w-8 h-8" />
</a>
