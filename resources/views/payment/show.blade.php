@extends('layouts.app')

@section('title', 'Pembayaran - BandRame')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-8">
                <div class="text-center mb-8">
                    <div class="inline-block bg-primary-100 rounded-full p-4 mb-4">
                        <i class="fas fa-credit-card text-primary-600 text-5xl"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Pembayaran</h1>
                    <p class="text-gray-600">Order #{{ $order->order_number }}</p>
                </div>

                <!-- Order Summary -->
                <div class="bg-gray-50 rounded-lg p-6 mb-8">
                    <h2 class="font-semibold text-lg mb-4">Ringkasan Pesanan</h2>
                    <div class="space-y-2">
                        @foreach ($order->items as $item)
                            <div class="flex justify-between text-sm">
                                <span>{{ $item->book->title }} (x{{ $item->quantity }})</span>
                                <span class="font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                        <div class="border-t pt-2 flex justify-between font-bold text-lg">
                            <span>Total</span>
                            <span class="text-primary-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Methods -->
                <form action="{{ route('payment.process', $order->order_number) }}" method="POST">
                    @csrf
                    <h2 class="font-semibold text-lg mb-4">Pilih Metode Pembayaran</h2>

                    <div class="space-y-3 mb-8">
                        <label
                            class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-primary-500 transition">
                            <input type="radio" name="payment_method" value="bank_transfer" required class="mr-4">
                            <div class="flex items-center flex-1">
                                <i class="fas fa-university text-2xl text-gray-600 mr-4"></i>
                                <div>
                                    <p class="font-semibold">Transfer Bank</p>
                                    <p class="text-sm text-gray-600">BCA, Mandiri, BNI, BRI</p>
                                </div>
                            </div>
                        </label>

                        <label
                            class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-primary-500 transition">
                            <input type="radio" name="payment_method" value="credit_card" required class="mr-4">
                            <div class="flex items-center flex-1">
                                <i class="fas fa-credit-card text-2xl text-gray-600 mr-4"></i>
                                <div>
                                    <p class="font-semibold">Kartu Kredit/Debit</p>
                                    <p class="text-sm text-gray-600">Visa, Mastercard, JCB</p>
                                </div>
                            </div>
                        </label>

                        <label
                            class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-primary-500 transition">
                            <input type="radio" name="payment_method" value="e_wallet" required class="mr-4">
                            <div class="flex items-center flex-1">
                                <i class="fas fa-wallet text-2xl text-gray-600 mr-4"></i>
                                <div>
                                    <p class="font-semibold">E-Wallet</p>
                                    <p class="text-sm text-gray-600">GoPay, OVO, Dana, LinkAja</p>
                                </div>
                            </div>
                        </label>
                    </div>

                    <button type="submit" class="w-full btn-primary">
                        Bayar Sekarang <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        <i class="fas fa-shield-alt text-green-600 mr-1"></i>
                        Pembayaran Anda dilindungi dengan enkripsi SSL 256-bit
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
