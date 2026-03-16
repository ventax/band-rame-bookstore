@extends('layouts.app')

@section('title', 'Pesanan Berhasil Dibuat!')

@section('content')
    @php
        $waNumberRaw = setting('store_whatsapp', '');
        $waNumber = preg_replace('/\D+/', '', (string) $waNumberRaw);
        if ($waNumber && str_starts_with($waNumber, '0')) {
            $waNumber = '62' . substr($waNumber, 1);
        }

        $orderDetailUrl = route('orders.show', $order->order_number);
        $confirmText =
            "Halo Admin ATigaBookStore, saya sudah menyelesaikan pembayaran.\n\n" .
            "Nomor Pesanan: {$order->order_number}\n" .
            'Total Pembayaran: Rp ' .
            number_format($order->grand_total, 0, ',', '.') .
            "\n" .
            "Nama Penerima: {$order->shipping_name}\n\n" .
            "Saya melampirkan:\n" .
            "1. Bukti pesanan (screenshot detail pesanan)\n" .
            "2. Bukti pembayaran (screenshot/struk pembayaran)\n\n" .
            "Link detail pesanan: {$orderDetailUrl}\n\n" .
            'Terima kasih.';
        $waConfirmUrl = $waNumber ? 'https://wa.me/' . $waNumber . '?text=' . urlencode($confirmText) : null;
    @endphp

    <div class="bg-gradient-to-br from-blue-50 via-slate-50 to-blue-100 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Icon -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full mb-4 animate-bounce">
                    <i class="fas fa-check-circle text-green-600 text-5xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Pesanan Berhasil Dibuat!</h1>
                <p class="text-gray-600">Terima kasih telah berbelanja di ATigaBookStore</p>
            </div>

            <!-- Order Information -->
            <div class="bg-white rounded-lg shadow-md border border-blue-100 p-6 mb-6">
                <div class="border-b border-blue-100 pb-4 mb-4">
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Detail Pesanan</h2>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Nomor Pesanan</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $order->order_number }}</p>
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
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-blue-600 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-bold text-blue-800 mb-2">Menunggu Pembayaran</h3>
                                <p class="text-sm text-blue-700 mb-3">Silakan transfer ke rekening berikut:</p>
                                <div class="bg-white p-3 rounded text-sm">
                                    <p class="font-semibold text-gray-700 mb-2">Pilih salah satu:</p>
                                    <div class="space-y-2">
                                        <div>
                                            <p class="font-bold text-gray-900">Bank BCA</p>
                                            <p class="text-gray-600">1234567890 a.n. ATigaBookStore Store</p>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">Bank Mandiri</p>
                                            <p class="text-gray-600">0987654321 a.n. ATigaBookStore Store</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 pt-3 border-t border-blue-100">
                                        <p class="font-semibold text-gray-700">Jumlah Transfer:</p>
                                        <p class="text-xl font-bold text-blue-600">Rp
                                            {{ number_format($order->grand_total, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <p class="text-xs text-blue-700 mt-3">
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
                            <div class="flex gap-4 p-3 bg-blue-50 rounded border border-blue-100">
                                @if ($item->book->cover_image)
                                    <img src="{{ asset('storage/' . $item->book->cover_image) }}"
                                        alt="{{ $item->book->title }}" class="w-16 h-20 object-cover rounded">
                                @else
                                    <div class="w-16 h-20 bg-blue-100 rounded flex items-center justify-center">
                                        <i class="fas fa-book text-blue-300"></i>
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
                <div class="mt-6 pt-6 border-t border-blue-100">
                    <h3 class="font-bold text-gray-900 mb-2">
                        <i class="fas fa-map-marker-alt text-blue-600 mr-2"></i>Alamat Pengiriman
                    </h3>
                    <div class="bg-blue-50 border border-blue-100 p-4 rounded">
                        <p class="font-bold text-gray-900">{{ $order->shipping_name }}</p>
                        <p class="text-gray-600 text-sm">{{ $order->shipping_phone }}</p>
                        <p class="text-gray-600 text-sm mt-1">{{ $order->shipping_address }}</p>
                        <p class="text-gray-600 text-sm">{{ $order->shipping_city }}, {{ $order->shipping_province }}
                            {{ $order->shipping_postal_code }}</p>
                    </div>
                </div>
            </div>

            <!-- WhatsApp Confirmation -->
            <div class="bg-blue-50 border border-blue-100 rounded-lg shadow-sm p-6 mb-6">
                <div class="flex items-start gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                        <i class="fab fa-whatsapp text-green-600 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Konfirmasi Pesanan via WhatsApp</h3>
                        <p class="text-sm text-gray-600">Kirim konfirmasi bahwa pembayaran sudah selesai agar tim kami bisa
                            verifikasi lebih cepat.</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-blue-100 p-4 mb-4">
                    <p class="text-sm font-semibold text-gray-800 mb-2">Lampiran wajib saat chat:</p>
                    <ul class="space-y-1 text-sm text-gray-700">
                        <li><i class="fas fa-check-circle text-blue-600 mr-2"></i>Bukti pesanan (screenshot halaman detail
                            pesanan)</li>
                        <li><i class="fas fa-check-circle text-blue-600 mr-2"></i>Bukti pembayaran (screenshot / struk
                            transaksi)</li>
                    </ul>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                    <a href="{{ $orderDetailUrl }}"
                        class="w-full bg-white border border-blue-600 text-blue-600 hover:bg-blue-50 font-semibold py-2.5 px-4 rounded-lg text-center transition-all">
                        <i class="fas fa-receipt mr-2"></i>Lihat Detail Pesanan
                    </a>
                    @if ($waConfirmUrl)
                        <a href="{{ $waConfirmUrl }}" target="_blank" rel="noopener noreferrer"
                            class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-2.5 px-4 rounded-lg text-center transition-all">
                            <i class="fab fa-whatsapp mr-2"></i>Kirim Konfirmasi WA
                        </a>
                    @else
                        <button type="button" disabled
                            class="w-full bg-gray-300 text-white font-semibold py-2.5 px-4 rounded-lg cursor-not-allowed">
                            <i class="fab fa-whatsapp mr-2"></i>Nomor WA toko belum diatur
                        </button>
                    @endif
                </div>

                <textarea id="wa-message-template" class="sr-only">{{ $confirmText }}</textarea>
                <button type="button" onclick="copyWaTemplate()"
                    class="w-full text-sm bg-white border border-gray-300 hover:border-blue-300 hover:bg-blue-50 text-gray-700 font-semibold py-2 rounded-lg transition-all">
                    <i class="fas fa-copy mr-1"></i>Salin Template Pesan WA
                </button>

                <p class="text-xs text-gray-500 mt-3">
                    WhatsApp tidak mendukung lampiran file otomatis dari link, jadi setelah chat terbuka silakan attach dua
                    bukti di atas secara manual.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col gap-4">
                <a href="{{ route('home') }}"
                    class="bg-white border-2 border-blue-600 text-blue-600 hover:bg-blue-50 font-bold py-3 px-6 rounded-lg text-center transition-all">
                    <i class="fas fa-home mr-2"></i>Kembali ke Beranda
                </a>
            </div>

            <!-- What's Next -->
            <div class="mt-6 text-center text-gray-600 text-sm">
                <p class="mb-2">
                    <i class="fas fa-info-circle text-blue-600 mr-1"></i>
                    Status pesanan dapat dilihat di halaman
                    <a href="{{ route('orders.index') }}" class="text-blue-600 hover:underline font-semibold">Pesanan
                        Saya</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function copyWaTemplate() {
            const text = document.getElementById('wa-message-template')?.value || '';
            if (!text) return;

            navigator.clipboard.writeText(text)
                .then(() => {
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: {
                            type: 'success',
                            message: 'Template pesan WhatsApp berhasil disalin.'
                        }
                    }));
                })
                .catch(() => {
                    alert('Gagal menyalin template. Silakan coba lagi.');
                });
        }
    </script>
@endsection
