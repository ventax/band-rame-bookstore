@extends('layouts.app')

@section('title', 'Pesanan Berhasil Dibuat!')

@section('content')
    <div class="bg-gray-100 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Icon -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full mb-4 animate-bounce">
                    <i class="fas fa-check-circle text-green-600 text-5xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Pesanan Berhasil Dibuat!</h1>
                <p class="text-gray-600">Terima kasih telah berbelanja di BandRame</p>
            </div>

            <!-- Order Information -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="border-b border-gray-200 pb-4 mb-4">
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Detail Pesanan</h2>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Nomor Pesanan</p>
                            <p class="text-2xl font-bold text-purple-600">{{ $order->order_number }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-600 text-sm">Total Pembayaran</p>
                            <p class="text-2xl font-bold text-gray-900">Rp
                                {{ number_format($order->grand_total, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Payment Instructions -->
                @if ($order->payment_method === 'transfer_bank')
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-bold text-yellow-800 mb-2">Menunggu Pembayaran</h3>
                                <p class="text-sm text-yellow-700 mb-3">Silakan transfer ke rekening berikut:</p>
                                <div class="bg-white p-3 rounded text-sm">
                                    <p class="font-semibold text-gray-700 mb-2">Pilih salah satu:</p>
                                    <div class="space-y-2">
                                        <div>
                                            <p class="font-bold text-gray-900">Bank BCA</p>
                                            <p class="text-gray-600">1234567890 a.n. BandRame Store</p>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">Bank Mandiri</p>
                                            <p class="text-gray-600">0987654321 a.n. BandRame Store</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 pt-3 border-t border-gray-200">
                                        <p class="font-semibold text-gray-700">Jumlah Transfer:</p>
                                        <p class="text-xl font-bold text-purple-600">Rp
                                            {{ number_format($order->grand_total, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <p class="text-xs text-yellow-700 mt-3">
                                    <i class="fas fa-info-circle mr-1"></i>Upload bukti transfer melalui halaman detail
                                    pesanan setelah pembayaran berhasil
                                </p>
                            </div>
                        </div>
                    </div>
                @elseif($order->payment_method === 'cod')
                    <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-bold text-green-800 mb-1">Pembayaran Cash on Delivery (COD)</h3>
                                <p class="text-sm text-green-700">Pesanan Anda akan segera diproses. Bayar saat barang
                                    diterima.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Order Items -->
                <div class="mt-4">
                    <h3 class="font-bold text-gray-900 mb-3">Item Pesanan ({{ $order->items->count() }})</h3>
                    <div class="space-y-3">
                        @foreach ($order->items as $item)
                            <div class="flex gap-4 p-3 bg-gray-50 rounded">
                                @if ($item->book->image)
                                    <img src="{{ asset('storage/' . $item->book->image) }}" alt="{{ $item->book->title }}"
                                        class="w-16 h-20 object-cover rounded">
                                @else
                                    <div class="w-16 h-20 bg-gray-200 rounded flex items-center justify-center">
                                        <i class="fas fa-book text-gray-400"></i>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">{{ $item->book->title }}</p>
                                    <p class="text-sm text-gray-600">{{ $item->book->author }}</p>
                                    <p class="text-sm text-gray-600 mt-1">{{ $item->quantity }}x Rp
                                        {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="font-bold text-gray-900 mb-2">
                        <i class="fas fa-map-marker-alt text-purple-600 mr-2"></i>Alamat Pengiriman
                    </h3>
                    <div class="bg-gray-50 p-4 rounded">
                        <p class="font-bold text-gray-900">{{ $order->shipping_name }}</p>
                        <p class="text-gray-600 text-sm">{{ $order->shipping_phone }}</p>
                        <p class="text-gray-600 text-sm mt-1">{{ $order->shipping_address }}</p>
                        <p class="text-gray-600 text-sm">{{ $order->shipping_city }}, {{ $order->shipping_province }}
                            {{ $order->shipping_postal_code }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('orders.show', $order->order_number) }}"
                    class="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-3 px-6 rounded-lg text-center transition-all">
                    <i class="fas fa-file-invoice mr-2"></i>Lihat Detail Pesanan
                </a>
                <a href="{{ route('home') }}"
                    class="flex-1 bg-white border-2 border-purple-600 text-purple-600 hover:bg-purple-50 font-bold py-3 px-6 rounded-lg text-center transition-all">
                    <i class="fas fa-home mr-2"></i>Kembali ke Beranda
                </a>
            </div>

            <!-- What's Next -->
            <div class="mt-6 text-center text-gray-600 text-sm">
                <p class="mb-2">
                    <i class="fas fa-info-circle text-purple-600 mr-1"></i>
                    Status pesanan dapat dilihat di halaman
                    <a href="{{ route('orders.index') }}" class="text-purple-600 hover:underline font-semibold">Pesanan
                        Saya</a>
                </p>
            </div>
        </div>
    </div>
@endsection
