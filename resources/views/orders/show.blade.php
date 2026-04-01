@extends('layouts.app')

@section('title', 'Detail Pesanan - ATigaBookStore')

@section('content')
    <div class="bg-gray-100 py-4 sm:py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-4 sm:mb-5">
                <a href="{{ route('orders.index') }}" class="text-primary-600 hover:text-primary-700">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Pesanan
                </a>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <!-- Order Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-4 sm:px-6 py-4 sm:py-5 text-white">
                    <div class="flex flex-wrap justify-between items-start gap-3">
                        <div>
                            <h1 class="text-lg sm:text-xl md:text-2xl font-bold mb-1">Order #{{ $order->order_number }}</h1>
                            <p class="text-blue-100 text-sm">{{ $order->created_at->format('d F Y, H:i') }}</p>
                        </div>
                        @if ($order->status === 'cancelled')
                            <span class="px-3 py-1.5 rounded-full text-sm font-semibold bg-red-600 text-white shadow">
                                <i class="fas fa-times-circle mr-1"></i> Dibatalkan
                            </span>
                        @else
                            <span
                                class="px-3 py-1.5 rounded-full text-sm font-semibold
                                w-full sm:w-auto text-center
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
                    $waNumberRaw = setting('store_whatsapp', '');
                    $waNumber = preg_replace('/\D+/', '', (string) $waNumberRaw);
                    if ($waNumber && str_starts_with($waNumber, '0')) {
                        $waNumber = '62' . substr($waNumber, 1);
                    }

                    $orderDetailUrl = route('orders.show', $order->order_number);
                    $confirmText =
                        "Halo Admin ATigaBookStore, saya sudah menyelesaikan pembayaran.\n\n" .
                        "Nomor Pesanan: {$order->order_number}\n" .
                        'Total Pembayaran: Rp ' .
                        number_format($order->grand_total, 0, ',', '.') .
                        "\n" .
                        "Nama Penerima: {$order->shipping_name}\n\n" .
                        "Saya melampirkan:\n" .
                        "1. Bukti pesanan (screenshot detail pesanan)\n" .
                        "2. Bukti pembayaran (screenshot/struk pembayaran)\n\n" .
                        "Link detail pesanan: {$orderDetailUrl}\n\n" .
                        'Terima kasih.';
                    $waConfirmUrl = $waNumber
                        ? 'https://wa.me/' . $waNumber . '?text=' . urlencode($confirmText)
                        : null;
                @endphp

                @if (!$isCancelled)
                    <!-- Order Status Tracker -->
                    <div class="px-4 sm:px-6 py-5 sm:py-6 border-b bg-gray-50">
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
                    <div class="px-4 sm:px-6 py-4 border-b bg-red-50">
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
                        <div class="px-4 sm:px-6 py-5 border-b bg-violet-50">
                            <div class="flex items-center gap-2 mb-4">
                                <div
                                    class="w-8 h-8 rounded-full bg-violet-100 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-truck-fast text-violet-600 text-sm"></i>
                                </div>
                                <p class="font-semibold text-violet-800 text-sm">Info Pengiriman</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
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

                <div class="p-4 sm:p-5 md:p-7">

                    <div class="mb-6 bg-white border border-gray-200 rounded-xl p-4 sm:p-5 shadow-sm">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Ringkasan Cepat</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                            <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5">
                                <p class="text-[11px] text-gray-500 uppercase tracking-wide">Status</p>
                                <p class="text-sm font-semibold text-gray-900 mt-0.5">{{ ucfirst($order->status) }}</p>
                            </div>
                            <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5">
                                <p class="text-[11px] text-gray-500 uppercase tracking-wide">Total</p>
                                <p class="text-sm font-bold text-primary-600 mt-0.5">Rp
                                    {{ number_format($order->grand_total, 0, ',', '.') }}</p>
                            </div>
                            <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5">
                                <p class="text-[11px] text-gray-500 uppercase tracking-wide">Pembayaran</p>
                                <p class="text-sm font-semibold text-gray-900 mt-0.5">
                                    {{ $order->payment ? ucfirst($order->payment->status) : 'Belum ada data' }}</p>
                            </div>
                            <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5">
                                <p class="text-[11px] text-gray-500 uppercase tracking-wide">Item</p>
                                <p class="text-sm font-semibold text-gray-900 mt-0.5">{{ $order->items->count() }} produk
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- WhatsApp Confirmation -->
                    <div class="mb-6 sm:mb-8 bg-blue-50 border border-blue-100 rounded-xl p-3 sm:p-4">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-3">
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                    <i class="fab fa-whatsapp text-green-600"></i>
                                </div>
                                <div>
                                    <h2 class="font-bold text-sm sm:text-base text-gray-900">Konfirmasi via WhatsApp</h2>
                                    <p class="text-xs sm:text-sm text-gray-600">Wajib konfirmasi ke WA admin setelah
                                        pembayaran agar pesanan cepat diverifikasi.</p>
                                </div>
                            </div>

                            @if ($order->whatsapp_confirmed_at)
                                <span
                                    class="inline-flex items-center justify-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200 w-full sm:w-auto">
                                    <i class="fas fa-check-circle"></i>
                                    Sudah dikonfirmasi
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center justify-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 border border-amber-200 w-full sm:w-auto">
                                    <i class="fas fa-exclamation-circle"></i>
                                    Wajib Konfirmasi ke WA
                                </span>
                            @endif
                        </div>

                        <div class="bg-white rounded-lg border border-blue-100 p-3 mb-3">
                            <p class="text-xs sm:text-sm font-semibold text-gray-800 mb-2">Wajib konfirmasi ke WA dengan
                                lampiran berikut:</p>
                            <ul class="space-y-1 text-xs sm:text-sm text-gray-700">
                                <li><i class="fas fa-check-circle text-blue-600 mr-2"></i>Bukti pesanan (screenshot halaman
                                    ini)</li>
                                <li><i class="fas fa-check-circle text-blue-600 mr-2"></i>Bukti pembayaran (screenshot /
                                    struk transaksi)</li>
                            </ul>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                            @if ($waConfirmUrl)
                                <a href="{{ $waConfirmUrl }}" target="_blank" rel="noopener noreferrer"
                                    class="w-full h-11 sm:h-12 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold text-[13px] sm:text-sm px-3 rounded-lg transition-all leading-none">
                                    <i class="fab fa-whatsapp text-xs sm:text-sm"></i>
                                    <span>Kirim Konfirmasi WA</span>
                                </a>
                            @else
                                <button type="button" disabled
                                    class="w-full h-11 sm:h-12 inline-flex items-center justify-center gap-2 bg-gray-300 text-white font-semibold text-[13px] sm:text-sm px-3 rounded-lg cursor-not-allowed leading-none">
                                    <i class="fab fa-whatsapp text-xs sm:text-sm"></i>
                                    <span>Nomor WA toko belum diatur</span>
                                </button>
                            @endif

                            @if ($order->whatsapp_confirmed_at)
                                <button type="button" disabled
                                    class="w-full h-11 sm:h-12 inline-flex items-center justify-center gap-2 bg-green-100 text-green-700 border border-green-200 font-semibold text-[13px] sm:text-sm px-3 rounded-lg cursor-not-allowed leading-none">
                                    <i class="fas fa-check-circle text-xs sm:text-sm"></i>
                                    <span>Sudah Konfirmasi WA</span>
                                </button>
                            @else
                                <form id="wa-confirm-form"
                                    action="{{ route('orders.confirm-whatsapp', $order->order_number) }}" method="POST"
                                    class="w-full">
                                    @csrf
                                    <button type="button"
                                        class="w-full h-11 sm:h-12 inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-[13px] sm:text-sm px-3 rounded-lg transition-all leading-none"
                                        onclick="openWaConfirmModal()">
                                        <i class="fas fa-check-double text-xs sm:text-sm"></i>
                                        <span>Saya Sudah Konfirmasi WA</span>
                                    </button>
                                </form>
                            @endif
                        </div>

                        <textarea id="wa-message-template-order" class="sr-only">{{ $confirmText }}</textarea>
                        <button type="button" onclick="copyWaTemplateOrder()"
                            class="w-full text-xs sm:text-sm bg-white border border-gray-300 hover:border-blue-300 hover:bg-blue-50 text-gray-700 font-semibold py-2 rounded-lg transition-all">
                            <i class="fas fa-copy mr-1"></i>Salin Template Pesan WA
                        </button>

                        @if ($order->whatsapp_confirmed_at)
                            <p class="text-xs text-green-700 mt-3">
                                Dikonfirmasi pada {{ $order->whatsapp_confirmed_at->format('d M Y, H:i') }}.
                            </p>
                        @endif

                        @if (!$order->whatsapp_confirmed_at)
                            <div id="wa-confirm-modal" class="hidden fixed inset-0 z-[1200]">
                                <div class="absolute inset-0 bg-slate-900/55 backdrop-blur-sm"
                                    onclick="closeWaConfirmModal()"></div>
                                <div class="absolute inset-0 flex items-center justify-center p-2 sm:p-4">
                                    <div
                                        class="w-full max-w-[320px] sm:max-w-sm mx-auto bg-white rounded-2xl shadow-2xl border border-blue-100 overflow-hidden max-h-[78vh] sm:max-h-[82vh] overflow-y-auto">
                                        <div
                                            class="px-3 py-2.5 border-b border-blue-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                                            <p
                                                class="font-bold text-gray-900 text-[13px] sm:text-sm flex items-center gap-2">
                                                <span
                                                    class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 inline-flex items-center justify-center">
                                                    <i class="fas fa-check-double text-xs"></i>
                                                </span>
                                                Konfirmasi via WhatsApp
                                            </p>
                                        </div>
                                        <div class="px-3 py-2.5">
                                            <p class="text-xs sm:text-[13px] text-gray-700 leading-relaxed">
                                                Tandai bahwa Anda sudah mengirim konfirmasi pesanan ke WhatsApp admin?
                                            </p>
                                            <p class="text-[11px] text-gray-500 mt-1 leading-relaxed">
                                                Setelah ini status konfirmasi WhatsApp akan disimpan pada pesanan.
                                            </p>
                                        </div>
                                        <div class="px-3 pb-3 pt-1 flex flex-col sm:flex-row gap-2 sm:justify-end">
                                            <button type="button" id="wa-confirm-cancel-btn"
                                                onclick="closeWaConfirmModal()"
                                                class="w-full sm:w-auto inline-flex justify-center items-center px-3 py-1.5 rounded-lg border border-gray-300 text-gray-700 text-[13px] font-semibold hover:bg-gray-50 transition-colors">
                                                Batal
                                            </button>
                                            <button type="button" id="wa-confirm-submit-btn"
                                                onclick="submitWaConfirmForm()"
                                                class="w-full sm:w-auto inline-flex justify-center items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-[13px] font-semibold transition-colors shadow">
                                                <i class="fas fa-check text-xs"></i>
                                                Ya, Saya Sudah Konfirmasi
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-7">
                        <div class="lg:col-span-2">
                            <!-- Order Items -->
                            <div class="mb-6 lg:mb-0">
                                <details class="group bg-white border border-gray-200 rounded-xl" open>
                                    <summary
                                        class="list-none flex items-center justify-between cursor-pointer px-4 py-3 border-b border-gray-100">
                                        <h2 class="font-semibold text-lg">Item Pesanan</h2>
                                        <span
                                            class="text-xs text-gray-500 inline-flex items-center gap-2 group-open:text-blue-600">
                                            <span>{{ $order->items->count() }} item</span>
                                            <i class="fas fa-chevron-down transition-transform group-open:rotate-180"></i>
                                        </span>
                                    </summary>

                                    <div class="p-4">
                                        <div class="space-y-3 lg:max-h-[62vh] lg:overflow-y-auto lg:pr-2">
                                            @foreach ($order->items as $item)
                                                <div class="flex gap-3 sm:gap-4 pb-3 border-b items-start">
                                                    <div class="w-16 h-24 sm:w-20 sm:h-28 flex-shrink-0">
                                                        @if ($item->book->cover_image)
                                                            <a href="{{ route('books.show', $item->book->slug) }}"
                                                                class="block rounded overflow-hidden hover:opacity-90 transition-opacity"
                                                                title="Lihat detail buku {{ $item->book->title }}">
                                                                <img src="{{ asset('storage/' . $item->book->cover_image) }}"
                                                                    alt="{{ $item->book->title }}"
                                                                    class="w-full h-full object-cover rounded">
                                                            </a>
                                                        @else
                                                            <div
                                                                class="w-full h-full bg-gray-300 flex items-center justify-center rounded">
                                                                <i class="fas fa-book text-gray-500 text-2xl"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="flex-1">
                                                        <a href="{{ route('books.show', $item->book->slug) }}"
                                                            class="font-semibold mb-1 text-sm sm:text-base leading-snug text-gray-900 hover:text-primary-600 transition-colors block"
                                                            title="Lihat detail buku {{ $item->book->title }}">
                                                            {{ $item->book->title }}
                                                        </a>
                                                        <p class="text-sm text-gray-600 mb-1">{{ $item->book->author }}
                                                        </p>
                                                        <p class="text-sm text-gray-600">Jumlah: {{ $item->quantity }}</p>
                                                        <p class="text-sm text-gray-600">Harga: Rp
                                                            {{ number_format($item->price, 0, ',', '.') }}</p>
                                                    </div>
                                                    <div class="text-right self-start">
                                                        <p class="font-bold text-primary-600 text-sm sm:text-base">Rp
                                                            {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="mt-4 pt-4 border-t flex justify-between items-center gap-3">
                                            <span class="font-semibold text-base sm:text-lg">Total</span>
                                            <span class="font-bold text-xl sm:text-2xl text-primary-600 text-right">Rp
                                                {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </details>
                            </div>
                        </div>

                        <aside class="lg:col-span-1 space-y-5 self-start">
                            <!-- Actions -->
                            <div class="lg:sticky lg:top-24 bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                                <h2 class="font-semibold text-base sm:text-lg mb-3">Aksi Cepat</h2>
                                <div class="flex flex-col gap-2.5">
                                    @if ($order->payment && $order->payment->status === 'pending')
                                        <a href="{{ route('payment.show', $order->order_number) }}"
                                            class="btn-primary w-full text-center justify-center">
                                            <i class="fas fa-credit-card mr-2"></i> Bayar Sekarang
                                        </a>
                                    @endif

                                    @if ($order->status === 'shipped')
                                        <form action="{{ route('orders.confirm-received', $order->order_number) }}"
                                            method="POST"
                                            onsubmit="return confirm('Konfirmasi bahwa pesanan sudah Anda terima?')"
                                            class="w-full">
                                            @csrf
                                            <button type="submit"
                                                class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors shadow">
                                                <i class="fas fa-check-circle"></i> Pesanan Sudah Diterima
                                            </button>
                                        </form>
                                    @endif

                                    @if ($order->canBeCancelled())
                                        <form action="{{ route('orders.cancel', $order->order_number) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')"
                                            class="w-full">
                                            @csrf
                                            <button type="submit"
                                                class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-red-100 hover:bg-red-200 text-red-700 font-semibold rounded-lg transition-colors">
                                                <i class="fas fa-times"></i> Batalkan Pesanan
                                            </button>
                                        </form>
                                    @endif

                                    <a href="{{ route('books.index') }}"
                                        class="btn-secondary w-full text-center justify-center">
                                        <i class="fas fa-shopping-bag mr-2"></i> Belanja Lagi
                                    </a>
                                </div>
                            </div>

                            <!-- Shipping Information -->
                            <details class="group bg-white border border-gray-200 rounded-xl" open>
                                <summary class="list-none flex items-center justify-between cursor-pointer px-4 py-3">
                                    <h2 class="font-semibold text-base sm:text-lg">Informasi Pengiriman</h2>
                                    <i
                                        class="fas fa-chevron-down text-xs text-gray-500 transition-transform group-open:rotate-180"></i>
                                </summary>
                                <div class="px-4 pb-4">
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
                            </details>

                            <!-- Payment Information -->
                            @if ($order->payment)
                                <details class="group bg-white border border-gray-200 rounded-xl">
                                    <summary class="list-none flex items-center justify-between cursor-pointer px-4 py-3">
                                        <h2 class="font-semibold text-base sm:text-lg">Informasi Pembayaran</h2>
                                        <i
                                            class="fas fa-chevron-down text-xs text-gray-500 transition-transform group-open:rotate-180"></i>
                                    </summary>
                                    <div class="px-4 pb-4">
                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <div class="space-y-3">
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
                                                        <p class="font-semibold">
                                                            {{ $order->payment->paid_at->format('d F Y, H:i') }}
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </details>
                            @endif
                        </aside>
                    </div>
                </div>{{-- /p-6 md:p-8 --}}
            </div>
        </div>
    </div>

    <script>
        function openWaConfirmModal() {
            const modal = document.getElementById('wa-confirm-modal');
            if (!modal) return;
            modal.removeAttribute('x-cloak');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeWaConfirmModal() {
            const modal = document.getElementById('wa-confirm-modal');
            if (!modal) return;
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        function submitWaConfirmForm() {
            const form = document.getElementById('wa-confirm-form');
            if (!form) return;

            const submitBtn = document.getElementById('wa-confirm-submit-btn');
            const cancelBtn = document.getElementById('wa-confirm-cancel-btn');

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-70', 'cursor-not-allowed');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin text-xs"></i> Memproses...';
            }

            if (cancelBtn) {
                cancelBtn.disabled = true;
                cancelBtn.classList.add('opacity-70', 'cursor-not-allowed');
            }

            form.submit();
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeWaConfirmModal();
            }
        });

        function copyWaTemplateOrder() {
            const text = document.getElementById('wa-message-template-order')?.value || '';
            if (!text) return;

            navigator.clipboard.writeText(text)
                .then(() => {
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: {
                            type: 'success',
                            message: 'Template pesan WhatsApp berhasil disalin.'
                        }
                    }));
                })
                .catch(() => {
                    alert('Gagal menyalin template. Silakan coba lagi.');
                });
        }
    </script>
@endsection
