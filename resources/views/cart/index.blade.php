@extends('layouts.app')

@section('title', 'Keranjang Belanja - ATigaBookStore')

@section('content')
    <div id="cart-page-content" class="bg-gray-100 py-8" style="transition: filter 0.2s ease;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Keranjang Belanja</h1>

            @if ($cartItems->count() > 0)
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="md:col-span-2 space-y-4">
                        @foreach ($cartItems as $item)
                            <div class="bg-white rounded-lg shadow p-6 flex gap-4" id="cart-item-{{ $item->id }}"
                                data-stock="{{ $item->book->stock }}" data-price="{{ $item->book->discounted_price }}">
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
                                    @if ($item->book->discount > 0)
                                        <div class="flex items-center gap-2 mb-1">
                                            <span
                                                class="inline-flex items-center gap-1 bg-gradient-to-r from-red-500 to-orange-500 text-white text-xs font-black px-2 py-0.5 rounded-lg shadow-sm">
                                                <i class="fas fa-bolt text-yellow-200" style="font-size:9px"></i>
                                                -{{ $item->book->discount }}%
                                            </span>
                                            <span class="text-xs text-gray-400 line-through">Rp
                                                {{ number_format($item->book->price, 0, ',', '.') }}</span>
                                        </div>
                                        <p class="text-red-600 font-black text-lg mb-1">Rp
                                            {{ number_format($item->book->discounted_price, 0, ',', '.') }}</p>
                                        <span
                                            class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full mb-3">
                                            <i class="fas fa-piggy-bank text-xs"></i> Hemat Rp
                                            {{ number_format($item->book->price - $item->book->discounted_price, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <p class="text-primary-600 font-bold text-lg mb-4">Rp
                                            {{ number_format($item->book->discounted_price, 0, ',', '.') }}</p>
                                    @endif

                                    <div class="flex items-center justify-between">
                                        <!-- Quantity Controls -->
                                        <div class="flex flex-col gap-1">
                                            <div
                                                class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                                <button type="button" id="btn-minus-{{ $item->id }}"
                                                    onclick="updateQuantity({{ $item->id }}, -1)"
                                                    class="px-3 py-1.5 text-gray-600 hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-white transition-colors"
                                                    {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                    <i class="fas fa-minus text-xs"></i>
                                                </button>
                                                <span id="qty-{{ $item->id }}"
                                                    class="px-4 py-1.5 border-x border-gray-300 font-semibold min-w-[2.5rem] text-center">{{ $item->quantity }}</span>
                                                <button type="button" id="btn-plus-{{ $item->id }}"
                                                    onclick="updateQuantity({{ $item->id }}, 1)"
                                                    class="px-3 py-1.5 text-gray-600 hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-white transition-colors"
                                                    {{ $item->quantity >= $item->book->stock ? 'disabled' : '' }}
                                                    title="{{ $item->quantity >= $item->book->stock ? 'Stok maksimal: ' . $item->book->stock : 'Tambah jumlah' }}">
                                                    <i class="fas fa-plus text-xs"></i>
                                                </button>
                                            </div>
                                            <p id="stock-info-{{ $item->id }}"
                                                class="text-xs text-orange-500 {{ $item->quantity < $item->book->stock ? 'hidden' : '' }}">
                                                <i class="fas fa-info-circle"></i> Stok tersisa: {{ $item->book->stock }}
                                            </p>
                                        </div>

                                        <!-- Subtotal & Remove -->
                                        <div class="flex items-center gap-4">
                                            <span class="font-bold text-lg" id="subtotal-{{ $item->id }}">
                                                Rp
                                                {{ number_format($item->quantity * $item->book->discounted_price, 0, ',', '.') }}
                                            </span>
                                            <button type="button"
                                                onclick="openDeleteModal({{ $item->id }}, '{{ addslashes($item->book->title) }}')"
                                                class="text-red-400 hover:text-red-600 transition-colors p-1">
                                                <i class="fas fa-trash-alt"></i>
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

    <!-- Delete Confirmation Modal (must be AFTER page content so it paints on top of the blurred layer) -->
    <div x-data="deleteModal()" x-show="open" x-cloak @click.self="open = false" @keydown.escape.window="open = false"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/60">

        <!-- Modal box -->
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xs p-6"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" @click.stop>

            <!-- Icon -->
            <div class="flex justify-center mb-3">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-trash-alt text-red-500 text-lg"></i>
                </div>
            </div>

            <!-- Text -->
            <h3 class="text-base font-bold text-gray-900 text-center mb-1">Hapus dari Keranjang?</h3>
            <p class="text-xs text-gray-500 text-center mb-1">Buku ini akan dihapus dari keranjang belanja Anda.</p>
            <p class="text-xs font-semibold text-gray-700 text-center mb-5 leading-snug" x-text="bookTitle"></p>

            <!-- Buttons -->
            <div class="flex gap-2">
                <button type="button" @click="open = false"
                    class="flex-1 py-2 rounded-xl border border-gray-300 text-sm text-gray-700 font-semibold hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="button" @click="confirm()" :disabled="loading"
                    class="flex-1 py-2 rounded-xl bg-gradient-to-r from-red-500 to-rose-600 text-sm text-white font-semibold hover:from-red-600 hover:to-rose-700 transition-all disabled:opacity-60">
                    <span x-show="!loading"><i class="fas fa-trash-alt mr-1"></i> Ya, Hapus</span>
                    <span x-show="loading"><i class="fas fa-spinner fa-spin mr-1"></i> Menghapus...</span>
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            function deleteModal() {
                return {
                    open: false,
                    loading: false,
                    itemId: null,
                    bookTitle: '',
                    init() {
                        window.addEventListener('open-delete-modal', (e) => {
                            this.itemId = e.detail.itemId;
                            this.bookTitle = e.detail.title;
                            this.loading = false;
                            this.open = true;
                        });
                        this.$watch('open', val => {
                            const content = document.getElementById('cart-page-content');
                            if (content) content.style.filter = val ? 'blur(4px)' : '';
                        });
                    },
                    confirm() {
                        this.loading = true;
                        removeItem(this.itemId, () => {
                            this.open = false;
                            this.loading = false;
                        });
                    }
                };
            }

            function updateQuantity(itemId, delta) {
                const qtyEl = document.getElementById(`qty-${itemId}`);
                const itemEl = document.getElementById(`cart-item-${itemId}`);
                const stock = parseInt(itemEl.dataset.stock);
                const price = parseFloat(itemEl.dataset.price);
                const current = parseInt(qtyEl.textContent);
                const newQty = current + delta;

                if (newQty < 1 || newQty > stock) return;

                fetch(`/cart/${itemId}`, {
                        method: 'PATCH',
                        credentials: 'same-origin',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            quantity: newQty
                        })
                    })
                    .then(response => {
                        if (response.status === 401 || response.status === 419) {
                            window.location.href = '/login';
                            return null;
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (!data || !data.success) return;

                        // Update quantity display
                        qtyEl.textContent = newQty;

                        // Update minus button
                        document.getElementById(`btn-minus-${itemId}`).disabled = newQty <= 1;

                        // Update plus button & stock info
                        const btnPlus = document.getElementById(`btn-plus-${itemId}`);
                        const stockInfo = document.getElementById(`stock-info-${itemId}`);
                        btnPlus.disabled = newQty >= stock;
                        stockInfo.classList.toggle('hidden', newQty < stock);

                        // Update subtotal for this item
                        const subtotal = newQty * price;
                        document.getElementById(`subtotal-${itemId}`).textContent =
                            'Rp ' + subtotal.toLocaleString('id-ID');

                        // Recalculate grand total from all subtotals
                        let grandTotal = 0;
                        document.querySelectorAll('[id^="subtotal-"]').forEach(el => {
                            grandTotal += parseFloat(el.textContent.replace(/[^0-9]/g, ''));
                        });
                        document.getElementById('cart-total').textContent =
                            'Rp ' + grandTotal.toLocaleString('id-ID');
                        document.getElementById('cart-total-final').textContent =
                            'Rp ' + grandTotal.toLocaleString('id-ID');

                        // Update cart badge in navbar
                        window.dispatchEvent(new CustomEvent('cart-updated'));
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    });
            }

            function removeItem(itemId, onSuccess) {
                fetch(`/cart/${itemId}`, {
                        method: 'DELETE',
                        credentials: 'same-origin',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.status === 401 || response.status === 419) {
                            window.location.href = '/login';
                            return null;
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (!data || !data.success) return;
                        if (onSuccess) onSuccess();
                        const itemEl = document.getElementById(`cart-item-${itemId}`);
                        itemEl.remove();

                        // Recalculate total
                        let grandTotal = 0;
                        document.querySelectorAll('[id^="subtotal-"]').forEach(el => {
                            grandTotal += parseFloat(el.textContent.replace(/[^0-9]/g, ''));
                        });
                        document.getElementById('cart-total').textContent =
                            'Rp ' + grandTotal.toLocaleString('id-ID');
                        document.getElementById('cart-total-final').textContent =
                            'Rp ' + grandTotal.toLocaleString('id-ID');

                        window.dispatchEvent(new CustomEvent('cart-updated'));

                        // If no items left, reload to show empty state
                        if (!document.querySelector('[id^="cart-item-"]')) location.reload();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    });
            }

            function openDeleteModal(itemId, title) {
                window.dispatchEvent(new CustomEvent('open-delete-modal', {
                    detail: {
                        itemId,
                        title
                    }
                }));
            }
        </script>
    @endpush
@endsection
