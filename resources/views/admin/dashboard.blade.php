@extends('admin.layouts.app')

@section('title', 'Dashboard - Admin Panel')
@section('page-title', 'Dashboard')

@section('content')

    {{-- Welcome Banner --}}
    <div class="mb-6 rounded-2xl bg-gradient-to-r from-blue-800 via-blue-700 to-blue-500 shadow-xl overflow-hidden relative">
        <div class="px-6 py-6 sm:px-8 sm:py-7 relative z-10 flex items-center justify-between">
            <div>
                <p class="text-blue-200 text-sm font-medium">Selamat datang kembali,</p>
                <h2 class="text-white text-2xl sm:text-3xl font-extrabold mt-1 tracking-tight">{{ Auth::user()->name }} 👋
                </h2>
                <p class="text-blue-300 text-xs mt-2">{{ now()->format('l, d F Y') }}</p>
            </div>
            <div class="flex gap-3 flex-shrink-0">
                <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}"
                    class="hidden sm:flex items-center gap-2 bg-white/20 hover:bg-white/30 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition backdrop-blur-sm border border-white/20">
                    <i class="fas fa-shopping-cart"></i> Kelola Pesanan
                </a>
                <a href="{{ route('admin.books.create') }}"
                    class="hidden sm:flex items-center gap-2 bg-orange-500 hover:bg-orange-400 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-lg">
                    <i class="fas fa-plus"></i> Tambah Buku
                </a>
            </div>
        </div>
        {{-- Decorative circles --}}
        <div class="absolute -top-8 -right-8 w-40 h-40 bg-white/5 rounded-full pointer-events-none"></div>
        <div class="absolute -bottom-10 right-24 w-56 h-56 bg-white/5 rounded-full pointer-events-none"></div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 gap-4 mb-6">

        <div class="bg-white rounded-2xl shadow-sm border-t-4 border-blue-500 p-5 hover:shadow-md transition-shadow group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Buku</p>
                    <p class="text-3xl font-extrabold text-gray-800 mt-2 leading-none">{{ $stats['total_books'] }}</p>
                </div>
                <div
                    class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-500 transition-colors">
                    <i class="fas fa-book text-blue-500 group-hover:text-white text-base transition-colors"></i>
                </div>
            </div>
            <a href="{{ route('admin.books.index') }}"
                class="inline-block mt-3 text-[11px] text-blue-500 font-semibold hover:underline">Kelola →</a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border-t-4 border-green-500 p-5 hover:shadow-md transition-shadow group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Kategori</p>
                    <p class="text-3xl font-extrabold text-gray-800 mt-2 leading-none">{{ $stats['total_categories'] }}</p>
                </div>
                <div
                    class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0 group-hover:bg-green-500 transition-colors">
                    <i class="fas fa-tags text-green-500 group-hover:text-white text-base transition-colors"></i>
                </div>
            </div>
            <a href="{{ route('admin.categories.index') }}"
                class="inline-block mt-3 text-[11px] text-green-600 font-semibold hover:underline">Kelola →</a>
        </div>

        <div
            class="bg-white rounded-2xl shadow-sm border-t-4 border-purple-500 p-5 hover:shadow-md transition-shadow group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Pesanan</p>
                    <p class="text-3xl font-extrabold text-gray-800 mt-2 leading-none">{{ $stats['total_orders'] }}</p>
                </div>
                <div
                    class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center flex-shrink-0 group-hover:bg-purple-500 transition-colors">
                    <i class="fas fa-shopping-cart text-purple-500 group-hover:text-white text-base transition-colors"></i>
                </div>
            </div>
            <a href="{{ route('admin.orders.index') }}"
                class="inline-block mt-3 text-[11px] text-purple-600 font-semibold hover:underline">Kelola →</a>
        </div>

        <div
            class="bg-white rounded-2xl shadow-sm border-t-4 border-yellow-400 p-5 hover:shadow-md transition-shadow group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Customer</p>
                    <p class="text-3xl font-extrabold text-gray-800 mt-2 leading-none">{{ $stats['total_users'] }}</p>
                </div>
                <div
                    class="w-10 h-10 rounded-xl bg-yellow-100 flex items-center justify-center flex-shrink-0 group-hover:bg-yellow-400 transition-colors">
                    <i class="fas fa-users text-yellow-500 group-hover:text-white text-base transition-colors"></i>
                </div>
            </div>
            <p class="mt-3 text-[11px] text-gray-400 font-semibold">Pengguna terdaftar</p>
        </div>

        <div
            class="bg-white rounded-2xl shadow-sm border-t-4 border-orange-500 p-5 hover:shadow-md transition-shadow group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Perlu Diproses</p>
                    <p
                        class="text-3xl font-extrabold mt-2 leading-none {{ $stats['pending_orders'] > 0 ? 'text-orange-600' : 'text-gray-800' }}">
                        {{ $stats['pending_orders'] }}</p>
                </div>
                <div
                    class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center flex-shrink-0 group-hover:bg-orange-500 transition-colors">
                    <i class="fas fa-clock text-orange-500 group-hover:text-white text-base transition-colors"></i>
                </div>
            </div>
            <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}"
                class="inline-block mt-3 text-[11px] text-orange-500 font-semibold hover:underline">Lihat →</a>
        </div>

    </div>

    {{-- ══════════════════════════ ROW 2: Revenue cards + 7-day bar chart ══════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">

        {{-- Revenue summary cards --}}
        <div class="grid grid-cols-1 gap-4">
            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-5 shadow-md text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-xs font-semibold uppercase tracking-wide">Total Revenue</p>
                        <p class="text-2xl font-extrabold mt-1">Rp
                            {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                        <p class="text-emerald-200 text-xs mt-1">Dari semua pesanan sukses</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-wallet text-white text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl p-5 shadow-md text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-xs font-semibold uppercase tracking-wide">Revenue Bulan Ini</p>
                        <p class="text-2xl font-extrabold mt-1">Rp
                            {{ number_format($stats['revenue_this_month'], 0, ',', '.') }}</p>
                        <p class="text-blue-200 text-xs mt-1">{{ $stats['orders_this_month'] }} pesanan &bull;
                            {{ $newCustomers }} pelanggan baru</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- 7-day orders bar chart --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-bold text-gray-800">Pesanan 7 Hari Terakhir</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Jumlah pesanan masuk per hari</p>
                </div>
                <span class="text-xs bg-blue-100 text-blue-700 font-semibold px-3 py-1 rounded-full">7 hari</span>
            </div>
            <div class="flex items-end gap-1.5 flex-1 min-h-[9rem]">
                @php $maxOrders = max(1, $revenueChart->max('orders')); @endphp
                @foreach ($revenueChart as $day)
                    @php $pct = $day['orders'] > 0 ? max(8, ($day['orders'] / $maxOrders) * 100) : 4; @endphp
                    <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                        <span class="text-[10px] font-bold text-gray-500">{{ $day['orders'] ?: '' }}</span>
                        <div class="w-full rounded-t-lg"
                            style="height:{{ $pct }}%; background: linear-gradient(to top, #1d4ed8, #60a5fa);"
                            title="{{ $day['label'] }}: {{ $day['orders'] }} pesanan"></div>
                        <span class="text-[9px] text-gray-400 font-medium">{{ $day['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ══════════════════════════ ROW 3: Bestsellers + Order status + Top categories ══════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">

        {{-- Top 5 best-selling books --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-orange-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-fire text-orange-500 text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm">Buku Terlaris</h3>
                        <p class="text-[10px] text-gray-400">Berdasarkan jumlah terjual</p>
                    </div>
                </div>
                <a href="{{ route('admin.books.index') }}"
                    class="text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition">Semua
                    →</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($topBooks as $i => $item)
                    <div class="flex items-center gap-3 px-5 py-3">
                        <span
                            class="w-6 h-6 rounded-full flex items-center justify-center text-[11px] font-extrabold flex-shrink-0
                            {{ $i === 0 ? 'bg-yellow-400 text-white' : ($i === 1 ? 'bg-gray-300 text-gray-700' : ($i === 2 ? 'bg-orange-400 text-white' : 'bg-gray-100 text-gray-500')) }}">
                            {{ $i + 1 }}
                        </span>
                        <div
                            class="w-9 h-12 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden flex items-center justify-center">
                            @if ($item->book && $item->book->cover_image)
                                <img src="{{ asset('storage/' . $item->book->cover_image) }}"
                                    class="w-full h-full object-cover" alt="">
                            @else
                                <i class="fas fa-book text-gray-300 text-xs"></i>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ $item->book->title ?? '-' }}</p>
                            <p class="text-[11px] text-gray-400 truncate">{{ $item->book->author ?? '' }}</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="text-sm font-extrabold text-blue-600">{{ $item->total_sold }}</p>
                            <p class="text-[10px] text-gray-400">terjual</p>
                        </div>
                    </div>
                @empty
                    <div class="py-10 text-center text-gray-400 text-sm">Belum ada data penjualan</div>
                @endforelse
            </div>
        </div>

        {{-- Order status breakdown --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-2.5">
                <div class="w-8 h-8 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-pie text-purple-500 text-sm"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-sm">Status Pesanan</h3>
                    <p class="text-[10px] text-gray-400">Distribusi semua pesanan</p>
                </div>
            </div>
            <div class="p-5 space-y-3">
                @php
                    $totalAllOrders = max(1, $stats['total_orders']);
                    $statusMap = [
                        'pending' => ['label' => 'Pending', 'color' => 'bg-yellow-400', 'text' => 'text-yellow-700'],
                        'processing' => ['label' => 'Processing', 'color' => 'bg-blue-500', 'text' => 'text-blue-700'],
                        'shipped' => ['label' => 'Dikirim', 'color' => 'bg-purple-500', 'text' => 'text-purple-700'],
                        'delivered' => [
                            'label' => 'Selesai',
                            'color' => 'bg-emerald-500',
                            'text' => 'text-emerald-700',
                        ],
                        'cancelled' => ['label' => 'Dibatalkan', 'color' => 'bg-red-400', 'text' => 'text-red-700'],
                    ];
                @endphp
                @foreach ($statusMap as $status => $cfg)
                    @php
                        $cnt = $orderStatusBreakdown[$status] ?? 0;
                        $spct = round(($cnt / $totalAllOrders) * 100);
                    @endphp
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs font-semibold text-gray-600">{{ $cfg['label'] }}</span>
                            <span class="text-xs font-bold {{ $cfg['text'] }}">{{ $cnt }}
                                ({{ $spct }}%)
                            </span>
                        </div>
                        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="{{ $cfg['color'] }} h-2 rounded-full transition-all"
                                style="width:{{ max(2, $spct) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Top categories by revenue --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-2.5">
                <div class="w-8 h-8 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-layer-group text-green-500 text-sm"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-sm">Kategori Terlaris</h3>
                    <p class="text-[10px] text-gray-400">Berdasarkan total penjualan</p>
                </div>
            </div>
            <div class="divide-y divide-gray-50">
                @php
                    $maxCatRev = max(1, $topCategories->max('revenue'));
                    $barColors = [
                        'from-blue-400 to-blue-600',
                        'from-green-400 to-green-600',
                        'from-purple-400 to-purple-600',
                        'from-orange-400 to-orange-600',
                        'from-pink-400 to-pink-600',
                    ];
                @endphp
                @forelse($topCategories as $i => $cat)
                    <div class="px-5 py-3">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-sm font-semibold text-gray-700 truncate">{{ $cat['name'] }}</span>
                            <span class="text-xs font-bold text-gray-800 flex-shrink-0 ml-2">{{ $cat['sold'] }}
                                buku</span>
                        </div>
                        @php $cpct = round(($cat['revenue'] / $maxCatRev) * 100); @endphp
                        <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-1.5 rounded-full bg-gradient-to-r {{ $barColors[$i % 5] }}"
                                style="width:{{ max(4, $cpct) }}%"></div>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1">Rp {{ number_format($cat['revenue'], 0, ',', '.') }}</p>
                    </div>
                @empty
                    <div class="py-10 text-center text-gray-400 text-sm">Belum ada data kategori</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ══════════════════════════ ROW 4: Recent orders + Low stock ══════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">

        {{-- Recent Orders (wider) --}}
        <div class="lg:col-span-3 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-receipt text-blue-600 text-sm"></i>
                    </div>
                    <h2 class="font-bold text-gray-800">Pesanan Terbaru</h2>
                </div>
                <a href="{{ route('admin.orders.index') }}"
                    class="text-xs font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                    Lihat Semua <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            {{-- Table header (desktop only) --}}
            <div
                class="hidden sm:grid grid-cols-12 px-6 py-2.5 bg-gray-50 border-b border-gray-100 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                <span class="col-span-4">Customer</span>
                <span class="col-span-3">No. Pesanan</span>
                <span class="col-span-2">Waktu</span>
                <span class="col-span-2 text-right">Total</span>
                <span class="col-span-1 text-right">Status</span>
            </div>

            <div class="flex-1 divide-y divide-gray-50">
                @forelse ($recent_orders as $order)
                    <a href="{{ route('admin.orders.show', $order) }}"
                        class="grid grid-cols-12 items-center px-6 py-3.5 hover:bg-blue-50/40 transition-colors group">
                        <div class="col-span-7 sm:col-span-4 flex items-center gap-3 min-w-0">
                            <div
                                class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center flex-shrink-0 shadow-sm">
                                <span
                                    class="text-white text-xs font-bold">{{ strtoupper(substr($order->user->name ?? '?', 0, 1)) }}</span>
                            </div>
                            <div class="min-w-0">
                                <p
                                    class="text-sm font-semibold text-gray-900 truncate group-hover:text-blue-700 transition-colors">
                                    {{ $order->user->name }}</p>
                                <p class="text-xs text-gray-400 truncate sm:hidden">#{{ $order->order_number }}</p>
                            </div>
                        </div>
                        <div class="hidden sm:block col-span-3">
                            <p class="text-xs font-mono text-gray-600 truncate">#{{ $order->order_number }}</p>
                        </div>
                        <div class="hidden sm:block col-span-2">
                            <p class="text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="col-span-5 sm:col-span-2 text-right">
                            <p class="text-sm font-bold text-gray-800">Rp
                                {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        </div>
                        <div class="hidden sm:flex col-span-1 justify-end">
                            <span
                                class="inline-block text-[10px] px-2 py-0.5 rounded-full font-semibold
                                @if ($order->status === 'pending') bg-yellow-100 text-yellow-700
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-700
                                @elseif($order->status === 'shipped') bg-purple-100 text-purple-700
                                @elseif($order->status === 'delivered') bg-green-100 text-green-700
                                @else bg-red-100 text-red-700 @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="px-6 py-12 text-center text-gray-400">
                        <i class="fas fa-inbox text-4xl mb-3 block text-gray-300"></i>
                        <p class="text-sm">Belum ada pesanan</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Low Stock Books (narrower) --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-orange-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-orange-500 text-sm"></i>
                    </div>
                    <h2 class="font-bold text-gray-800">Stok Rendah</h2>
                </div>
                <a href="{{ route('admin.books.index') }}"
                    class="text-xs font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                    Lihat Semua <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>
            <div class="flex-1 divide-y divide-gray-50">
                @forelse ($low_stock_books as $book)
                    <a href="{{ route('admin.books.edit', $book) }}"
                        class="flex items-center gap-3 px-5 py-3.5 hover:bg-orange-50/50 transition-colors group">
                        <div
                            class="w-10 h-14 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden flex items-center justify-center">
                            @if ($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}"
                                    class="w-full h-full object-cover" alt="">
                            @else
                                <i class="fas fa-book text-gray-300 text-sm"></i>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p
                                class="text-sm font-semibold text-gray-900 truncate group-hover:text-orange-600 transition-colors">
                                {{ $book->title }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $book->author }}</p>
                        </div>
                        <span
                            class="flex-shrink-0 text-xs font-bold px-2.5 py-1 rounded-full {{ $book->stock == 0 ? 'bg-red-100 text-red-600' : 'bg-orange-100 text-orange-600' }}">
                            {{ $book->stock == 0 ? 'Habis' : $book->stock . ' item' }}
                        </span>
                    </a>
                @empty
                    <div class="px-6 py-12 text-center text-gray-400">
                        <i class="fas fa-check-circle text-4xl mb-3 block text-green-300"></i>
                        <p class="text-sm">Semua stok aman</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
@endsection
