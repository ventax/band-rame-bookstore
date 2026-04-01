{{-- Logo / Brand --}}
<div class="p-5 border-b border-white/20 flex items-center justify-between flex-shrink-0">
    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 bounce-hover min-w-0">
        @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('logo/logo.png'))
            <img src="{{ asset('storage/logo/logo.png') }}" alt="Logo"
                class="w-11 h-11 object-contain rounded-2xl bg-white/20 p-1 shadow-lg flex-shrink-0">
        @else
            <div
                class="w-11 h-11 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0">
                <i class="fas fa-book-reader text-xl text-white"></i>
            </div>
        @endif
        <div class="min-w-0">
            <span class="text-base font-bold text-white leading-tight truncate block">ATigaBookStore</span>
            <p class="text-[11px] text-white/70 font-semibold">Admin Panel</p>
        </div>
    </a>
    {{-- Close button: only shown inside mobile drawer (has .mobile-sidebar marker) --}}
    <button @click="sidebarOpen = false"
        class="sidebar-close-btn flex-shrink-0 w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition ml-2">
        <i class="fas fa-times text-white text-sm"></i>
    </button>
</div>

{{-- Navigation --}}
<nav class="flex-1 overflow-y-auto mt-4 px-3 pb-4">

    <a href="{{ route('admin.dashboard') }}"
        class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'nav-active' : '' }}">
        <span class="admin-nav-icon"><i class="fas fa-home text-sm"></i></span>
        <span>Dashboard</span>
    </a>

    <a href="{{ route('admin.books.index') }}"
        class="admin-nav-item {{ request()->routeIs('admin.books.*') ? 'nav-active' : '' }}">
        <span class="admin-nav-icon"><i class="fas fa-book text-sm"></i></span>
        <span>Kelola Buku</span>
    </a>

    <a href="{{ route('admin.categories.index') }}"
        class="admin-nav-item {{ request()->routeIs('admin.categories.*') ? 'nav-active' : '' }}">
        <span class="admin-nav-icon"><i class="fas fa-tags text-sm"></i></span>
        <span>Kategori</span>
    </a>

    <a href="{{ route('admin.orders.index') }}"
        class="admin-nav-item {{ request()->routeIs('admin.orders.*') ? 'nav-active' : '' }}">
        <span class="admin-nav-icon"><i class="fas fa-shopping-cart text-sm"></i></span>
        <span class="flex-1">Pesanan</span>
        @if (!empty($pendingOrdersCount) && $pendingOrdersCount > 0)
            <span class="admin-nav-badge">
                {{ $pendingOrdersCount > 99 ? '99+' : $pendingOrdersCount }}
            </span>
        @endif
    </a>

    <a href="{{ route('admin.settings.logo') }}"
        class="admin-nav-item {{ request()->routeIs('admin.settings.logo') || request()->routeIs('admin.settings.site-name*') || request()->routeIs('admin.settings.favicon*') ? 'nav-active' : '' }}">
        <span class="admin-nav-icon"><i class="fas fa-palette text-sm"></i></span>
        <span>Pengaturan Logo</span>
    </a>

    <a href="{{ route('admin.settings.content', 'hero') }}"
        class="admin-nav-item {{ request()->routeIs('admin.settings.content*') ? 'nav-active' : '' }}">
        <span class="admin-nav-icon"><i class="fas fa-edit text-sm"></i></span>
        <span>Konten Website</span>
    </a>

    <div class="border-t border-white/10 my-4 mx-2"></div>
    <p class="px-4 mb-2 text-[10px] font-bold tracking-widest text-orange-300/60 uppercase">Lainnya</p>

    <a href="{{ route('home') }}" target="_blank" class="admin-nav-item text-white/85 hover:text-white">
        <span class="admin-nav-icon"><i class="fas fa-external-link-alt text-sm"></i></span>
        <span>Lihat Website</span>
    </a>
</nav>
