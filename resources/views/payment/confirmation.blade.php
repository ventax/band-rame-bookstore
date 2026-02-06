@extends('layouts.app')

@section('title', 'Konfirmasi Pembayaran - BandRame')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <!-- Success Icon -->
                <div class="inline-block bg-green-100 rounded-full p-6 mb-6">
                    <i class="fas fa-check-circle text-green-600 text-6xl"></i>
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-2">Pesanan Berhasil Dibuat!</h1>
                <p class="text-gray-600 mb-8">Terima kasih telah berbelanja di BandRame</p>

                <!-- Order Details -->
                <div class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
                    <div class="grid md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Nomor Pesanan</p>
                            <p class="font-bold text-lg">{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Pembayaran</p>
                            <p class="font-bold text-lg text-primary-600">Rp
                                {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Metode Pembayaran</p>
                            <p class="font-semibold capitalize">
                                {{ str_replace('_', ' ', $order->payment->payment_method ?? 'Manual') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Status</p>
                            <span class="inline-block bg-yellow-100 text-yellow-800 text-sm px-3 py-1 rounded-full">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <h3 class="font-semibold mb-3">Item Pesanan:</h3>
                        <div class="space-y-2">
                            @foreach ($order->items as $item)
                                <div class="flex justify-between text-sm">
                                    <span>{{ $item->book->title }} (x{{ $item->quantity }})</span>
                                    <span class="font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="border-t mt-4 pt-4">
                        <h3 class="font-semibold mb-3">Alamat Pengiriman:</h3>
                        <p class="text-sm text-gray-700">{{ $order->shipping_name }}</p>
                        <p class="text-sm text-gray-700">{{ $order->shipping_phone }}</p>
                        <p class="text-sm text-gray-700">{{ $order->shipping_address }}</p>
                        <p class="text-sm text-gray-700">{{ $order->shipping_city }}, {{ $order->shipping_postal_code }}
                        </p>
                    </div>
                </div>

                <!-- Payment Instructions -->
                @if ($order->payment && $order->payment->status === 'pending')
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8 text-left">
                        <h3 class="font-semibold text-lg mb-3 flex items-center">
                            <i class="fas fa-info-circle text-yellow-600 mr-2"></i>
                            Instruksi Pembayaran
                        </h3>
                        <div class="text-sm text-gray-700 space-y-2">
                            <p><strong>Metode:</strong>
                                {{ ucfirst(str_replace('_', ' ', $order->payment->payment_method)) }}</p>
                            <p><strong>Jumlah:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>

                            @if ($order->payment->payment_method === 'bank_transfer')
                                <div class="mt-4">
                                    <p class="font-semibold mb-2">Transfer ke salah satu rekening:</p>
                                    <div class="space-y-2">
                                        <div class="bg-white p-3 rounded">
                                            <p class="font-semibold">Bank BCA</p>
                                            <p>1234567890 a.n. BookStore Indonesia</p>
                                        </div>
                                        <div class="bg-white p-3 rounded">
                                            <p class="font-semibold">Bank Mandiri</p>
                                            <p>0987654321 a.n. BookStore Indonesia</p>
                                        </div>
                                    </div>
                                </div>
                            @elseif($order->payment->payment_method === 'e_wallet')
                                <p class="mt-4">Silakan lakukan pembayaran melalui aplikasi e-wallet pilihan Anda dengan
                                    nominal <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></p>
                            @endif

                            <p class="mt-4 text-red-600">⚠️ Segera lakukan pembayaran dalam 24 jam untuk menghindari
                                pembatalan otomatis.</p>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('orders.show', $order->order_number) }}" class="btn-primary">
                        <i class="fas fa-receipt mr-2"></i> Lihat Detail Pesanan
                    </a>
                    <a href="{{ route('books.index') }}" class="btn-secondary">
                        <i class="fas fa-shopping-bag mr-2"></i> Lanjut Belanja
                    </a>
                </div>

                <div class="mt-8 pt-8 border-t">
                    <p class="text-sm text-gray-600">
                        <i class="fas fa-envelope mr-2"></i>
                        Konfirmasi pesanan telah dikirim ke email <strong>{{ $order->shipping_email }}</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
