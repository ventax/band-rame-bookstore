@extends('layouts.app')

@section('title', 'Katalog Buku - BandRame')

@section('content')
    <div class="bg-gray-100 py-8" x-data="booksInteractive()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header & Search -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-4 animate-fade-in">Katalog Buku</h1>

                <div class="flex flex-col md:flex-row gap-4" x-data="{
                    searchQuery: '{{ request('search') }}',
                    searchTimeout: null,
                    liveSearch() {
                        clearTimeout(this.searchTimeout);
                        this.searchTimeout = setTimeout(() => {
                            let url = '{{ route('books.index') }}';
                            let params = [];
                            if (this.searchQuery) params.push('search=' + encodeURIComponent(this.searchQuery));
                            if ('{{ request('category') }}') params.push('category={{ request('category') }}');
                            if ('{{ request('sort') }}') params.push('sort={{ request('sort') }}');
                            window.location.href = url + (params.length ? '?' + params.join('&') : '');
                        }, 500);
                    }
                }">
                    <!-- Live Search -->
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" x-model="searchQuery" @input="liveSearch()"
                                placeholder="Ketik untuk mencari judul buku, penulis..."
                                class="w-full px-4 py-3 pl-12 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                            <i class="fas fa-search absolute left-4 top-4 text-gray-400"></i>
                            <div x-show="searchQuery" @click="searchQuery = ''; liveSearch()"
                                class="absolute right-4 top-4 text-gray-400 hover:text-gray-600 cursor-pointer">
                                <i class="fas fa-times"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Sort -->
                    <div class="flex gap-2">
                        <select name="sort"
                            onchange="window.location.href='{{ route('books.index') }}?sort='+this.value+'&category={{ request('category') }}&search={{ request('search') }}'"
                            class="px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 transition-all">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah
                            </option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga
                                Tertinggi</option>
                            <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Judul (A-Z)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-4 gap-8">
                <!-- Sidebar Filters -->
                <div class="md:col-span-1">
                    <div class="bg-white rounded-lg shadow-lg p-6 sticky top-24 animate-slide-in-left">
                        <h3 class="font-semibold text-lg mb-4 text-gray-800">
                            <i class="fas fa-filter mr-2 text-purple-600"></i>Filter Kategori
                        </h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('books.index', ['search' => request('search'), 'sort' => request('sort')]) }}"
                                    class="block py-2 px-3 rounded-lg transition-all {{ !request('category') ? 'bg-gradient-to-r from-purple-100 to-pink-100 text-purple-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                                    Semua Kategori
                                </a>
                            </li>
                            @foreach ($categories as $category)
                                <li>
                                    <a href="{{ route('books.index', ['category' => $category->id, 'search' => request('search'), 'sort' => request('sort')]) }}"
                                        class="flex items-center justify-between py-2 px-3 rounded-lg transition-all {{ request('category') == $category->id ? 'bg-gradient-to-r from-purple-100 to-pink-100 text-purple-700 font-semibold shadow-sm' : 'text-gray-700 hover:bg-gray-100' }}">
                                        <span>{{ $category->name }}</span>
                                        <span
                                            class="text-xs {{ request('category') == $category->id ? 'bg-purple-200 text-purple-700' : 'bg-gray-200 text-gray-600' }} px-2 py-0.5 rounded-full">
                                            {{ $category->books_count }}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Books Grid -->
                <div class="md:col-span-3">
                    <!-- Active Filters -->
                    @if (request('category') || request('search'))
                        <div
                            class="mb-6 bg-purple-50 border border-purple-200 rounded-lg p-4 flex items-center justify-between animate-fade-in">
                            <div class="flex items-center gap-3 flex-wrap">
                                <span class="text-sm font-semibold text-purple-700">
                                    <i class="fas fa-filter mr-1"></i>Filter Aktif:
                                </span>
                                @if (request('category'))
                                    @php
                                        $activeCategory = $categories->firstWhere('id', request('category'));
                                    @endphp
                                    @if ($activeCategory)
                                        <span
                                            class="bg-purple-200 text-purple-800 text-xs font-semibold px-3 py-1.5 rounded-full">
                                            <i class="fas fa-tag mr-1"></i>{{ $activeCategory->name }}
                                        </span>
                                    @endif
                                @endif
                                @if (request('search'))
                                    <span
                                        class="bg-purple-200 text-purple-800 text-xs font-semibold px-3 py-1.5 rounded-full">
                                        <i class="fas fa-search mr-1"></i>"{{ request('search') }}"
                                    </span>
                                @endif
                            </div>
                            <a href="{{ route('books.index', ['sort' => request('sort')]) }}"
                                class="text-xs text-purple-600 hover:text-purple-800 font-semibold hover:underline whitespace-nowrap">
                                <i class="fas fa-times mr-1"></i>Hapus Filter
                            </a>
                        </div>
                    @endif

                    @if ($books->count() > 0)
                        <!-- Results Info -->
                        <div class="mb-4 flex items-center justify-between">
                            <p class="text-sm text-gray-600">
                                Menampilkan <span class="font-semibold text-purple-700">{{ $books->count() }}</span> dari
                                <span class="font-semibold text-purple-700">{{ $books->total() }}</span> buku
                            </p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($books as $book)
                                <div class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 animate-fade-in-up"
                                    style="animation-delay: {{ $loop->index * 50 }}ms">
                                    <div class="relative overflow-hidden">
                                        @if ($book->image)
                                            <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                                                class="w-full h-72 object-cover group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <div
                                                class="w-full h-72 bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center">
                                                <i class="fas fa-book text-purple-300 text-6xl"></i>
                                            </div>
                                        @endif

                                        <!-- Wishlist Button -->
                                        @auth
                                            <button @click="toggleWishlist({{ $book->id }}, $event)"
                                                :class="wishlistBooks.includes({{ $book->id }}) ? 'text-red-500' :
                                                    'text-gray-700'"
                                                class="absolute top-3 right-3 w-10 h-10 bg-white bg-opacity-90 hover:bg-opacity-100 rounded-full shadow-lg flex items-center justify-center transition-all transform hover:scale-110 z-10">
                                                <i :class="wishlistBooks.includes({{ $book->id }}) ? 'fas' : 'far'"
                                                    class="fa-heart text-lg"></i>
                                            </button>
                                        @endauth

                                        <!-- Quick View Button -->
                                        <button @click="quickView({{ $book->id }})"
                                            class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                            <div
                                                class="bg-white text-purple-600 px-6 py-3 rounded-lg font-semibold transform translate-y-4 group-hover:translate-y-0 transition-all">
                                                <i class="fas fa-eye mr-2"></i>Quick View
                                            </div>
                                        </button>

                                        <!-- Badge -->
                                        @if ($loop->index < 3)
                                            <span
                                                class="absolute top-3 left-3 bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg animate-pulse">
                                                <i class="fas fa-star mr-1"></i>Best Seller
                                            </span>
                                        @endif
                                    </div>

                                    <div class="p-5">
                                        <span
                                            class="text-xs text-purple-600 font-semibold bg-purple-50 px-3 py-1 rounded-full">{{ $book->category->name }}</span>
                                        <h3
                                            class="font-bold text-gray-900 mt-3 mb-2 line-clamp-2 text-lg hover:text-purple-600 transition-colors">
                                            <a href="{{ route('books.show', $book->slug) }}">{{ $book->title }}</a>
                                        </h3>
                                        <p class="text-sm text-gray-600 mb-3">
                                            <i class="fas fa-user text-gray-400 mr-1"></i>{{ $book->author }}
                                        </p>

                                        <div class="flex justify-between items-center mb-4">
                                            <span
                                                class="text-xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                                                Rp {{ number_format($book->price, 0, ',', '.') }}
                                            </span>
                                            @if ($book->stock > 0)
                                                <span class="text-xs text-green-600 font-medium">
                                                    <i class="fas fa-check-circle"></i> Stok: {{ $book->stock }}
                                                </span>
                                            @else
                                                <span class="text-xs text-red-600 font-medium">
                                                    <i class="fas fa-times-circle"></i> Habis
                                                </span>
                                            @endif
                                        </div>

                                        @auth
                                            @if ($book->stock > 0)
                                                <button @click="addToCart({{ $book->id }})"
                                                    class="w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-all transform hover:scale-105 hover:shadow-lg">
                                                    <i class="fas fa-shopping-cart mr-2"></i>Tambah ke Keranjang
                                                </button>
                                            @else
                                                <button disabled
                                                    class="w-full bg-gray-300 text-gray-500 font-semibold py-2.5 px-4 rounded-lg cursor-not-allowed">
                                                    Stok Habis
                                                </button>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}"
                                                class="block w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-semibold py-2.5 px-4 rounded-lg text-center transition-all transform hover:scale-105 hover:shadow-lg">
                                                <i class="fas fa-sign-in-alt mr-2"></i>Login untuk Beli
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $books->appends(['category' => request('category'), 'search' => request('search'), 'sort' => request('sort')])->links() }}
                        </div>
                    @else
                        <div class="text-center py-16 bg-white rounded-xl shadow-lg">
                            <i class="fas fa-search text-gray-300 text-6xl mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-600 mb-2">Buku tidak ditemukan</h3>
                            <p class="text-gray-500">Coba kata kunci atau filter yang berbeda</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick View Modal -->
        <div x-show="showQuickView" x-cloak @click.self="showQuickView = false"
            class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div @click.stop
                class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto transform transition-all"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

                <template x-if="quickViewBook">
                    <div>
                        <!-- Header -->
                        <div class="flex justify-between items-center p-6 border-b border-gray-200">
                            <h2 class="text-2xl font-bold text-gray-900">Quick View</h2>
                            <button @click="showQuickView = false"
                                class="text-gray-400 hover:text-gray-600 transition-colors">
                                <i class="fas fa-times text-2xl"></i>
                            </button>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <div class="grid md:grid-cols-2 gap-8">
                                <!-- Image -->
                                <div>
                                    <img :src="quickViewBook.image" :alt="quickViewBook.title"
                                        class="w-full rounded-xl shadow-lg">
                                    @auth
                                        <button @click="toggleWishlist(quickViewBook.id, $event)"
                                            :class="quickViewBook.in_wishlist ? 'bg-red-500 text-white' :
                                                'bg-gray-100 text-gray-700'"
                                            class="w-full mt-4 py-3 rounded-lg font-semibold transition-all hover:shadow-lg">
                                            <i :class="quickViewBook.in_wishlist ? 'fas' : 'far'" class="fa-heart mr-2"></i>
                                            <span
                                                x-text="quickViewBook.in_wishlist ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist'"></span>
                                        </button>
                                    @endauth
                                </div>

                                <!-- Details -->
                                <div>
                                    <span class="text-sm text-purple-600 font-semibold bg-purple-50 px-3 py-1 rounded-full"
                                        x-text="quickViewBook.category"></span>
                                    <h3 class="text-3xl font-bold text-gray-900 mt-4 mb-2" x-text="quickViewBook.title">
                                    </h3>
                                    <p class="text-gray-600 mb-4">
                                        <i class="fas fa-user mr-2"></i><span x-text="quickViewBook.author"></span>
                                    </p>
                                    <p class="text-gray-600 mb-4">
                                        <i class="fas fa-building mr-2"></i><span x-text="quickViewBook.publisher"></span>
                                    </p>

                                    <div
                                        class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-4">
                                        Rp <span x-text="quickViewBook.price"></span>
                                    </div>

                                    <div class="mb-6">
                                        <span class="text-sm font-medium text-gray-700">Stok: </span>
                                        <span class="text-sm font-bold"
                                            :class="quickViewBook.stock > 0 ? 'text-green-600' : 'text-red-600'"
                                            x-text="quickViewBook.stock > 0 ? quickViewBook.stock + ' tersedia' : 'Habis'"></span>
                                    </div>

                                    <div class="mb-6">
                                        <h4 class="font-semibold text-gray-900 mb-2">Deskripsi:</h4>
                                        <p class="text-gray-600 text-sm leading-relaxed"
                                            x-text="quickViewBook.description"></p>
                                    </div>

                                    @auth
                                        <div class="space-y-3">
                                            <button @click="addToCart(quickViewBook.id)" x-show="quickViewBook.stock > 0"
                                                class="w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-4 px-6 rounded-lg transition-all transform hover:scale-105 hover:shadow-xl">
                                                <i class="fas fa-shopping-cart mr-2"></i>Tambah ke Keranjang
                                            </button>
                                            <a :href="`/books/${quickViewBook.slug}`"
                                                class="block w-full bg-white border-2 border-purple-600 text-purple-600 hover:bg-purple-50 font-bold py-4 px-6 rounded-lg text-center transition-all">
                                                Lihat Detail Lengkap
                                            </a>
                                        </div>
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="block w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold py-4 px-6 rounded-lg text-center transition-all hover:shadow-xl">
                                            <i class="fas fa-sign-in-alt mr-2"></i>Login untuk Membeli
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out backwards;
        }

        .animate-slide-in-left {
            animation: slideInLeft 0.5s ease-out;
        }
    </style>

    <script>
        function booksInteractive() {
            return {
                showQuickView: false,
                quickViewBook: null,
                wishlistBooks: @json(auth()->check() ? auth()->user()->wishlists()->pluck('book_id')->toArray() : []),

                async quickView(bookId) {
                    try {
                        const response = await fetch(`/books/${bookId}/quick-view`, {
                            headers: {
                                'Accept': 'application/json'
                            }
                        });
                        this.quickViewBook = await response.json();
                        this.showQuickView = true;
                    } catch (error) {
                        console.error('Error loading quick view:', error);
                        window.dispatchEvent(new CustomEvent('toast', {
                            detail: {
                                message: 'Gagal memuat detail buku',
                                type: 'error'
                            }
                        }));
                    }
                },

                async addToCart(bookId) {
                    try {
                        // Trigger flying animation
                        const bookCard = event.target.closest('.group, .relative');
                        const bookImage = bookCard?.querySelector('img') || bookCard?.querySelector(
                            '.aspect-\\[2\\/3\\]');
                        const bookTitle = bookCard?.querySelector('h3')?.textContent || 'Buku';

                        if (bookImage) {
                            window.flyToCart(bookImage, bookTitle);
                        }

                        const response = await fetch(`/cart/add/${bookId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                quantity: 1
                            })
                        });

                        const data = await response.json();
                        if (data.success) {
                            window.dispatchEvent(new CustomEvent('cart-updated'));
                            // Don't show duplicate toast since flyToCart already shows one
                        }
                    } catch (error) {
                        console.error('Error adding to cart:', error);
                        window.showToast('error', 'Gagal menambahkan ke keranjang');
                    }
                },

                async toggleWishlist(bookId, event) {
                    event.stopPropagation();

                    console.log('💝 Toggling wishlist for book:', bookId);
                    console.log('Current wishlist:', this.wishlistBooks);

                    try {
                        const response = await fetch('/wishlist/toggle', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                book_id: bookId
                            })
                        });

                        if (!response.ok) {
                            const errorText = await response.text();
                            console.error('❌ Response not OK:', response.status, errorText);
                            throw new Error(`HTTP ${response.status}: ${errorText}`);
                        }

                        const data = await response.json();
                        console.log('✅ Wishlist response:', data);

                        if (data.success) {
                            if (data.action === 'added') {
                                this.wishlistBooks.push(bookId);
                                console.log('➕ Added to wishlist');
                            } else {
                                const index = this.wishlistBooks.indexOf(bookId);
                                if (index > -1) {
                                    this.wishlistBooks.splice(index, 1);
                                    console.log('➖ Removed from wishlist');
                                }
                            }

                            // Update quick view if open
                            if (this.quickViewBook && this.quickViewBook.id === bookId) {
                                this.quickViewBook.in_wishlist = data.action === 'added';
                            }

                            // Flying heart animation
                            if (data.action === 'added' && typeof window.flyToWishlist === 'function') {
                                const bookCard = event.target.closest('.group, .relative');
                                const bookTitle = bookCard?.querySelector('h3')?.textContent || 'Buku';
                                window.flyToWishlist(event.target, bookTitle);
                            } else {
                                window.showToast('success', data.message);
                            }
                        } else {
                            console.error('❌ Success false:', data);
                            throw new Error(data.message || 'Unknown error');
                        }
                    } catch (error) {
                        console.error('❌ Error toggling wishlist:', error);
                        window.showToast('error', error.message || 'Gagal memperbarui wishlist');
                    }
                }
            };
        }
    </script>
@endsection
