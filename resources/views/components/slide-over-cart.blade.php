<!-- Slide-over Cart Component -->
<div x-data="slideOverCart()" x-init="init()" @cart-updated.window="loadCart()" class="relative z-50">
    <!-- Cart Toggle Button (Floating) -->
    <button @click="open = true"
        class="fixed right-4 bottom-20 lg:hidden bg-gradient-to-r from-purple-600 to-pink-600 text-white p-4 rounded-full shadow-2xl hover:shadow-3xl transition-all transform hover:scale-110 z-40">
        <i class="fas fa-shopping-cart text-xl"></i>
        <span x-show="cart.count > 0" x-text="cart.count"
            class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center">
        </span>
    </button>

    <!-- Overlay -->
    <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="open = false" class="fixed inset-0 bg-black bg-opacity-50"
        style="display: none;">
    </div>

    <!-- Slide-over Panel -->
    <div x-show="open" x-transition:enter="transform transition ease-in-out duration-300"
        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full" class="fixed inset-y-0 right-0 max-w-full flex pl-10 sm:pl-16"
        style="display: none;">
        <div class="w-screen max-w-md">
            <div class="h-full flex flex-col bg-white shadow-xl">
                <!-- Header -->
                <div class="px-4 py-6 bg-gradient-to-r from-purple-600 to-pink-600 text-white">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold">
                            <i class="fas fa-shopping-cart mr-2"></i>Keranjang Belanja
                        </h2>
                        <button @click="open = false" class="text-white hover:text-gray-200">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <p class="text-sm mt-1 text-purple-100" x-text="`${cart.count} item dalam keranjang`"></p>
                </div>

                <!-- Cart Items -->
                <div class="flex-1 overflow-y-auto py-6 px-4 sm:px-6">
                    <template x-if="loading">
                        <div class="flex justify-center items-center h-full">
                            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600"></div>
                        </div>
                    </template>

                    <template x-if="!loading && cart.items.length === 0">
                        <div class="text-center py-12">
                            <i class="fas fa-shopping-cart text-gray-300 text-6xl mb-4"></i>
                            <p class="text-gray-500">Keranjang Anda kosong</p>
                            <button @click="open = false"
                                class="mt-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-2 rounded-lg hover:shadow-lg transition-all">
                                Mulai Belanja
                            </button>
                        </div>
                    </template>

                    <template x-if="!loading && cart.items.length > 0">
                        <div class="space-y-4">
                            <template x-for="item in cart.items" :key="item.id">
                                <div
                                    class="flex space-x-4 bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors">
                                    <img :src="item.image" :alt="item.title"
                                        class="w-20 h-24 object-cover rounded">
                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-900 text-sm line-clamp-2" x-text="item.title">
                                        </h3>
                                        <p class="text-purple-600 font-semibold mt-1" x-text="item.price_formatted">
                                        </p>
                                        <div class="flex items-center mt-2 space-x-2">
                                            <button @click="updateQuantity(item.id, item.quantity - 1)"
                                                class="w-7 h-7 bg-gray-200 rounded hover:bg-gray-300 transition-colors">
                                                <i class="fas fa-minus text-xs"></i>
                                            </button>
                                            <span class="w-10 text-center font-medium" x-text="item.quantity"></span>
                                            <button @click="updateQuantity(item.id, item.quantity + 1)"
                                                class="w-7 h-7 bg-gray-200 rounded hover:bg-gray-300 transition-colors">
                                                <i class="fas fa-plus text-xs"></i>
                                            </button>
                                            <button @click="removeItem(item.id)"
                                                class="ml-auto text-red-500 hover:text-red-700">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>

                <!-- Footer -->
                <div class="border-t border-gray-200 px-4 py-6 sm:px-6 bg-gray-50">
                    <div class="flex justify-between text-base font-medium text-gray-900 mb-4">
                        <p>Subtotal</p>
                        <p x-text="cart.total_formatted"></p>
                    </div>
                    <a :href="cart.items.length > 0 ? '{{ route('cart.index') }}' : '#'"
                        @click="if(cart.items.length > 0) open = false"
                        :class="cart.items.length === 0 ? 'opacity-50 cursor-not-allowed' : ''"
                        class="block w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white text-center px-6 py-3 rounded-lg font-semibold hover:shadow-lg transition-all">
                        Lihat Keranjang
                    </a>
                    <div class="mt-3 text-center">
                        <button @click="open = false" class="text-sm text-gray-500 hover:text-gray-700">
                            Lanjut Belanja
                            <i class="fas fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function slideOverCart() {
        return {
            open: false,
            loading: false,
            cart: {
                items: [],
                total: 0,
                total_formatted: 'Rp 0',
                count: 0
            },

            init() {
                this.loadCart();
            },

            async loadCart() {
                @auth
                this.loading = true;
                try {
                    const response = await fetch('{{ route('cart.items') }}', {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });
                    const data = await response.json();
                    this.cart = data;

                    // Update navbar cart count
                    const cartCountElements = document.querySelectorAll('#cart-count, #mobile-cart-count');
                    cartCountElements.forEach(el => {
                        el.textContent = data.count;
                    });
                } catch (error) {
                    console.error('Error loading cart:', error);
                } finally {
                    this.loading = false;
                }
            @endauth
        },

        async updateQuantity(itemId, newQuantity) {
                if (newQuantity < 1) return;

                try {
                    const response = await fetch(`/cart/${itemId}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            quantity: newQuantity
                        })
                    });

                    if (response.ok) {
                        await this.loadCart();
                        window.dispatchEvent(new CustomEvent('toast', {
                            detail: {
                                message: 'Jumlah item diperbarui',
                                type: 'success'
                            }
                        }));
                    }
                } catch (error) {
                    console.error('Error updating quantity:', error);
                }
            },

            async removeItem(itemId) {
                try {
                    const response = await fetch(`/cart/${itemId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();
                    if (data.success) {
                        await this.loadCart();
                        window.dispatchEvent(new CustomEvent('toast', {
                            detail: {
                                message: data.message,
                                type: 'success'
                            }
                        }));
                    }
                } catch (error) {
                    console.error('Error removing item:', error);
                }
            }
    };
    }
</script>
