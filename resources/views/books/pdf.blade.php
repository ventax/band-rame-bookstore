@extends('layouts.app')

@section('title', 'Preview PDF - ' . $book->title)

@section('content')
    <div class="bg-gray-100 min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $book->title }}</h1>
                        <p class="text-gray-600">
                            <i class="fas fa-user mr-2"></i>{{ $book->author }}
                            <span class="mx-2">•</span>
                            <i class="fas fa-building mr-2"></i>{{ $book->publisher }}
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ asset('storage/' . $book->pdf_file) }}" download="{{ $book->title }}.pdf"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold rounded-lg transition-all transform hover:scale-105 shadow-lg">
                            <i class="fas fa-download mr-2"></i>Download PDF
                        </a>
                        <a href="{{ route('books.show', $book->slug) }}"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-bold rounded-lg transition-all transform hover:scale-105 shadow-lg">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Detail Buku
                        </a>
                    </div>
                </div>
            </div>

            <!-- PDF Viewer -->
            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="aspect-[8.5/11] w-full">
                    <iframe src="{{ asset('storage/' . $book->pdf_file) }}"
                        class="w-full h-full rounded-lg border-2 border-gray-200" style="min-height: 800px;"
                        frameborder="0">
                        <p class="text-center text-gray-500 p-8">
                            Browser Anda tidak mendukung tampilan PDF.
                            <a href="{{ asset('storage/' . $book->pdf_file) }}" download
                                class="text-purple-600 hover:underline">
                                Klik di sini untuk download
                            </a>
                        </p>
                    </iframe>
                </div>
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border-l-4 border-blue-400 p-6 mt-6 rounded-r-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-bold text-blue-900 mb-2">Informasi Preview PDF</h3>
                        <ul class="list-disc list-inside text-blue-700 space-y-1">
                            <li>Ini adalah preview/sample dari buku <strong>{{ $book->title }}</strong></li>
                            <li>Anda dapat mendownload file PDF ini menggunakan tombol download di atas</li>
                            <li>Untuk mendapatkan buku lengkap, silakan lakukan pembelian</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            @auth
                <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg shadow-lg p-8 mt-6 text-white text-center">
                    <h2 class="text-2xl font-bold mb-4">Tertarik dengan Buku Ini?</h2>
                    <p class="mb-6 text-purple-100">Dapatkan buku lengkapnya sekarang!</p>
                    <div class="flex justify-center gap-4">
                        <form action="{{ route('cart.add', $book->id) }}" method="POST" class="inline-block">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            @if ($book->stock > 0)
                                <button type="submit"
                                    class="inline-flex items-center px-8 py-4 bg-white text-purple-600 font-bold rounded-lg hover:bg-gray-100 transition-all transform hover:scale-105 shadow-lg">
                                    <i class="fas fa-shopping-cart mr-2"></i>Tambah ke Keranjang
                                </button>
                            @else
                                <button type="button" disabled
                                    class="inline-flex items-center px-8 py-4 bg-gray-400 text-white font-bold rounded-lg cursor-not-allowed opacity-50">
                                    <i class="fas fa-times-circle mr-2"></i>Stok Habis
                                </button>
                            @endif
                        </form>
                        <a href="{{ route('books.show', $book->slug) }}"
                            class="inline-flex items-center px-8 py-4 bg-purple-800 hover:bg-purple-900 text-white font-bold rounded-lg transition-all transform hover:scale-105 shadow-lg">
                            <i class="fas fa-book mr-2"></i>Lihat Detail Lengkap
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg shadow-lg p-8 mt-6 text-white text-center">
                    <h2 class="text-2xl font-bold mb-4">Tertarik dengan Buku Ini?</h2>
                    <p class="mb-6 text-purple-100">Login untuk membeli buku ini!</p>
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center px-8 py-4 bg-white text-purple-600 font-bold rounded-lg hover:bg-gray-100 transition-all transform hover:scale-105 shadow-lg">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login Sekarang
                    </a>
                </div>
            @endauth
        </div>
    </div>
@endsection
