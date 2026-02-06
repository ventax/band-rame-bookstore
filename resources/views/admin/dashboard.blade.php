@extends('admin.layouts.app')

@section('title', 'Dashboard - Admin Panel')
@section('page-title', 'Dashboard')

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold">Total Buku</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_books'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-book text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold">Total Kategori</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_categories'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tags text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold">Total Pesanan</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_orders'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold">Total Customer</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_users'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold">Pesanan Pending</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['pending_orders'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-red-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold">Total Revenue</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-2">Rp
                        {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Pesanan Terbaru</h2>
                    <a href="{{ route('admin.orders.index') }}" class="text-primary-600 text-sm hover:text-primary-700">
                        Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if ($recent_orders->count() > 0)
                    <div class="space-y-4">
                        @foreach ($recent_orders as $order)
                            <div class="flex items-center justify-between pb-4 border-b last:border-0">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">#{{ $order->order_number }}</p>
                                    <p class="text-sm text-gray-600">{{ $order->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-primary-600">Rp
                                        {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                    <span
                                        class="text-xs px-2 py-1 rounded-full
                                @if ($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                                @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">Belum ada pesanan</p>
                @endif
            </div>
        </div>

        <!-- Low Stock Books -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Stok Rendah</h2>
                    <a href="{{ route('admin.books.index') }}" class="text-primary-600 text-sm hover:text-primary-700">
                        Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if ($low_stock_books->count() > 0)
                    <div class="space-y-4">
                        @foreach ($low_stock_books as $book)
                            <div class="flex items-center justify-between pb-4 border-b last:border-0">
                                <div class="flex items-center space-x-3 flex-1">
                                    <div
                                        class="w-12 h-16 bg-gray-200 rounded flex-shrink-0 flex items-center justify-center">
                                        <i class="fas fa-book text-gray-400"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-gray-900 truncate">{{ $book->title }}</p>
                                        <p class="text-sm text-gray-600">{{ $book->author }}</p>
                                    </div>
                                </div>
                                <div class="text-right ml-4">
                                    <span
                                        class="text-sm font-bold {{ $book->stock == 0 ? 'text-red-600' : 'text-orange-600' }}">
                                        {{ $book->stock == 0 ? 'Habis' : $book->stock . ' item' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">Semua buku stok aman</p>
                @endif
            </div>
        </div>
    </div>
@endsection
