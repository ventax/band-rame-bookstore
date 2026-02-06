@extends('layouts.app')

@section('title', 'Checkout - BandRame')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Shipping Information -->
                    <div class="md:col-span-2">
                        <div class="bg-white rounded-lg shadow p-6 mb-6">
                            <h2 class="text-xl font-semibold mb-6">Informasi Pengiriman</h2>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-gray-700 font-medium mb-2">Nama Lengkap <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="shipping_name"
                                        value="{{ old('shipping_name', Auth::user()->name) }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    @error('shipping_name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-gray-700 font-medium mb-2">Email <span
                                            class="text-red-500">*</span></label>
                                    <input type="email" name="shipping_email"
                                        value="{{ old('shipping_email', Auth::user()->email) }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    @error('shipping_email')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-gray-700 font-medium mb-2">Nomor Telepon <span
                                            class="text-red-500">*</span></label>
                                    <input type="tel" name="shipping_phone" value="{{ old('shipping_phone') }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    @error('shipping_phone')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-gray-700 font-medium mb-2">Alamat Lengkap <span
                                            class="text-red-500">*</span></label>
                                    <textarea name="shipping_address" rows="3" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ old('shipping_address') }}</textarea>
                                    @error('shipping_address')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-gray-700 font-medium mb-2">Kota <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="shipping_city" value="{{ old('shipping_city') }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    @error('shipping_city')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-gray-700 font-medium mb-2">Kode Pos <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="shipping_postal_code"
                                        value="{{ old('shipping_postal_code') }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    @error('shipping_postal_code')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-gray-700 font-medium mb-2">Catatan (Opsional)</label>
                                    <textarea name="notes" rows="3"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                        placeholder="Catatan untuk kurir atau penjual...">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-xl font-semibold mb-6">Item Pesanan</h2>

                            <div class="space-y-4">
                                @foreach ($cartItems as $item)
                                    <div class="flex gap-4 pb-4 border-b last:border-0">
                                        <div class="w-16 h-20 flex-shrink-0">
                                            @if ($item->book->cover_image)
                                                <img src="{{ asset('storage/' . $item->book->cover_image) }}"
                                                    alt="{{ $item->book->title }}"
                                                    class="w-full h-full object-cover rounded">
                                            @else
                                                <div
                                                    class="w-full h-full bg-gray-300 flex items-center justify-center rounded">
                                                    <i class="fas fa-book text-gray-500 text-xl"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="flex-1">
                                            <h3 class="font-semibold">{{ $item->book->title }}</h3>
                                            <p class="text-sm text-gray-600">{{ $item->book->author }}</p>
                                            <p class="text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
                                        </div>

                                        <div class="text-right">
                                            <p class="font-bold text-primary-600">Rp
                                                {{ number_format($item->quantity * $item->book->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="md:col-span-1">
                        <div class="bg-white rounded-lg shadow p-6 sticky top-24">
                            <h2 class="text-xl font-semibold mb-4">Ringkasan Pesanan</h2>

                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal ({{ $cartItems->sum('quantity') }} item)</span>
                                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Ongkos Kirim</span>
                                    <span class="text-green-600 font-semibold">GRATIS</span>
                                </div>
                                <div class="border-t pt-3 flex justify-between font-bold text-lg">
                                    <span>Total Pembayaran</span>
                                    <span class="text-primary-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <button type="submit" class="w-full btn-primary">
                                Proses Pesanan <i class="fas fa-arrow-right ml-2"></i>
                            </button>

                            <a href="{{ route('cart.index') }}"
                                class="block w-full text-center mt-3 text-gray-600 hover:text-primary-600">
                                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Keranjang
                            </a>

                            <div class="mt-6 pt-6 border-t">
                                <div class="flex items-center text-sm text-gray-600 mb-2">
                                    <i class="fas fa-shield-alt text-green-600 mr-2"></i>
                                    <span>Pembayaran Aman</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-lock text-green-600 mr-2"></i>
                                    <span>Data Terenkripsi</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
