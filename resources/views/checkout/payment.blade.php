@extends('layouts.app')

@section('title', 'Metode Pembayaran - Checkout')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex items-center justify-center">
                    <div class="flex items-center">
                        <div class="flex items-center text-green-600 relative">
                            <div
                                class="rounded-full h-12 w-12 flex items-center justify-center bg-green-600 text-white font-bold">
                                <i class="fas fa-check"></i>
                            </div>
                            <div
                                class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-green-600">
                                Alamat
                            </div>
                        </div>
                        <div class="flex-auto border-t-2 border-purple-600"></div>
                        <div class="flex items-center text-purple-600 relative">
                            <div
                                class="rounded-full h-12 w-12 flex items-center justify-center bg-purple-600 text-white font-bold">
                                2
                            </div>
                            <div
                                class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-purple-600">
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

            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf

                <!-- Pass address data -->
                @if ($address)
                    <input type="hidden" name="address_id" value="{{ $address->id }}">
                @else
                    <input type="hidden" name="recipient_name" value="{{ request('recipient_name') }}">
                    <input type="hidden" name="phone" value="{{ request('phone') }}">
                    <input type="hidden" name="address" value="{{ request('address') }}">
                    <input type="hidden" name="city" value="{{ request('city') }}">
                    <input type="hidden" name="province" value="{{ request('province') }}">
                    <input type="hidden" name="postal_code" value="{{ request('postal_code') }}">
                @endif

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Left: Payment Method -->
                    <div class="md:col-span-2">
                        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                                <i class="fas fa-credit-card text-purple-600 mr-2"></i>Metode Pembayaran
                            </h2>

                            <div class="space-y-4">
                                <!-- Transfer Bank -->
                                <label class="block cursor-pointer">
                                    <div
                                        class="border-2 rounded-lg p-4 transition-all border-gray-200 hover:border-purple-300 has-[:checked]:border-purple-600 has-[:checked]:bg-purple-50">
                                        <div class="flex items-start">
                                            <input type="radio" name="payment_method" value="transfer_bank" required
                                                class="mt-1 mr-3">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-2">
                                                    <i class="fas fa-university text-purple-600 text-xl"></i>
                                                    <span class="font-bold text-gray-900">Transfer Bank</span>
                                                </div>
                                                <p class="text-gray-600 text-sm">Bayar melalui transfer ke rekening bank
                                                    kami</p>
                                                <div class="mt-3 bg-gray-50 p-3 rounded text-sm">
                                                    <p class="font-semibold text-gray-700 mb-1">Rekening Tujuan:</p>
                                                    <p class="text-gray-600">BCA - 1234567890 a.n. BandRame Store</p>
                                                    <p class="text-gray-600">Mandiri - 0987654321 a.n. BandRame Store</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                <!-- COD -->
                                <label class="block cursor-pointer">
                                    <div
                                        class="border-2 rounded-lg p-4 transition-all border-gray-200 hover:border-purple-300 has-[:checked]:border-purple-600 has-[:checked]:bg-purple-50">
                                        <div class="flex items-start">
                                            <input type="radio" name="payment_method" value="cod" required
                                                class="mt-1 mr-3">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-2">
                                                    <i class="fas fa-hand-holding-usd text-green-600 text-xl"></i>
                                                    <span class="font-bold text-gray-900">Cash on Delivery (COD)</span>
                                                </div>
                                                <p class="text-gray-600 text-sm">Bayar saat barang diterima di tempat Anda
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            @error('payment_method')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Delivery Address -->
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="font-bold text-gray-900 mb-3">
                                <i class="fas fa-map-marker-alt text-purple-600 mr-2"></i>Alamat Pengiriman
                            </h3>
                            @if ($address)
                                <div class="bg-gray-50 p-4 rounded">
                                    <p class="font-bold text-gray-900">{{ $address->recipient_name }}</p>
                                    <p class="text-gray-600 text-sm">{{ $address->phone }}</p>
                                    <p class="text-gray-600 text-sm mt-1">{{ $address->address }}</p>
                                    <p class="text-gray-600 text-sm">{{ $address->city }}, {{ $address->province }}
                                        {{ $address->postal_code }}</p>
                                </div>
                            @else
                                <div class="bg-gray-50 p-4 rounded">
                                    <p class="font-bold text-gray-900">{{ request('recipient_name') }}</p>
                                    <p class="text-gray-600 text-sm">{{ request('phone') }}</p>
                                    <p class="text-gray-600 text-sm mt-1">{{ request('address') }}</p>
                                    <p class="text-gray-600 text-sm">{{ request('city') }}, {{ request('province') }}
                                        {{ request('postal_code') }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Notes -->
                        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                            <h3 class="font-bold text-gray-900 mb-3">
                                <i class="fas fa-sticky-note text-purple-600 mr-2"></i>Catatan (Opsional)
                            </h3>
                            <textarea name="notes" rows="3" placeholder="Tambahkan catatan untuk pesanan Anda..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <!-- Right: Order Summary -->
                    <div class="md:col-span-1">
                        <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Pesanan</h3>

                            <div class="space-y-2 mb-4 max-h-64 overflow-y-auto">
                                @foreach ($cartItems as $item)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">{{ $item->book->title }}
                                            ({{ $item->quantity }}x)</span>
                                        <span class="font-semibold">Rp
                                            {{ number_format($item->quantity * $item->book->price, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t border-gray-200 pt-4 space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Ongkos Kirim</span>
                                    <span class="font-semibold">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                                </div>
                                <div class="border-t border-gray-200 pt-2 flex justify-between">
                                    <span class="font-bold text-gray-900">Total</span>
                                    <span class="font-bold text-xl text-purple-600">Rp
                                        {{ number_format($grandTotal, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-3 px-4 rounded-lg mt-6 transition-all">
                                <i class="fas fa-check mr-2"></i>Buat Pesanan
                            </button>

                            <a href="{{ route('checkout.address') }}"
                                class="block text-center text-purple-600 hover:text-purple-800 text-sm font-semibold mt-4">
                                <i class="fas fa-arrow-left mr-1"></i>Ubah Alamat
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
