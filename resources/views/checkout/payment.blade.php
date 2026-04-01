@extends('layouts.app')

@section('title', 'Konfirmasi Pesanan - Checkout')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-purple-50 via-gray-50 to-pink-50 py-8 pb-52 md:pb-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Progress Steps -->
            <div class="mb-8 flex items-center justify-center max-w-xs sm:max-w-sm mx-auto">
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center shadow-md">
                        <i class="fas fa-check text-sm"></i>
                    </div>
                    <span class="mt-1.5 text-[10px] font-bold uppercase tracking-wide text-green-600">Alamat</span>
                </div>
                <div class="flex-1 h-0.5 bg-purple-500 mx-1.5 mb-5"></div>
                <div class="flex flex-col items-center">
                    <div
                        class="w-10 h-10 rounded-full bg-purple-600 text-white flex items-center justify-center shadow-md font-bold">
                        2
                    </div>
                    <span class="mt-1.5 text-[10px] font-bold uppercase tracking-wide text-purple-600">Bayar</span>
                </div>
                <div class="flex-1 h-0.5 bg-gray-300 mx-1.5 mb-5"></div>
                <div class="flex flex-col items-center">
                    <div
                        class="w-10 h-10 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center shadow-sm font-bold">
                        3
                    </div>
                    <span class="mt-1.5 text-[10px] font-bold uppercase tracking-wide text-gray-400">Selesai</span>
                </div>
            </div>

            <form id="checkout-payment-form" action="{{ route('checkout.process') }}" method="POST">
                @csrf

                @foreach ($selectedItemIds as $selectedItemId)
                    <input type="hidden" name="selected_items[]" value="{{ $selectedItemId }}">
                @endforeach

                {{-- Address hidden fields --}}
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

                <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

                    <!-- ===== LEFT column (spans 3/5 on desktop) ===== -->
                    <div class="lg:col-span-3 space-y-4">

                        <!-- Midtrans Payment Banner -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <!-- Header strip -->
                            <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-5 py-4 flex items-center gap-3">
                                <div
                                    class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-shield-alt text-white"></i>
                                </div>
                                <div>
                                    <p class="text-white font-bold text-sm leading-tight">Pembayaran Aman via Midtrans</p>
                                    <p class="text-white/70 text-xs">Enkripsi SSL 256-bit • Mode
                                        {{ config('services.midtrans.environment', 'sandbox') === 'production' ? 'Production' : 'Sandbox' }}
                                    </p>
                                </div>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/98/Midtrans.svg/320px-Midtrans.svg.png"
                                    alt="Midtrans" class="ml-auto h-6 opacity-90" onerror="this.style.display='none'">
                            </div>

                            <!-- Body -->
                            <div class="p-5">
                                <p class="text-gray-500 text-sm mb-4 leading-relaxed">
                                    Setelah klik <strong class="text-gray-700">Buat Pesanan & Bayar</strong>, Anda akan
                                    diarahkan ke halaman pembayaran Midtrans. Pilih metode yang Anda inginkan:
                                </p>

                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                                    <div class="flex flex-col items-center gap-1.5 bg-blue-50 rounded-xl p-3 text-center">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-university text-blue-600 text-sm"></i>
                                        </div>
                                        <span class="text-xs font-semibold text-blue-700 leading-tight">Transfer Bank /
                                            VA</span>
                                    </div>
                                    <div class="flex flex-col items-center gap-1.5 bg-red-50 rounded-xl p-3 text-center">
                                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-credit-card text-red-500 text-sm"></i>
                                        </div>
                                        <span class="text-xs font-semibold text-red-600 leading-tight">Kartu Kredit /
                                            Debit</span>
                                    </div>
                                    <div class="flex flex-col items-center gap-1.5 bg-green-50 rounded-xl p-3 text-center">
                                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-wallet text-green-600 text-sm"></i>
                                        </div>
                                        <span class="text-xs font-semibold text-green-700 leading-tight">GoPay / OVO /
                                            DANA</span>
                                    </div>
                                    <div class="flex flex-col items-center gap-1.5 bg-yellow-50 rounded-xl p-3 text-center">
                                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-store text-yellow-600 text-sm"></i>
                                        </div>
                                        <span class="text-xs font-semibold text-yellow-700 leading-tight">Indomaret /
                                            Alfamart</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="font-bold text-gray-900 flex items-center gap-2 text-sm">
                                    <span
                                        class="w-7 h-7 rounded-full bg-purple-100 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-map-marker-alt text-purple-600 text-xs"></i>
                                    </span>
                                    Alamat Pengiriman
                                </h3>
                                <a href="{{ route('checkout.address', ['selected_items' => $selectedItemIds]) }}"
                                    class="text-xs text-purple-600 hover:text-purple-800 font-semibold flex items-center gap-1">
                                    <i class="fas fa-pencil-alt text-[10px]"></i> Ubah
                                </a>
                            </div>

                            <div class="bg-purple-50 rounded-xl p-4 text-sm border border-purple-100">
                                @if ($address)
                                    <p class="font-semibold text-gray-900">{{ $address->recipient_name }}</p>
                                    <p class="text-gray-500 text-xs mt-0.5">{{ $address->phone }}</p>
                                    <p class="text-gray-600 mt-1.5">{{ $address->address }}</p>
                                    <p class="text-gray-600">{{ $address->city }}, {{ $address->province }}
                                        {{ $address->postal_code }}</p>
                                @else
                                    <p class="font-semibold text-gray-900">{{ request('recipient_name') }}</p>
                                    <p class="text-gray-500 text-xs mt-0.5">{{ request('phone') }}</p>
                                    <p class="text-gray-600 mt-1.5">{{ request('address') }}</p>
                                    <p class="text-gray-600">{{ request('city') }}, {{ request('province') }}
                                        {{ request('postal_code') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                            <h3 class="font-bold text-gray-900 flex items-center gap-2 text-sm mb-3">
                                <span
                                    class="w-7 h-7 rounded-full bg-purple-100 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-sticky-note text-purple-600 text-xs"></i>
                                </span>
                                Catatan Pesanan <span class="text-gray-400 font-normal">(Opsional)</span>
                            </h3>
                            <textarea name="notes" rows="3" placeholder="Contoh: tolong dikemas dengan rapi..."
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent text-sm resize-none transition">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <!-- ===== RIGHT column — Order Summary (spans 2/5 on desktop) ===== -->
                    <div class="lg:col-span-2 mb-28 lg:mb-0">
                        <div
                            class="bg-white rounded-2xl shadow-sm border border-gray-100 lg:sticky lg:top-24 overflow-hidden">

                            <!-- Header -->
                            <div class="px-5 py-4 border-b border-gray-100">
                                <h3 class="font-bold text-gray-900 flex items-center gap-2">
                                    <i class="fas fa-receipt text-purple-500"></i> Ringkasan Pesanan
                                </h3>
                            </div>

                            <!-- Items -->
                            <div class="px-5 py-4 space-y-3 max-h-52 overflow-y-auto">
                                @foreach ($cartItems as $item)
                                    <div class="flex gap-3 items-start">
                                        <div class="w-10 h-10 rounded-lg bg-gray-100 flex-shrink-0 overflow-hidden">
                                            @if ($item->book->cover_image)
                                                <img src="{{ Storage::url($item->book->cover_image) }}"
                                                    alt="{{ $item->book->title }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <i class="fas fa-book text-gray-400 text-xs"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-semibold text-gray-800 truncate">
                                                {{ $item->book->title }}</p>
                                            <p class="text-xs text-gray-400">{{ $item->quantity }}x • Rp
                                                {{ number_format($item->book->discounted_price, 0, ',', '.') }}</p>
                                        </div>
                                        <span class="text-xs font-bold text-gray-700 whitespace-nowrap">
                                            Rp
                                            {{ number_format($item->quantity * $item->book->discounted_price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Totals (desktop only to avoid duplicate with mobile sticky bar) -->
                            <div class="hidden lg:block px-5 py-4 border-t border-gray-100 space-y-2">
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Subtotal</span>
                                    <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="border-t border-dashed border-gray-200 pt-3 flex justify-between items-center">
                                    <span class="font-bold text-gray-900">Total Bayar</span>
                                    <span class="font-bold text-lg text-purple-600">Rp
                                        {{ number_format($grandTotal, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <!-- CTA (desktop only to avoid duplicate with mobile sticky bar) -->
                            <div class="hidden lg:block px-5 pb-5">
                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 active:scale-[0.98] text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-lg shadow-purple-200 flex items-center justify-center gap-2 text-sm">
                                    <i class="fas fa-lock text-xs"></i>
                                    Buat Pesanan & Bayar
                                </button>
                                <p
                                    class="text-center text-[11px] text-gray-400 mt-2.5 flex items-center justify-center gap-1">
                                    <i class="fas fa-shield-alt text-green-400"></i>
                                    Transaksi dienkripsi & diproses oleh Midtrans
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Mobile sticky CTA bar -->
    <div class="fixed left-0 right-0 z-40 lg:hidden bg-white/95 backdrop-blur border-t border-gray-200 px-4 py-2 shadow-2xl"
        style="bottom: calc(64px + env(safe-area-inset-bottom, 0px));">
        <button form="checkout-payment-form" type="submit"
            class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold py-2.5 rounded-xl text-sm flex items-center justify-center gap-2 shadow-lg">
            <i class="fas fa-lock text-xs"></i>
            Buat Pesanan & Bayar • Rp {{ number_format($grandTotal, 0, ',', '.') }}
        </button>
    </div>
@endsection
