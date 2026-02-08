@extends('layouts.app')

@section('title', 'Alamat Pengiriman - Checkout')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex items-center justify-center">
                    <div class="flex items-center">
                        <div class="flex items-center text-purple-600 relative">
                            <div
                                class="rounded-full h-12 w-12 flex items-center justify-center bg-purple-600 text-white font-bold">
                                1
                            </div>
                            <div
                                class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-purple-600">
                                Alamat
                            </div>
                        </div>
                        <div class="flex-auto border-t-2 border-gray-300"></div>
                        <div class="flex items-center text-gray-400 relative">
                            <div
                                class="rounded-full h-12 w-12 flex items-center justify-center bg-gray-300 text-white font-bold">
                                2
                            </div>
                            <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase">
                                Pembayaran
                            </div>
                        </div>
                        <div class="flex-auto border-t-2 border-gray-300"></div>
                        <div class="flex items-center text-gray-400 relative">
                            <div
                                class="rounded-full h-12 w-12 flex items-center justify-center bg-gray-300 text-white font-bold">
                                3
                            </div>
                            <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase">
                                Selesai
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('checkout.payment') }}" method="POST" x-data="{ useExisting: {{ $defaultAddress ? 'true' : 'false' }} }">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Left: Address Selection -->
                    <div class="md:col-span-2">
                        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                                <i class="fas fa-map-marker-alt text-purple-600 mr-2"></i>Alamat Pengiriman
                            </h2>

                            @if ($addresses->count() > 0)
                                <!-- Use Saved Address -->
                                <div class="mb-6">
                                    <label class="flex items-center mb-4">
                                        <input type="radio" x-model="useExisting" value="true" class="mr-2">
                                        <span class="font-semibold">Gunakan Alamat Tersimpan</span>
                                    </label>

                                    <div x-show="useExisting" class="space-y-3">
                                        @foreach ($addresses as $address)
                                            <label class="block cursor-pointer">
                                                <div
                                                    class="border-2 rounded-lg p-4 transition-all {{ $address->is_default ? 'border-purple-600 bg-purple-50' : 'border-gray-200 hover:border-purple-300' }}">
                                                    <div class="flex items-start">
                                                        <input type="radio" name="address_id" value="{{ $address->id }}"
                                                            {{ $address->is_default ? 'checked' : '' }} class="mt-1 mr-3">
                                                        <div class="flex-1">
                                                            <div class="flex items-center gap-2 mb-2">
                                                                <span
                                                                    class="font-bold text-gray-900">{{ $address->label }}</span>
                                                                @if ($address->is_default)
                                                                    <span
                                                                        class="bg-purple-600 text-white text-xs px-2 py-0.5 rounded">Default</span>
                                                                @endif
                                                            </div>
                                                            <p class="text-gray-800 font-semibold">
                                                                {{ $address->recipient_name }}</p>
                                                            <p class="text-gray-600 text-sm">{{ $address->phone }}</p>
                                                            <p class="text-gray-600 text-sm mt-1">{{ $address->address }}
                                                            </p>
                                                            <p class="text-gray-600 text-sm">{{ $address->city }},
                                                                {{ $address->province }} {{ $address->postal_code }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        @endforeach

                                        <a href="{{ route('addresses.create') }}"
                                            class="inline-block text-purple-600 hover:text-purple-800 text-sm font-semibold mt-2">
                                            <i class="fas fa-plus mr-1"></i>Tambah Alamat Baru
                                        </a>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 my-6"></div>

                                <!-- Use New Address -->
                                <label class="flex items-center mb-4">
                                    <input type="radio" x-model="useExisting" value="false" class="mr-2">
                                    <span class="font-semibold">Gunakan Alamat Baru</span>
                                </label>
                            @else
                                <p class="text-gray-600 mb-4">Anda belum memiliki alamat tersimpan. Silakan isi form di
                                    bawah ini.</p>
                            @endif

                            <!-- New Address Form -->
                            <div x-show="!useExisting || {{ $addresses->count() === 0 ? 'true' : 'false' }}"
                                class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penerima *</label>
                                        <input type="text" name="recipient_name" value="{{ old('recipient_name') }}"
                                            required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                                        @error('recipient_name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon *</label>
                                        <input type="tel" name="phone" value="{{ old('phone') }}" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                                        @error('phone')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap *</label>
                                    <textarea name="address" rows="3" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">{{ old('address') }}</textarea>
                                    @error('address')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi *</label>
                                        <input type="text" name="province" value="{{ old('province') }}" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                                        @error('province')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Kota/Kabupaten *</label>
                                        <input type="text" name="city" value="{{ old('city') }}" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                                        @error('city')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos *</label>
                                    <input type="text" name="postal_code" value="{{ old('postal_code') }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                                    @error('postal_code')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Order Summary -->
                    <div class="md:col-span-1">
                        <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Pesanan</h3>

                            <div class="space-y-3 mb-4">
                                @foreach ($cartItems as $item)
                                    <div class="flex gap-3">
                                        @if ($item->book->image)
                                            <img src="{{ asset('storage/' . $item->book->image) }}"
                                                alt="{{ $item->book->title }}" class="w-16 h-20 object-cover rounded">
                                        @else
                                            <div class="w-16 h-20 bg-gray-200 rounded flex items-center justify-center">
                                                <i class="fas fa-book text-gray-400"></i>
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-gray-900 line-clamp-2">
                                                {{ $item->book->title }}</p>
                                            <p class="text-xs text-gray-600">{{ $item->quantity }}x Rp
                                                {{ number_format($item->book->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-600">Subtotal ({{ $cartItems->count() }} item)</span>
                                    <span class="font-semibold">Rp
                                        {{ number_format($cartItems->sum(function ($item) {return $item->quantity * $item->book->price;}),0,',','.') }}</span>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-3 px-4 rounded-lg mt-6 transition-all">
                                Lanjut ke Pembayaran
                                <i class="fas fa-arrow-right ml-2"></i>
                            </button>

                            <a href="{{ route('cart.index') }}"
                                class="block text-center text-purple-600 hover:text-purple-800 text-sm font-semibold mt-4">
                                <i class="fas fa-arrow-left mr-1"></i>Kembali ke Keranjang
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
