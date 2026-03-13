@extends('admin.layouts.app')

@section('title', 'Detail Pesanan #' . $order->order_number . ' - Admin Panel')
@section('page-title', 'Detail Pesanan')

@section('content')
    {{-- Back link --}}
    <div class="mb-5">
        <a href="{{ route('admin.orders.index') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-blue-600 transition-colors">
            <i class="fas fa-arrow-left text-xs"></i> Kembali ke Daftar Pesanan
        </a>
    </div>

    {{-- Flash messages --}}
    @if (session('success'))
        <div
            class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 rounded-2xl px-4 py-3.5 text-sm font-medium shadow-sm mb-5">
            <i class="fas fa-circle-check text-green-500 flex-shrink-0"></i> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div
            class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 rounded-2xl px-4 py-3.5 text-sm font-medium shadow-sm mb-5">
            <i class="fas fa-circle-exclamation text-red-500 flex-shrink-0"></i> {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- ── LEFT: Order Detail ─────────────────── --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Order Header Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div
                    class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-5 text-white flex flex-wrap justify-between items-start gap-3">
                    <div>
                        <p class="text-blue-200 text-xs font-semibold uppercase tracking-wider mb-1">Nomor Pesanan</p>
                        <h2 class="text-xl font-black">{{ $order->order_number }}</h2>
                        <p class="text-blue-200 text-xs mt-1">{{ $order->created_at->format('d F Y, H:i') }} WIB</p>
                    </div>
                    @php
                        $statusConfig = [
                            'pending' => [
                                'bg' => 'bg-yellow-400',
                                'text' => 'text-yellow-900',
                                'icon' => 'fa-clock',
                                'label' => 'Pending',
                            ],
                            'processing' => [
                                'bg' => 'bg-cyan-300',
                                'text' => 'text-cyan-900',
                                'icon' => 'fa-cog',
                                'label' => 'Diproses',
                            ],
                            'shipped' => [
                                'bg' => 'bg-violet-400',
                                'text' => 'text-violet-900',
                                'icon' => 'fa-truck',
                                'label' => 'Dikirim',
                            ],
                            'delivered' => [
                                'bg' => 'bg-emerald-400',
                                'text' => 'text-emerald-900',
                                'icon' => 'fa-circle-check',
                                'label' => 'Selesai',
                            ],
                            'cancelled' => [
                                'bg' => 'bg-red-500',
                                'text' => 'text-white',
                                'icon' => 'fa-times-circle',
                                'label' => 'Dibatalkan',
                            ],
                        ];
                        $sc = $statusConfig[$order->status] ?? $statusConfig['pending'];
                    @endphp
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold {{ $sc['bg'] }} {{ $sc['text'] }}">
                        <i class="fas {{ $sc['icon'] }}"></i> {{ $sc['label'] }}
                    </span>
                </div>

                {{-- Customer --}}
                <div class="px-6 py-4 border-b border-gray-100">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Pelanggan</p>
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center flex-shrink-0 shadow-sm">
                            <span
                                class="text-white font-bold text-sm">{{ strtoupper(substr($order->user->name, 0, 1)) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">{{ $order->user->name }}</p>
                            <p class="text-xs text-gray-400">{{ $order->user->email }}</p>
                        </div>
                    </div>
                </div>

                {{-- Items --}}
                <div class="px-6 py-4 border-b border-gray-100">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Item Pesanan</p>
                    <div class="space-y-3">
                        @foreach ($order->items as $item)
                            <div class="flex gap-3 items-start">
                                <div
                                    class="w-12 h-16 flex-shrink-0 rounded-xl overflow-hidden bg-gray-100 border border-gray-200">
                                    @if ($item->book->cover_image)
                                        <img src="{{ asset('storage/' . $item->book->cover_image) }}"
                                            alt="{{ $item->book->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fas fa-book text-gray-300"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 leading-snug">{{ $item->book->title }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $item->book->author }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $item->quantity }} × Rp
                                        {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="text-sm font-bold text-blue-600">Rp
                                        {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100 space-y-1.5">
                        <div class="flex justify-between text-sm text-gray-500">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                        @if (isset($order->shipping_cost) && $order->shipping_cost > 0)
                            <div class="flex justify-between text-sm text-gray-500">
                                <span>Ongkos Kirim</span>
                                <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-base font-bold text-gray-800 pt-1.5 border-t border-gray-100">
                            <span>Total Pembayaran</span>
                            <span class="text-blue-600">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Shipping Address --}}
                <div class="px-6 py-4">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Alamat Pengiriman</p>
                    <div class="bg-gray-50 rounded-xl p-4 text-sm border border-gray-100">
                        <p class="font-bold text-gray-800">{{ $order->shipping_name }}</p>
                        <p class="text-gray-500 text-xs mt-0.5">{{ $order->shipping_phone }}</p>
                        <p class="text-gray-600 mt-2">{{ $order->shipping_address }}</p>
                        <p class="text-gray-600">{{ $order->shipping_city }}, {{ $order->shipping_postal_code }}</p>
                        @if ($order->notes)
                            <div class="mt-3 pt-3 border-t border-gray-200 flex gap-2">
                                <i class="fas fa-sticky-note text-gray-400 text-xs mt-0.5 flex-shrink-0"></i>
                                <p class="text-xs text-gray-500 italic">{{ $order->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Bukti Pengiriman (jika sudah dikirim) --}}
            @if ($order->tracking_number || $order->shipping_proof)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                        <div class="w-9 h-9 bg-violet-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-truck-fast text-violet-600 text-sm"></i>
                        </div>
                        <h3 class="text-base font-bold text-gray-800">Bukti Pengiriman</h3>
                    </div>
                    <div class="p-6 grid grid-cols-2 gap-4">
                        @if ($order->courier_name)
                            <div class="bg-gray-50 rounded-xl p-3">
                                <p class="text-xs text-gray-400 font-semibold mb-1">Ekspedisi</p>
                                <p class="text-sm font-bold text-gray-800">{{ strtoupper($order->courier_name) }}</p>
                            </div>
                        @endif
                        @if ($order->tracking_number)
                            <div class="bg-gray-50 rounded-xl p-3">
                                <p class="text-xs text-gray-400 font-semibold mb-1">Nomor Resi</p>
                                <p class="text-sm font-bold text-gray-800 font-mono tracking-wide">
                                    {{ $order->tracking_number }}</p>
                            </div>
                        @endif
                        @if ($order->shipping_proof)
                            <div class="col-span-2">
                                <p class="text-xs text-gray-400 font-semibold mb-2">Foto Bukti Pengiriman</p>
                                <a href="{{ asset('storage/' . $order->shipping_proof) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $order->shipping_proof) }}"
                                        class="rounded-xl border border-gray-200 max-h-48 object-contain w-full bg-gray-50"
                                        alt="Bukti Pengiriman">
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Payment Info --}}
            @if ($order->payment)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                        <div class="w-9 h-9 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-credit-card text-emerald-600 text-sm"></i>
                        </div>
                        <h3 class="text-base font-bold text-gray-800">Informasi Pembayaran</h3>
                    </div>
                    <div class="p-6 grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div class="bg-gray-50 rounded-xl p-3">
                            <p class="text-xs text-gray-400 font-semibold mb-1">Metode</p>
                            <p class="text-sm font-bold text-gray-800 capitalize">
                                {{ str_replace('_', ' ', $order->payment->payment_method) }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-3">
                            <p class="text-xs text-gray-400 font-semibold mb-1">Status</p>
                            @php
                                $payStatus = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'success' => 'bg-green-100 text-green-800',
                                    'failed' => 'bg-red-100 text-red-800',
                                ];
                                $psc = $payStatus[$order->payment->status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $psc }}">
                                {{ ucfirst($order->payment->status) }}
                            </span>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-3">
                            <p class="text-xs text-gray-400 font-semibold mb-1">Jumlah</p>
                            <p class="text-sm font-bold text-blue-600">Rp
                                {{ number_format($order->payment->amount, 0, ',', '.') }}</p>
                        </div>
                        @if ($order->payment->paid_at)
                            <div class="bg-gray-50 rounded-xl p-3">
                                <p class="text-xs text-gray-400 font-semibold mb-1">Tgl Bayar</p>
                                <p class="text-sm font-bold text-gray-800">{{ $order->payment->paid_at->format('d M Y') }}
                                </p>
                                <p class="text-xs text-gray-400">{{ $order->payment->paid_at->format('H:i') }} WIB</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        {{-- ── RIGHT: Actions ──────────────────────── --}}
        <div class="space-y-5">

            {{-- Update Status --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-edit text-blue-600 text-sm"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-800">Update Status</h3>
                </div>
                <div class="p-5">
                    {{-- Current status --}}
                    <div class="mb-4">
                        <p class="text-xs font-semibold text-gray-400 mb-1.5">Status Saat Ini</p>
                        <div
                            class="flex items-center gap-2 px-4 py-2.5 bg-gray-50 rounded-xl border border-gray-200 text-sm font-semibold text-gray-700">
                            <i class="fas {{ $sc['icon'] }} text-xs"></i>
                            @if ($order->status === 'pending')
                                Menunggu Pembayaran
                            @elseif($order->status === 'processing')
                                Sedang Diproses
                            @elseif($order->status === 'shipped')
                                Dalam Pengiriman
                            @elseif($order->status === 'delivered')
                                Selesai / Diterima
                            @else
                                Dibatalkan
                            @endif
                        </div>
                    </div>

                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST"
                        enctype="multipart/form-data" x-data="{ status: '{{ $order->status }}' }">
                        @csrf
                        @method('PATCH')
                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Ubah ke Status</label>
                            <select name="status" x-model="status" required
                                class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all bg-white">
                                <option value="">-- Pilih Status Baru --</option>
                                <option value="pending">⏳ Pending</option>
                                <option value="processing">⚙️ Processing</option>
                                <option value="shipped">🚚 Shipped</option>
                                <option value="delivered" disabled>✅ Delivered (oleh pelanggan)</option>
                                <option value="cancelled">❌ Cancelled</option>
                            </select>
                        </div>

                        {{-- Field bukti pengiriman — muncul saat pilih Shipped --}}
                        <div x-show="status === 'shipped'" x-transition
                            class="mb-4 p-4 bg-violet-50 border border-violet-200 rounded-xl space-y-3">
                            <p class="text-xs font-bold text-violet-700 flex items-center gap-1.5">
                                <i class="fas fa-truck-fast"></i> Detail Pengiriman
                            </p>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Ekspedisi <span
                                        class="text-red-500">*</span></label>
                                <select name="courier_name"
                                    class="w-full px-3 py-2 border-2 border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:border-violet-500 focus:ring-2 focus:ring-violet-100 transition-all bg-white">
                                    <option value="">-- Pilih Ekspedisi --</option>
                                    @foreach (['JNE', 'J&T Express', 'SiCepat', 'Anteraja', 'Pos Indonesia', 'Tiki', 'Ninja Express', 'Lion Parcel', 'SAP Express', 'Lainnya'] as $courier)
                                        <option value="{{ $courier }}"
                                            {{ $order->courier_name === $courier ? 'selected' : '' }}>{{ $courier }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Nomor Resi <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="tracking_number"
                                    value="{{ old('tracking_number', $order->tracking_number) }}"
                                    placeholder="Contoh: JNE123456789ID"
                                    class="w-full px-3 py-2 border-2 border-gray-200 rounded-xl text-sm font-mono text-gray-800 focus:outline-none focus:border-violet-500 focus:ring-2 focus:ring-violet-100 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Foto Bukti Pengiriman <span
                                        class="text-gray-400">(opsional)</span></label>
                                <input type="file" name="shipping_proof" accept="image/*"
                                    class="block w-full text-sm text-gray-600 border-2 border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:border-violet-500 transition-all file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100">
                                <p class="text-xs text-gray-400 mt-1">JPG/PNG/WebP, maks 3MB</p>
                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="mb-3 p-3 bg-red-50 border border-red-200 rounded-xl text-xs text-red-600">
                                @foreach ($errors->all() as $e)
                                    <p>• {{ $e }}</p>
                                @endforeach
                            </div>
                        @endif

                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all shadow-sm hover:shadow-md">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </form>

                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-xs font-bold text-gray-500 mb-2">Panduan Status:</p>
                        <div class="space-y-2">
                            @foreach ([['⏳', 'Pending', 'Menunggu konfirmasi pembayaran'], ['⚙️', 'Processing', 'Pembayaran diterima, pesanan dikemas'], ['🚚', 'Shipped', 'Pesanan dikirim ke kurir'], ['✅', 'Delivered', 'Diterima pelanggan'], ['❌', 'Cancelled', 'Dibatalkan — stok dikembalikan']] as [$emoji, $label, $desc])
                                <div class="flex gap-2 text-xs text-gray-500">
                                    <span class="flex-shrink-0">{{ $emoji }}</span>
                                    <span><strong class="text-gray-700">{{ $label }}</strong> —
                                        {{ $desc }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Timeline --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-9 h-9 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-history text-gray-500 text-sm"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-800">Timeline</h3>
                </div>
                <div class="p-5">
                    <div
                        class="relative space-y-4 before:absolute before:left-4 before:top-2 before:bottom-2 before:w-px before:bg-gray-200">

                        <div class="flex items-start gap-3 relative">
                            <div
                                class="w-8 h-8 rounded-full bg-blue-100 border-2 border-white flex items-center justify-center flex-shrink-0 shadow-sm z-10">
                                <i class="fas fa-file-alt text-blue-500 text-xs"></i>
                            </div>
                            <div class="pt-0.5">
                                <p class="text-sm font-semibold text-gray-700">Pesanan Dibuat</p>
                                <p class="text-xs text-gray-400">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        @if ($order->payment?->paid_at)
                            <div class="flex items-start gap-3 relative">
                                <div
                                    class="w-8 h-8 rounded-full bg-emerald-100 border-2 border-white flex items-center justify-center flex-shrink-0 shadow-sm z-10">
                                    <i class="fas fa-credit-card text-emerald-500 text-xs"></i>
                                </div>
                                <div class="pt-0.5">
                                    <p class="text-sm font-semibold text-gray-700">Pembayaran Diterima</p>
                                    <p class="text-xs text-gray-400">{{ $order->payment->paid_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        @if ($order->shipped_at)
                            <div class="flex items-start gap-3 relative">
                                <div
                                    class="w-8 h-8 rounded-full bg-violet-100 border-2 border-white flex items-center justify-center flex-shrink-0 shadow-sm z-10">
                                    <i class="fas fa-truck text-violet-500 text-xs"></i>
                                </div>
                                <div class="pt-0.5">
                                    <p class="text-sm font-semibold text-gray-700">Pesanan Dikirim</p>
                                    <p class="text-xs text-gray-400">{{ $order->shipped_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        @endif

                        @if ($order->delivered_at)
                            <div class="flex items-start gap-3 relative">
                                <div
                                    class="w-8 h-8 rounded-full bg-emerald-100 border-2 border-white flex items-center justify-center flex-shrink-0 shadow-sm z-10">
                                    <i class="fas fa-circle-check text-emerald-500 text-xs"></i>
                                </div>
                                <div class="pt-0.5">
                                    <p class="text-sm font-semibold text-gray-700">Pesanan Diterima</p>
                                    <p class="text-xs text-gray-400">{{ $order->delivered_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
