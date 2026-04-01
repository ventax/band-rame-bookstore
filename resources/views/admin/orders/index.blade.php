@extends('admin.layouts.app')

@section('title', 'Kelola Pesanan - Admin Panel')
@section('page-title', 'Kelola Pesanan')

@section('content')
    @php
        $orderPageQuery = [
            'search' => request('search'),
            'status' => request('status'),
            'payment_status' => request('payment_status'),
        ];
        $orderCurrent = $orders->currentPage();
        $orderLast = $orders->lastPage();
        $orderStart = max(1, $orderCurrent - 2);
        $orderEnd = min($orderLast, $orderCurrent + 2);
        $orderPages = [];

        if ($orderStart > 1) {
            $orderPages[] = 1;
            if ($orderStart > 2) {
                $orderPages[] = '...';
            }
        }

        for ($i = $orderStart; $i <= $orderEnd; $i++) {
            $orderPages[] = $i;
        }

        if ($orderEnd < $orderLast) {
            if ($orderEnd < $orderLast - 1) {
                $orderPages[] = '...';
            }
            $orderPages[] = $orderLast;
        }
    @endphp

    {{-- Filter bar --}}
    <div class="mb-5">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1 sm:max-w-xs">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari no. pesanan / customer..."
                    class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white shadow-sm">
            </div>
            <select id="status-filter" name="status"
                class="w-full sm:w-44 px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white shadow-sm">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </form>
        <script>
            document.getElementById('status-filter').addEventListener('change', function() {
                const search = document.querySelector('input[name="search"]').value.trim();
                const status = this.value;
                const base = '{{ route('admin.orders.index') }}';
                const params = new URLSearchParams();
                if (search) params.set('search', search);
                if (status) params.set('status', status);
                const query = params.toString();
                window.location.href = base + (query ? '?' + query : '');
            });
        </script>
    </div>

    {{-- Status quick-filter pills --}}
    <div class="flex flex-wrap gap-2 mb-4">
        @php
            $pills = [
                '' => ['label' => 'Semua', 'color' => 'bg-gray-100 text-gray-600 hover:bg-gray-200'],
                'pending' => ['label' => 'Pending', 'color' => 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200'],
                'processing' => ['label' => 'Processing', 'color' => 'bg-blue-100 text-blue-700 hover:bg-blue-200'],
                'shipped' => ['label' => 'Dikirim', 'color' => 'bg-purple-100 text-purple-700 hover:bg-purple-200'],
                'delivered' => [
                    'label' => 'Selesai',
                    'color' => 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200',
                ],
                'cancelled' => ['label' => 'Dibatalkan', 'color' => 'bg-red-100 text-red-700 hover:bg-red-200'],
            ];
        @endphp
        @foreach ($pills as $val => $pill)
            @php
                $active = request('status', '') === $val;
                $url = $val ? route('admin.orders.index', ['status' => $val]) : route('admin.orders.index');
            @endphp
            <a href="{{ $url }}"
                class="px-3 py-1.5 rounded-full text-xs font-semibold transition-colors {{ $pill['color'] }} {{ $active ? 'ring-2 ring-offset-1 ring-current' : '' }}">
                {{ $pill['label'] }}
            </a>
        @endforeach
    </div>

    <p class="text-xs text-gray-500 mb-3 font-medium">
        Menampilkan <span class="font-bold text-gray-700">{{ $orders->total() }}</span> pesanan
    </p>

    {{-- Desktop Table --}}
    <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-3.5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider">No.
                        Pesanan</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider">Customer
                    </th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total
                    </th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider">Status
                    </th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider">Tanggal
                    </th>
                    <th class="px-6 py-3.5 text-right text-[11px] font-bold text-gray-400 uppercase tracking-wider">Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($orders as $order)
                    <tr class="hover:bg-blue-50/30 transition-colors group">
                        <td class="px-6 py-4">
                            <span class="text-xs font-mono font-semibold text-gray-700">#{{ $order->order_number }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center flex-shrink-0">
                                    <span
                                        class="text-white text-xs font-bold">{{ strtoupper(substr($order->user->name ?? '?', 0, 1)) }}</span>
                                </div>
                                <div class="min-w-0">
                                    <p
                                        class="text-sm font-semibold text-gray-800 truncate group-hover:text-blue-700 transition-colors">
                                        {{ $order->user->name ?? '-' }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ $order->user->email ?? '' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-bold text-gray-800">Rp
                                {{ number_format($order->grand_total, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-400">{{ $order->items->count() }} item</p>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-block px-2.5 py-1 text-xs font-semibold rounded-full
                                @if ($order->status === 'pending') bg-yellow-100 text-yellow-700
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-700
                                @elseif($order->status === 'shipped')    bg-purple-100 text-purple-700
                                @elseif($order->status === 'delivered')  bg-emerald-100 text-emerald-700
                                @else bg-red-100 text-red-700 @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $order->created_at->format('H:i') }}</p>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}"
                                class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <i class="fas fa-shopping-cart text-4xl text-gray-200 mb-3 block"></i>
                            <p class="text-gray-400 font-medium">Tidak ada pesanan ditemukan</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Mobile Card List --}}
    <div class="md:hidden space-y-3">
        @forelse($orders as $order)
            <a href="{{ route('admin.orders.show', $order) }}"
                class="block bg-white rounded-2xl shadow-sm border border-gray-100 p-4 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between gap-2 mb-3">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div
                            class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center flex-shrink-0">
                            <span
                                class="text-white text-xs font-bold">{{ strtoupper(substr($order->user->name ?? '?', 0, 1)) }}</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ $order->user->name ?? '-' }}</p>
                            <p class="text-xs text-gray-400 font-mono">#{{ $order->order_number }}</p>
                        </div>
                    </div>
                    <span
                        class="flex-shrink-0 inline-block px-2.5 py-1 text-xs font-semibold rounded-full
                        @if ($order->status === 'pending') bg-yellow-100 text-yellow-700
                        @elseif($order->status === 'processing') bg-blue-100 text-blue-700
                        @elseif($order->status === 'shipped')    bg-purple-100 text-purple-700
                        @elseif($order->status === 'delivered')  bg-emerald-100 text-emerald-700
                        @else bg-red-100 text-red-700 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="flex items-center justify-between pt-2.5 border-t border-gray-50">
                    <div>
                        <p class="text-base font-extrabold text-gray-800">Rp
                            {{ number_format($order->grand_total, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-400">{{ $order->items->count() }} item &bull;
                            {{ $order->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="flex items-center gap-1 text-blue-600 text-xs font-semibold">
                        Detail <i class="fas fa-chevron-right text-[10px]"></i>
                    </div>
                </div>
            </a>
        @empty
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <i class="fas fa-shopping-cart text-4xl text-gray-200 mb-3 block"></i>
                <p class="text-gray-400 font-medium">Tidak ada pesanan ditemukan</p>
            </div>
        @endforelse
    </div>

    @if ($orders->hasPages())
        <div class="mt-6">
            <p class="text-center text-xs text-gray-500 mb-2">Halaman {{ $orderCurrent }} dari {{ $orderLast }}</p>
            <div style="display:flex; justify-content:center;">
                <nav aria-label="Pagination"
                    style="display:inline-flex; align-items:center; gap:6px; flex-wrap:wrap; background:#fff; border:1px solid #dbeafe; border-radius:14px; padding:6px; box-shadow:0 6px 20px rgba(37,99,235,0.12);">
                    @if ($orders->onFirstPage())
                        <span
                            style="width:36px; height:36px; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#cbd5e1; background:#f8fafc; cursor:not-allowed;">
                            <i class="fas fa-chevron-left" style="font-size:12px;"></i>
                        </span>
                    @else
                        <a href="{{ $orders->appends($orderPageQuery)->previousPageUrl() }}"
                            style="width:36px; height:36px; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#2563eb; text-decoration:none; background:#eff6ff;">
                            <i class="fas fa-chevron-left" style="font-size:12px;"></i>
                        </a>
                    @endif

                    @foreach ($orderPages as $page)
                        @if ($page === '...')
                            <span
                                style="min-width:28px; height:36px; display:flex; align-items:center; justify-content:center; color:#94a3b8; font-weight:700;">...</span>
                        @elseif ($page == $orderCurrent)
                            <span
                                style="min-width:36px; height:36px; padding:0 10px; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#fff; font-weight:700; font-size:13px; background:linear-gradient(90deg,#2563eb,#1d4ed8);">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $orders->appends($orderPageQuery)->url($page) }}"
                                style="min-width:36px; height:36px; padding:0 10px; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#334155; font-weight:600; font-size:13px; text-decoration:none; background:#f8fafc;">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    @if ($orders->hasMorePages())
                        <a href="{{ $orders->appends($orderPageQuery)->nextPageUrl() }}"
                            style="width:36px; height:36px; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#2563eb; text-decoration:none; background:#eff6ff;">
                            <i class="fas fa-chevron-right" style="font-size:12px;"></i>
                        </a>
                    @else
                        <span
                            style="width:36px; height:36px; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#cbd5e1; background:#f8fafc; cursor:not-allowed;">
                            <i class="fas fa-chevron-right" style="font-size:12px;"></i>
                        </span>
                    @endif
                </nav>
            </div>
        </div>
    @endif
@endsection
