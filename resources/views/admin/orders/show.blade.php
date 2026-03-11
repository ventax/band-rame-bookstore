@extends('admin.layouts.app')

@section('title', 'Detail Pesanan #' . $order->order_number . ' - Admin Panel')
@section('page-title', 'Detail Pesanan')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pesanan
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg flex items-center gap-2">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded-lg flex items-center gap-2">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT: Order Info --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Order Header --}}
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div
                    class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4 text-white flex justify-between items-start flex-wrap gap-3">
                    <div>
                        <h2 class="text-xl font-bold">Order #{{ $order->order_number }}</h2>
                        <p class="text-blue-100 text-sm">{{ $order->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    <span
                        class="px-3 py-1.5 rounded-full text-sm font-semibold
                        @if ($order->status === 'pending') bg-yellow-400 text-yellow-900
                        @elseif($order->status === 'processing') bg-blue-300 text-blue-900
                        @elseif($order->status === 'shipped') bg-purple-400 text-purple-900
                        @elseif($order->status === 'delivered') bg-green-400 text-green-900
                        @else bg-red-500 text-white @endif">
                        @if ($order->status === 'pending')
                            <i class="fas fa-clock mr-1"></i> Pending
                        @elseif($order->status === 'processing')
                            <i class="fas fa-cog mr-1"></i> Diproses
                        @elseif($order->status === 'shipped')
                            <i class="fas fa-truck mr-1"></i> Dikirim
                        @elseif($order->status === 'delivered')
                            <i class="fas fa-check-circle mr-1"></i> Selesai
                        @else
                            <i class="fas fa-times-circle mr-1"></i> Dibatalkan
                        @endif
                    </span>
                </div>

                {{-- Customer Info --}}
                <div class="p-6 border-b">
                    <h3 class="font-semibold text-gray-700 mb-3">Informasi Pelanggan</h3>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user text-blue-500"></i>
                        </div>
                        <div>
                            <p class="font-semibold">{{ $order->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
                        </div>
                    </div>
                </div>

                {{-- Order Items --}}
                <div class="p-6 border-b">
                    <h3 class="font-semibold text-gray-700 mb-4">Item Pesanan</h3>
                    <div class="space-y-4">
                        @foreach ($order->items as $item)
                            <div class="flex gap-4">
                                <div class="w-14 h-20 flex-shrink-0">
                                    @if ($item->book->cover_image)
                                        <img src="{{ asset('storage/' . $item->book->cover_image) }}"
                                            alt="{{ $item->book->title }}" class="w-full h-full object-cover rounded">
                                    @else
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center rounded">
                                            <i class="fas fa-book text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-sm">{{ $item->book->title }}</p>
                                    <p class="text-xs text-gray-500 mb-1">{{ $item->book->author }}</p>
                                    <p class="text-sm text-gray-600">{{ $item->quantity }} x Rp
                                        {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-right font-bold text-blue-600 text-sm">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 pt-4 border-t flex justify-between font-bold text-lg">
                        <span>Total</span>
                        <span class="text-blue-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Shipping Address --}}
                <div class="p-6">
                    <h3 class="font-semibold text-gray-700 mb-3">Alamat Pengiriman</h3>
                    <div class="bg-gray-50 rounded-lg p-4 text-sm">
                        <p class="font-semibold">{{ $order->shipping_name }}</p>
                        <p class="text-gray-600">{{ $order->shipping_phone }}</p>
                        <p class="text-gray-600 mt-1">{{ $order->shipping_address }}</p>
                        <p class="text-gray-600">{{ $order->shipping_city }}, {{ $order->shipping_postal_code }}</p>
                        @if ($order->notes)
                            <div class="mt-2 pt-2 border-t">
                                <span class="text-gray-500">Catatan: </span>{{ $order->notes }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Payment Info --}}
            @if ($order->payment)
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-gray-700 mb-4">Informasi Pembayaran</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Metode</p>
                            <p class="font-semibold capitalize">
                                {{ str_replace('_', ' ', $order->payment->payment_method) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Status</p>
                            <span
                                class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                                @if ($order->payment->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->payment->status === 'success') bg-green-100 text-green-800
                                @elseif($order->payment->status === 'failed') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-700 @endif">
                                {{ ucfirst($order->payment->status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-gray-500">Jumlah Dibayar</p>
                            <p class="font-semibold text-blue-600">Rp
                                {{ number_format($order->payment->amount, 0, ',', '.') }}</p>
                        </div>
                        @if ($order->payment->paid_at)
                            <div>
                                <p class="text-gray-500">Tanggal Bayar</p>
                                <p class="font-semibold">{{ $order->payment->paid_at->format('d M Y, H:i') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>

        {{-- RIGHT: Actions --}}
        <div class="space-y-6">

            {{-- Update Status --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-semibold text-gray-700 mb-4">
                    <i class="fas fa-edit mr-2 text-blue-500"></i>Update Status Pesanan
                </h3>

                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label class="block text-sm text-gray-600 mb-1">Status Saat Ini</label>
                        <div class="w-full px-3 py-2 bg-gray-100 rounded-lg text-sm font-semibold text-gray-700">
                            @if ($order->status === 'pending')
                                ⏳ Menunggu Pembayaran
                            @elseif($order->status === 'processing')
                                ⚙️ Sedang Diproses
                            @elseif($order->status === 'shipped')
                                🚚 Dalam Pengiriman
                            @elseif($order->status === 'delivered')
                                ✅ Selesai / Diterima
                            @else
                                ❌ Dibatalkan
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-600 mb-1">Ubah ke Status</label>
                        <select name="status" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="">-- Pilih Status Baru --</option>
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>
                                ⏳ Pending (Menunggu Bayar)
                            </option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>
                                ⚙️ Processing (Sedang Diproses)
                            </option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>
                                🚚 Shipped (Dikirim)
                            </option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }} disabled>
                                ✅ Delivered (dikonfirmasi oleh pelanggan)
                            </option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>
                                ❌ Cancelled (Dibatalkan)
                            </option>
                        </select>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </form>

                <div class="mt-4 pt-4 border-t space-y-2 text-xs text-gray-500">
                    <p class="font-semibold text-gray-600 text-sm mb-2">Panduan Status:</p>
                    <p>⏳ <strong>Pending</strong> — Menunggu konfirmasi pembayaran</p>
                    <p>⚙️ <strong>Processing</strong> — Pembayaran diterima, pesanan sedang dikemas</p>
                    <p>🚚 <strong>Shipped</strong> — Pesanan sudah dikirim ke kurir</p>
                    <p>✅ <strong>Delivered</strong> — Pesanan sudah diterima pelanggan</p>
                    <p>❌ <strong>Cancelled</strong> — Pesanan dibatalkan (stok otomatis dikembalikan)</p>
                </div>
            </div>

            {{-- Order Timeline Summary --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-semibold text-gray-700 mb-4">
                    <i class="fas fa-history mr-2 text-gray-400"></i>Timeline
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-file-alt text-blue-500 text-xs"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Pesanan Dibuat</p>
                            <p class="text-gray-400">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    @if ($order->payment?->paid_at)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-credit-card text-green-500 text-xs"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-700">Pembayaran Diterima</p>
                                <p class="text-gray-400">{{ $order->payment->paid_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($order->shipped_at)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-truck text-purple-500 text-xs"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-700">Pesanan Dikirim</p>
                                <p class="text-gray-400">{{ $order->shipped_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($order->delivered_at)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500 text-xs"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-700">Pesanan Diterima</p>
                                <p class="text-gray-400">{{ $order->delivered_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
