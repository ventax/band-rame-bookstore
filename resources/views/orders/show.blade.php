@extends('layouts.app')

@section('title', 'Detail Pesanan - BandRame')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('orders.index') }}" class="text-primary-600 hover:text-primary-700">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Pesanan
                </a>
            </div>

            <div class="bg-white rounded-lg shadow p-8">
                <!-- Order Header -->
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">Order #{{ $order->order_number }}</h1>
                        <p class="text-gray-600">Tanggal: {{ $order->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    <span
                        class="px-4 py-2 rounded-full text-sm font-semibold
                    @if ($order->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                    @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                    @elseif($order->status === 'delivered') bg-green-100 text-green-800
                    @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

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
                        <p class="text-sm text-gray-700">{{ $order->shipping_city }}, {{ $order->shipping_postal_code }}
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
                                        <p class="font-semibold">{{ $order->payment->paid_at->format('d F Y, H:i') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="flex gap-4">
                    @if ($order->payment && $order->payment->status === 'pending')
                        <a href="{{ route('payment.show', $order->order_number) }}" class="btn-primary">
                            <i class="fas fa-credit-card mr-2"></i> Bayar Sekarang
                        </a>
                    @endif
                    <a href="{{ route('books.index') }}" class="btn-secondary">
                        <i class="fas fa-shopping-bag mr-2"></i> Belanja Lagi
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
