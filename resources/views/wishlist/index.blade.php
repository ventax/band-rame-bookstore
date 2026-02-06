@extends('layouts.app')

@section('title', 'Wishlist Saya - BandRame')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-heart text-red-500 mr-2"></i>Wishlist Saya
                </h1>
                <p class="text-gray-600">Buku-buku favorit yang Anda simpan</p>
            </div>

            @if ($wishlists->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($wishlists as $wishlist)
                        <div
                            class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <div class="relative overflow-hidden">
                                @if ($wishlist->book->image)
                                    <img src="{{ asset('storage/' . $wishlist->book->image) }}"
                                        alt="{{ $wishlist->book->title }}"
                                        class="w-full h-72 object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div
                                        class="w-full h-72 bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center">
                                        <i class="fas fa-book text-purple-300 text-6xl"></i>
                                    </div>
                                @endif

                                <!-- Remove from Wishlist -->
                                <form action="{{ route('wishlist.destroy', $wishlist) }}" method="POST"
                                    class="absolute top-3 right-3">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-10 h-10 bg-white bg-opacity-90 hover:bg-opacity-100 rounded-full shadow-lg flex items-center justify-center transition-all transform hover:scale-110 text-red-500">
                                        <i class="fas fa-heart text-lg"></i>
                                    </button>
                                </form>
                            </div>

                            <div class="p-5">
                                <span class="text-xs text-purple-600 font-semibold bg-purple-50 px-3 py-1 rounded-full">
                                    {{ $wishlist->book->category->name }}
                                </span>
                                <h3
                                    class="font-bold text-gray-900 mt-3 mb-2 line-clamp-2 text-lg hover:text-purple-600 transition-colors">
                                    <a href="{{ route('books.show', $wishlist->book->slug) }}">
                                        {{ $wishlist->book->title }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-600 mb-3">
                                    <i class="fas fa-user text-gray-400 mr-1"></i>{{ $wishlist->book->author }}
                                </p>

                                <div class="flex justify-between items-center mb-4">
                                    <span
                                        class="text-xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                                        Rp {{ number_format($wishlist->book->price, 0, ',', '.') }}
                                    </span>
                                    @if ($wishlist->book->stock > 0)
                                        <span class="text-xs text-green-600 font-medium">
                                            <i class="fas fa-check-circle"></i> Tersedia
                                        </span>
                                    @else
                                        <span class="text-xs text-red-600 font-medium">
                                            <i class="fas fa-times-circle"></i> Habis
                                        </span>
                                    @endif
                                </div>

                                <a href="{{ route('books.show', $wishlist->book->slug) }}"
                                    class="block w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-semibold py-2.5 px-4 rounded-lg text-center transition-all transform hover:scale-105 hover:shadow-lg">
                                    <i class="fas fa-eye mr-2"></i>Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-xl shadow-lg p-16 text-center">
                    <i class="fas fa-heart-broken text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Wishlist Anda Kosong</h3>
                    <p class="text-gray-500 mb-6">Belum ada buku yang ditambahkan ke wishlist</p>
                    <a href="{{ route('books.index') }}"
                        class="inline-block bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-semibold py-3 px-8 rounded-lg transition-all transform hover:scale-105 hover:shadow-lg">
                        <i class="fas fa-book mr-2"></i>Jelajahi Buku
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
