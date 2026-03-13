@extends('layouts.app')

@section('title', 'Detail Pesanan - ATigaBookStore')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('orders.index') }}" class="text-primary-600 hover:text-primary-700">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Pesanan
                </a>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <!-- Order Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-5 text-white">
                    <div class="flex flex-wrap justify-between items-start gap-3">
                        <div>
                            <h1 class="text-xl md:text-2xl font-bold mb-1">Order #{{ $order->order_number }}</h1>
                            <p class="text-blue-100 text-sm">{{ $order->created_at->format('d F Y, H:i') }}</p>
                        </div>
                        @if ($order->status === 'cancelled')
                            <span class="px-3 py-1.5 rounded-full text-sm font-semibold bg-red-600 text-white shadow">
                                <i class="fas fa-times-circle mr-1"></i> Dibatalkan
                            </span>
                        @else
                            <span
                                class="px-3 py-1.5 rounded-full text-sm font-semibold
                                @if ($order->status === 'pending') bg-yellow-400/30 border border-yellow-300 text-yellow-100
                                @elseif($order->status === 'processing') bg-blue-400/30 border border-blue-300 text-blue-100
                                @elseif($order->status === 'shipped') bg-purple-400/30 border border-purple-300 text-purple-100
                                @elseif($order->status === 'delivered') bg-green-400/30 border border-green-300 text-green-100 @endif">
                                @if ($order->status === 'pending')
                                    <i class="fas fa-clock mr-1"></i> Menunggu Pembayaran
                                @elseif($order->status === 'processing')
                                    <i class="fas fa-cog mr-1"></i> Diproses
                                @elseif($order->status === 'shipped')
                                    <i class="fas fa-truck mr-1"></i> Dikirim
                                @elseif($order->status === 'delivered')
                                    <i class="fas fa-check-circle mr-1"></i> Selesai
                                @endif
                            </span>
                        @endif
                    </div>
                </div>

                @php
                    $statuses = ['pending', 'processing', 'shipped', 'delivered'];
                    $currentIndex = array_search($order->status, $statuses);
                    $isCancelled = $order->status === 'cancelled';
                @endphp

                @if (!$isCancelled)
                    <!-- Order Status Tracker -->
                    <div class="px-6 py-6 border-b bg-gray-50">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-4">Tracking Pesanan</p>

                        <!-- Desktop stepper -->
                        <div class="hidden sm:flex items-start">
                            @php
                                $steps = [
                                    [
                                        'key' => 'pending',
                                        'icon' => 'fa-file-alt',
                                        'label' => 'Pesanan Dibuat',
                                        'time' => $order->created_at,
                                    ],
                                    [
                                        'key' => 'processing',
                                        'icon' => 'fa-box',
                                        'label' => 'Sedang Diproses',
                                        'time' => $order->payment?->paid_at,
                                    ],
                                    [
                                        'key' => 'shipped',
                                        'icon' => 'fa-truck',
                                        'label' => 'Dalam Pengiriman',
                                        'time' => $order->shipped_at,
                                    ],
                                    [
                                        'key' => 'delivered',
                                        'icon' => 'fa-check-circle',
                                        'label' => 'Pesanan Diterima',
                                        'time' => $order->delivered_at,
                                    ],
                                ];
                            @endphp

                            @foreach ($steps as $i => $step)
                                @php
                                    $stepIndex = $i;
                                    $isDone = $currentIndex !== false && $stepIndex <= $currentIndex;
                                    $isActive = $currentIndex !== false && $stepIndex === $currentIndex;
                                @endphp
                                <div class="flex-1 flex flex-col items-center relative">
                                    <!-- Connector left -->
                                    @if ($i > 0)
                                        <div
                                            class="absolute top-5 right-1/2 w-full h-0.5 -translate-y-1/2
                                        {{ $isDone ? 'bg-blue-500' : 'bg-gray-300' }}">
                                        </div>
                                    @endif

                                    <!-- Circle -->
                                    <div
                                        class="relative z-10 w-10 h-10 rounded-full flex items-center justify-center mb-2 transition-all
                                    {{ $isActive ? 'bg-blue-600 ring-4 ring-blue-100 shadow-lg' : ($isDone ? 'bg-blue-500' : 'bg-gray-200') }}">
                                        <i
                                            class="fas {{ $step['icon'] }} text-sm {{ $isDone ? 'text-white' : 'text-gray-400' }}"></i>
                                    </div>

                                    <p
                                        class="text-xs font-semibold text-center {{ $isActive ? 'text-blue-700' : ($isDone ? 'text-gray-700' : 'text-gray-400') }}">
                                        {{ $step['label'] }}
                                    </p>
                                    @if ($step['time'])
                                        <p class="text-xs text-gray-400 text-center mt-0.5">
                                            {{ \Carbon\Carbon::parse($step['time'])->format('d M, H:i') }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Mobile timeline (vertical) -->
                        <div class="sm:hidden space-y-0">
                            @foreach ($steps as $i => $step)
                                @php
                                    $stepIndex = $i;
                                    $isDone = $currentIndex !== false && $stepIndex <= $currentIndex;
                                    $isActive = $currentIndex !== false && $stepIndex === $currentIndex;
                                    $isLast = $i === count($steps) - 1;
                                @endphp
                                <div class="flex gap-3">
                                    <!-- Left: circle + line -->
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0
                                        {{ $isActive ? 'bg-blue-600 ring-4 ring-blue-100' : ($isDone ? 'bg-blue-500' : 'bg-gray-200') }}">
                                            <i
                                                class="fas {{ $step['icon'] }} text-xs {{ $isDone ? 'text-white' : 'text-gray-400' }}"></i>
                                        </div>
                                        @if (!$isLast)
                                            <div class="w-0.5 flex-1 my-1 {{ $stepIndex < $currentIndex ? 'bg-blue-400' : 'bg-gray-200' }}"
                                                style="min-height: 24px;"></div>
                                        @endif
                                    </div>
                                    <!-- Right: text -->
                                    <div class="pb-4">
                                        <p
                                            class="text-sm font-semibold {{ $isActive ? 'text-blue-700' : ($isDone ? 'text-gray-700' : 'text-gray-400') }}">
                                            {{ $step['label'] }}
                                        </p>
                                        @if ($step['time'])
                                            <p class="text-xs text-gray-400">
                                                {{ \Carbon\Carbon::parse($step['time'])->format('d M Y, H:i') }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <!-- Cancelled Banner -->
                    <div class="px-6 py-4 border-b bg-red-50">
                        <div class="flex items-center gap-3 text-red-700">
                            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-times-circle text-red-500"></i>
                            </div>
                            <div>
                                <p class="font-semibold">Pesanan Dibatalkan</p>
                                <p class="text-sm text-red-500">Pesanan ini telah dibatalkan dan tidak dapat diproses lebih
                                    lanjut.</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- === BUKTI PENGIRIMAN === --}}
                @if ($order->status === 'shipped' || $order->status === 'delivered')
                    @if ($order->tracking_number || $order->shipping_proof)
                        <div class="px-6 py-5 border-b bg-violet-50">
                            <div class="flex items-center gap-2 mb-4">
                                <div
                                    class="w-8 h-8 rounded-full bg-violet-100 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-truck-fast text-violet-600 text-sm"></i>
                                </div>
                                <p class="font-semibold text-violet-800 text-sm">Info Pengiriman</p>
                            </div>

                            <div class="grid grid-cols-2 gap-3 mb-3">
                                @if ($order->courier_name)
                                    <div class="bg-white rounded-xl p-3 border border-violet-100">
                                        <p class="text-xs text-gray-400 mb-0.5">Ekspedisi</p>
                                        <p class="text-sm font-bold text-gray-800">{{ strtoupper($order->courier_name) }}
                                        </p>
                                    </div>
                                @endif
                                @if ($order->tracking_number)
                                    <div
                                        class="bg-white rounded-xl p-3 border border-violet-100 col-span-{{ $order->courier_name ? '1' : '2' }}">
                                        <p class="text-xs text-gray-400 mb-0.5">Nomor Resi</p>
                                        <div class="flex items-center gap-2">
                                            <p class="text-sm font-bold text-gray-800 font-mono tracking-wide">
                                                {{ $order->tracking_number }}</p>
                                            <button
                                                onclick="navigator.clipboard.writeText('{{ $order->tracking_number }}').then(() => { this.innerHTML='<i class=\'fas fa-check text-green-500\'></i>'; setTimeout(() => this.innerHTML='<i class=\'fas fa-copy\'></i>', 1500) })"
                                                class="text-gray-400 hover:text-violet-600 transition-colors flex-shrink-0"
                                                title="Salin resi">
                                                <i class="fas fa-copy text-xs"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @if ($order->shipping_proof)
                                <div class="mt-3">
                                    <p class="text-xs text-gray-500 font-semibold mb-2">Foto Bukti Pengiriman</p>
                                    <a href="{{ asset('storage/' . $order->shipping_proof) }}" target="_blank"
                                        class="block">
                                        <img src="{{ asset('storage/' . $order->shipping_proof) }}"
                                            class="rounded-xl border border-violet-200 max-h-52 object-contain w-full bg-white"
                                            alt="Bukti Pengiriman">
                                        <p class="text-xs text-violet-600 mt-1.5 text-center"><i
                                                class="fas fa-expand-alt mr-1"></i>Klik untuk lihat ukuran penuh</p>
                                    </a>
                                </div>
                            @endif

                            <p class="text-xs text-gray-500 mt-3 flex items-center gap-1.5">
                                <i class="fas fa-circle-info text-violet-400"></i>
                                Gunakan nomor resi di atas untuk melacak paket Anda di website ekspedisi.
                            </p>
                        </div>
                    @endif
                @endif

                <div class="p-6 md:p-8">

                    <!-- Order Items -->
                    <div class="mb-8">
                        <h2 class="font-semibold text-lg mb-4">Item Pesanan</h2>
                        <div class="space-y-4">
                            @foreach ($order->items as $item)
                                <div class="flex gap-4 pb-4 border-b">
                                    <div class="w-20 h-28 flex-shrink-0">
                                        @if ($item->book->cover_image)
                                            <img src="{{ asset('storage/' . $item->book->cover_image) }}"
                                                alt="{{ $item->book->title }}" class="w-full h-full object-cover rounded">
                                        @else
                                            <div class="w-full h-full bg-gray-300 flex items-center justify-center rounded">
                                                <i class="fas fa-book text-gray-500 text-2xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold mb-1">{{ $item->book->title }}</h3>
                                        <p class="text-sm text-gray-600 mb-2">{{ $item->book->author }}</p>
                                        <p class="text-sm text-gray-600">Jumlah: {{ $item->quantity }}</p>
                                        <p class="text-sm text-gray-600">Harga: Rp
                                            {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-primary-600">Rp
                                            {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4 pt-4 border-t flex justify-between items-center">
                            <span class="font-semibold text-lg">Total</span>
                            <span class="font-bold text-2xl text-primary-600">Rp
                                {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="mb-8">
                        <h2 class="font-semibold text-lg mb-4">Informasi Pengiriman</h2>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="font-semibold mb-1">{{ $order->shipping_name }}</p>
                            <p class="text-sm text-gray-700">{{ $order->shipping_phone }}</p>
                            <p class="text-sm text-gray-700">{{ $order->shipping_email }}</p>
                            <p class="text-sm text-gray-700 mt-2">{{ $order->shipping_address }}</p>
                            <p class="text-sm text-gray-700">{{ $order->shipping_city }},
                                {{ $order->shipping_postal_code }}
                            </p>
                            @if ($order->notes)
                                <div class="mt-3 pt-3 border-t">
                                    <p class="text-sm text-gray-600">Catatan:</p>
                                    <p class="text-sm text-gray-700">{{ $order->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Information -->
                    @if ($order->payment)
                        <div class="mb-8">
                            <h2 class="font-semibold text-lg mb-4">Informasi Pembayaran</h2>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Metode Pembayaran</p>
                                        <p class="font-semibold capitalize">
                                            {{ str_replace('_', ' ', $order->payment->payment_method) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Status Pembayaran</p>
                                        <span
                                            class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                @if ($order->payment->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->payment->status === 'success') bg-green-100 text-green-800
                                @elseif($order->payment->status === 'failed') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($order->payment->status) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Jumlah</p>
                                        <p class="font-bold text-primary-600">Rp
                                            {{ number_format($order->payment->amount, 0, ',', '.') }}</p>
                                    </div>
                                    @if ($order->payment->paid_at)
                                        <div>
                                            <p class="text-sm text-gray-600">Tanggal Pembayaran</p>
                                            <p class="font-semibold">{{ $order->payment->paid_at->format('d F Y, H:i') }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex flex-wrap gap-3">

                        @if ($order->payment && $order->payment->status === 'pending')
                            <a href="{{ route('payment.show', $order->order_number) }}" class="btn-primary">
                                <i class="fas fa-credit-card mr-2"></i> Bayar Sekarang
                            </a>
                        @endif

                        @if ($order->status === 'shipped')
                            <form action="{{ route('orders.confirm-received', $order->order_number) }}" method="POST"
                                onsubmit="return confirm('Konfirmasi bahwa pesanan sudah Anda terima?')">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors shadow">
                                    <i class="fas fa-check-circle"></i> Pesanan Sudah Diterima
                                </button>
                            </form>
                        @endif

                        @if ($order->canBeCancelled())
                            <form action="{{ route('orders.cancel', $order->order_number) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-100 hover:bg-red-200 text-red-700 font-semibold rounded-lg transition-colors">
                                    <i class="fas fa-times"></i> Batalkan Pesanan
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('books.index') }}" class="btn-secondary">
                            <i class="fas fa-shopping-bag mr-2"></i> Belanja Lagi
                        </a>
                    </div>
                </div>{{-- /p-6 md:p-8 --}}
            </div>
        </div>
    </div>
@endsection
