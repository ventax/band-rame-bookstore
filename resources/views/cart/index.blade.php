@extends('layouts.app')

@section('title', 'Keranjang Belanja - BandRame')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Keranjang Belanja</h1>

            @if ($cartItems->count() > 0)
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="md:col-span-2 space-y-4">
                        @foreach ($cartItems as $item)
                            <div class="bg-white rounded-lg shadow p-6 flex gap-4" id="cart-item-{{ $item->id }}">
                                <div class="w-24 h-32 flex-shrink-0">
                                    @if ($item->book->cover_image)
                                        <img src="{{ asset('storage/' . $item->book->cover_image) }}"
                                            alt="{{ $item->book->title }}" class="w-full h-full object-cover rounded">
                                    @else
                                        <div class="w-full h-full bg-gray-300 flex items-center justify-center rounded">
                                            <i class="fas fa-book text-gray-500 text-3xl"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1">
                                    <h3 class="font-semibold text-lg mb-1">{{ $item->book->title }}</h3>
                                    <p class="text-gray-600 text-sm mb-2">{{ $item->book->author }}</p>
                                    <p class="text-primary-600 font-bold mb-4">Rp
                                        {{ number_format($item->book->price, 0, ',', '.') }}</p>

                                    <div class="flex items-center justify-between">
                                        <!-- Quantity Controls -->
                                        <div class="flex items-center border border-gray-300 rounded-lg">
                                            <button onclick="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                                class="px-3 py-1 text-gray-600 hover:bg-gray-100"
                                                {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <span class="px-4 py-1 border-x border-gray-300">{{ $item->quantity }}</span>
                                            <button
                                                onclick="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                                class="px-3 py-1 text-gray-600 hover:bg-gray-100"
                                                {{ $item->quantity >= $item->book->stock ? 'disabled' : '' }}>
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>

                                        <!-- Subtotal & Remove -->
                                        <div class="flex items-center gap-4">
                                            <span class="font-bold text-lg" id="subtotal-{{ $item->id }}">
                                                Rp {{ number_format($item->quantity * $item->book->price, 0, ',', '.') }}
                                            </span>
                                            <button onclick="removeItem({{ $item->id }})"
                                                class="text-red-600 hover:text-red-700">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Summary -->
                    <div class="md:col-span-1">
                        <div class="bg-white rounded-lg shadow p-6 sticky top-24">
                            <h2 class="text-xl font-semibold mb-4">Ringkasan Pesanan</h2>

                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal ({{ $cartItems->sum('quantity') }} item)</span>
                                    <span id="cart-total">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Ongkir</span>
                                    <span>Dihitung saat checkout</span>
                                </div>
                                <div class="border-t pt-3 flex justify-between font-bold text-lg">
                                    <span>Total</span>
                                    <span class="text-primary-600" id="cart-total-final">Rp
                                        {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <a href="{{ route('checkout.address') }}" class="block w-full btn-primary text-center">
                                Lanjut ke Checkout <i class="fas fa-arrow-right ml-2"></i>
                            </a>

                            <a href="{{ route('books.index') }}"
                                class="block w-full text-center mt-3 text-gray-600 hover:text-primary-600">
                                <i class="fas fa-arrow-left mr-2"></i> Lanjut Belanja
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <i class="fas fa-shopping-cart text-gray-400 text-6xl mb-4"></i>
                    <h2 class="text-2xl font-semibold text-gray-700 mb-2">Keranjang Belanja Kosong</h2>
                    <p class="text-gray-500 mb-6">Belum ada buku dalam keranjang belanja Anda</p>
                    <a href="{{ route('books.index') }}" class="inline-block btn-primary">
                        <i class="fas fa-book mr-2"></i> Mulai Belanja
                    </a>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            function updateQuantity(itemId, newQuantity) {
                if (newQuantity < 1) return;

                fetch(`/cart/${itemId}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            quantity: newQuantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update subtotal
                            document.getElementById(`subtotal-${itemId}`).textContent =
                                'Rp ' + data.subtotal.toLocaleString('id-ID');
                            // Update total
                            document.getElementById('cart-total').textContent =
                                'Rp ' + data.total.toLocaleString('id-ID');
                            document.getElementById('cart-total-final').textContent =
                                'Rp ' + data.total.toLocaleString('id-ID');
                            // Reload page to update quantity display
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    });
            }

            function removeItem(itemId) {
                if (!confirm('Apakah Anda yakin ingin menghapus item ini?')) return;

                fetch(`/cart/${itemId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    });
            }
        </script>
    @endpush
@endsection
