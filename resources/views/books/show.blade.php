@extends('layouts.app')

@section('title', $book->title . ' - BandRame')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-8 text-sm">
                <ol class="flex items-center space-x-2 text-gray-600">
                    <li><a href="{{ route('home') }}" class="hover:text-primary-600">Home</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><a href="{{ route('books.index') }}" class="hover:text-primary-600">Katalog</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><a href="{{ route('books.index', ['category' => $book->category_id]) }}"
                            class="hover:text-primary-600">{{ $book->category->name }}</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li class="text-gray-900">{{ $book->title }}</li>
                </ol>
            </nav>

            <!-- Book Detail -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="grid md:grid-cols-2 gap-8 p-8">
                    <!-- Book Image -->
                    <div>
                        @if ($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                class="w-full rounded-lg shadow-lg">
                        @else
                            <div class="w-full h-96 bg-gray-300 flex items-center justify-center rounded-lg">
                                <i class="fas fa-book text-gray-500 text-8xl"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Book Info -->
                    <div x-data="{ quantity: 1 }">
                        @if ($book->is_featured)
                            <span
                                class="inline-block bg-yellow-400 text-gray-900 text-xs font-bold px-3 py-1 rounded-full mb-4">
                                <i class="fas fa-star"></i> Buku Pilihan
                            </span>
                        @endif

                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $book->title }}</h1>
                        <p class="text-gray-600 mb-4">oleh <span class="font-semibold">{{ $book->author }}</span></p>

                        <div class="flex items-center space-x-4 mb-6">
                            <span class="text-3xl font-bold text-primary-600">Rp
                                {{ number_format($book->price, 0, ',', '.') }}</span>
                            @if ($book->stock > 0)
                                <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">
                                    <i class="fas fa-check-circle"></i> Stok Tersedia ({{ $book->stock }})
                                </span>
                            @else
                                <span class="bg-red-100 text-red-800 text-sm px-3 py-1 rounded-full">
                                    <i class="fas fa-times-circle"></i> Stok Habis
                                </span>
                            @endif
                        </div>

                        <div class="border-t border-b border-gray-200 py-4 mb-6">
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Kategori:</span>
                                    <span class="font-semibold ml-2">{{ $book->category->name }}</span>
                                </div>
                                @if ($book->publisher)
                                    <div>
                                        <span class="text-gray-600">Penerbit:</span>
                                        <span class="font-semibold ml-2">{{ $book->publisher }}</span>
                                    </div>
                                @endif
                                @if ($book->isbn)
                                    <div>
                                        <span class="text-gray-600">ISBN:</span>
                                        <span class="font-semibold ml-2">{{ $book->isbn }}</span>
                                    </div>
                                @endif
                                @if ($book->pages)
                                    <div>
                                        <span class="text-gray-600">Halaman:</span>
                                        <span class="font-semibold ml-2">{{ $book->pages }}</span>
                                    </div>
                                @endif
                                <div>
                                    <span class="text-gray-600">Bahasa:</span>
                                    <span class="font-semibold ml-2">{{ $book->language }}</span>
                                </div>
                                @if ($book->published_year)
                                    <div>
                                        <span class="text-gray-600">Tahun Terbit:</span>
                                        <span class="font-semibold ml-2">{{ $book->published_year }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Add to Cart -->
                        @auth
                            @if ($book->stock > 0)
                                <div class="flex items-center space-x-4 mb-6">
                                    <div class="flex items-center border border-gray-300 rounded-lg">
                                        <button @click="quantity > 1 ? quantity-- : quantity"
                                            class="px-4 py-2 text-gray-600 hover:bg-gray-100">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" x-model="quantity" min="1" :max="{{ $book->stock }}"
                                            class="w-16 text-center border-x border-gray-300 py-2 focus:outline-none">
                                        <button @click="quantity < {{ $book->stock }} ? quantity++ : quantity"
                                            class="px-4 py-2 text-gray-600 hover:bg-gray-100">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>

                                    <button @click="addToCart({{ $book->id }}, quantity)" class="flex-1 btn-primary">
                                        <i class="fas fa-shopping-cart mr-2"></i> Tambah ke Keranjang
                                    </button>
                                </div>
                            @else
                                <div class="bg-gray-100 text-gray-600 text-center py-3 rounded-lg mb-6">
                                    Maaf, buku ini sedang tidak tersedia
                                </div>
                            @endif
                        @else
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                                <p class="text-yellow-800"><i class="fas fa-info-circle mr-2"></i> Silakan <a
                                        href="{{ route('login') }}" class="font-semibold underline">login</a> untuk membeli
                                    buku ini</p>
                            </div>
                        @endauth

                        <!-- Description -->
                        <div>
                            <h2 class="text-xl font-semibold mb-3">Deskripsi Buku</h2>
                            <p class="text-gray-700 leading-relaxed">{{ $book->description }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Books -->
            @if ($relatedBooks->count() > 0)
                <div class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Buku Terkait</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach ($relatedBooks as $relatedBook)
                            <div class="card group">
                                <a href="{{ route('books.show', $relatedBook->slug) }}" class="block">
                                    <div class="relative overflow-hidden">
                                        @if ($relatedBook->cover_image)
                                            <img src="{{ asset('storage/' . $relatedBook->cover_image) }}"
                                                alt="{{ $relatedBook->title }}"
                                                class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-64 bg-gray-300 flex items-center justify-center">
                                                <i class="fas fa-book text-gray-500 text-6xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ $relatedBook->title }}
                                        </h3>
                                        <p class="text-sm text-gray-600 mb-2">{{ $relatedBook->author }}</p>
                                        <span class="text-lg font-bold text-primary-600">Rp
                                            {{ number_format($relatedBook->price, 0, ',', '.') }}</span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    @auth
        @push('scripts')
            <script>
                function addToCart(bookId, quantity) {
                    fetch(`/cart/add/${bookId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                quantity: quantity
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message);
                                // Update cart count
                                window.location.reload();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                        });
                }
            </script>
        @endpush
    @endauth
@endsection
