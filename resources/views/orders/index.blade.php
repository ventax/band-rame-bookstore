@extends('layouts.app')

@section('title', 'Pesanan Saya - BandRame')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Pesanan Saya</h1>

            @if ($orders->count() > 0)
                <div class="space-y-4">
                    @foreach ($orders as $order)
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="font-semibold text-lg mb-1">Order #{{ $order->order_number }}</h3>
                                    <p class="text-sm text-gray-600">{{ $order->created_at->format('d F Y, H:i') }}</p>
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

                            <div class="border-t border-b py-4 mb-4">
                                <div class="space-y-2">
                                    @foreach ($order->items as $item)
                                        <div class="flex gap-3">
                                            <div class="w-12 h-16 flex-shrink-0">
                                                @if ($item->book->cover_image)
                                                    <img src="{{ asset('storage/' . $item->book->cover_image) }}"
                                                        alt="{{ $item->book->title }}"
                                                        class="w-full h-full object-cover rounded">
                                                @else
                                                    <div
                                                        class="w-full h-full bg-gray-300 flex items-center justify-center rounded">
                                                        <i class="fas fa-book text-gray-500"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-semibold text-sm">{{ $item->book->title }}</p>
                                                <p class="text-xs text-gray-600">{{ $item->quantity }} x Rp
                                                    {{ number_format($item->price, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-gray-600 text-sm">Total Pembayaran</p>
                                    <p class="font-bold text-xl text-primary-600">Rp
                                        {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                </div>
                                <a href="{{ route('orders.show', $order->order_number) }}" class="btn-primary">
                                    Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <i class="fas fa-box-open text-gray-400 text-6xl mb-4"></i>
                    <h2 class="text-2xl font-semibold text-gray-700 mb-2">Belum Ada Pesanan</h2>
                    <p class="text-gray-500 mb-6">Anda belum melakukan pemesanan</p>
                    <a href="{{ route('books.index') }}" class="inline-block btn-primary">
                        <i class="fas fa-book mr-2"></i> Mulai Belanja
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
