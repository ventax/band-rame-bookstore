@extends('layouts.app')

@section('title', 'Home - BandRame')

@push('styles')
    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes slideInLeft {
            from {
                transform: translateX(-50px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideInRight {
            from {
                transform: translateX(50px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes scaleIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-slide-left {
            animation: slideInLeft 0.8s ease-out forwards;
        }

        .animate-slide-right {
            animation: slideInRight 0.8s ease-out forwards;
        }

        .animate-fade-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .animate-scale-in {
            animation: scaleIn 0.5s ease-out forwards;
        }

        .stagger-1 {
            animation-delay: 0.1s;
        }

        .stagger-2 {
            animation-delay: 0.2s;
        }

        .stagger-3 {
            animation-delay: 0.3s;
        }

        .stagger-4 {
            animation-delay: 0.4s;
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section with Parallax -->
    <section class="relative overflow-hidden bg-gradient-to-br from-purple-600 via-pink-500 to-blue-600"
        x-data="{ scrollY: 0 }" @scroll.window="scrollY = window.scrollY">
        <!-- Animated Background Patterns -->
        <div class="absolute inset-0 opacity-20">
            <div
                class="absolute top-0 left-0 w-96 h-96 bg-yellow-400 rounded-full mix-blend-multiply filter blur-3xl animate-float">
            </div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-pink-400 rounded-full mix-blend-multiply filter blur-3xl animate-float"
                style="animation-delay: 1s;"></div>
            <div class="absolute bottom-0 left-1/2 w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl animate-float"
                style="animation-delay: 2s;"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content with Staggered Animation -->
                <div class="text-white space-y-6">
                    <!-- Promo Badge -->
                    <div
                        class="animate-slide-left inline-flex items-center space-x-2 bg-white/20 backdrop-blur-lg px-4 py-2 rounded-full border border-white/30 shadow-xl">
                        <span class="relative flex h-3 w-3">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-300 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-yellow-300"></span>
                        </span>
                        <span class="text-sm font-bold">🎉 Promo Spesial Hari Ini!</span>
                    </div>

                    <h1 class="animate-slide-left stagger-1 text-5xl lg:text-7xl font-black leading-tight">
                        Jendela <span
                            class="bg-clip-text text-transparent bg-gradient-to-r from-yellow-300 to-orange-400">Dunia</span>
                        <br>Lewat Buku
                    </h1>

                    <p class="animate-slide-left stagger-2 text-xl lg:text-2xl text-white/90 leading-relaxed font-medium">
                        Ribuan koleksi buku dari berbagai genre dengan harga terjangkau dan kualitas terbaik
                    </p>

                    <!-- Stats dengan Animasi -->
                    <div class="animate-fade-up stagger-3 grid grid-cols-3 gap-4 pt-6">
                        <div
                            class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 hover:bg-white/20 transition-all transform hover:scale-105">
                            <div class="text-3xl lg:text-4xl font-black text-yellow-300">1000+</div>
                            <div class="text-sm text-white/90 font-medium">Judul Buku</div>
                        </div>
                        <div
                            class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 hover:bg-white/20 transition-all transform hover:scale-105">
                            <div class="text-3xl lg:text-4xl font-black text-yellow-300">50+</div>
                            <div class="text-sm text-white/90 font-medium">Kategori</div>
                        </div>
                        <div
                            class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 hover:bg-white/20 transition-all transform hover:scale-105">
                            <div class="text-3xl lg:text-4xl font-black text-yellow-300">10K+</div>
                            <div class="text-sm text-white/90 font-medium">Pelanggan</div>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="animate-fade-up stagger-4 flex flex-wrap gap-4 pt-6">
                        <a href="{{ route('books.index') }}"
                            class="group relative inline-flex items-center px-8 py-4 bg-white text-purple-700 rounded-2xl font-bold text-lg shadow-2xl hover:shadow-yellow-400/50 transition-all transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
                            <span class="relative z-10 flex items-center">
                                <i class="fas fa-shopping-bag mr-2"></i>
                                Mulai Belanja
                                <i class="fas fa-arrow-right ml-3 group-hover:translate-x-2 transition-transform"></i>
                            </span>
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-yellow-300 via-orange-300 to-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity">
                            </div>
                        </a>

                        <a href="#featured"
                            class="inline-flex items-center px-8 py-4 bg-white/10 backdrop-blur-lg text-white rounded-2xl font-bold text-lg border-2 border-white/40 hover:bg-white/20 hover:border-white/60 transition-all transform hover:scale-105">
                            <i class="fas fa-star mr-3 text-yellow-300"></i>
                            Lihat Koleksi
                        </a>
                    </div>
                </div>

                <!-- Right Image with Advanced Animation -->
                <div class="hidden lg:block relative animate-slide-right">
                    <!-- Floating Book Cards -->
                    <div class="relative">
                        <!-- Main Card -->
                        <div class="relative transform hover:rotate-0 transition-transform duration-700 rotate-3 z-20">
                            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=600&h=600&fit=crop"
                                    alt="Books Collection" class="w-full h-auto">
                                <div class="p-6 bg-gradient-to-br from-purple-600 to-pink-600 text-white">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm opacity-90 font-medium">Diskon Hingga</p>
                                            <p class="text-5xl font-black">50%</p>
                                        </div>
                                        <div class="bg-white/20 backdrop-blur-md p-4 rounded-2xl">
                                            <i class="fas fa-fire text-4xl text-yellow-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Elements -->
                        <div
                            class="absolute -top-8 -right-8 bg-yellow-400 p-6 rounded-2xl shadow-xl transform rotate-12 hover:rotate-0 transition-transform animate-float z-10">
                            <i class="fas fa-tag text-3xl text-white"></i>
                        </div>
                        <div class="absolute -bottom-8 -left-8 bg-pink-500 p-6 rounded-2xl shadow-xl transform -rotate-12 hover:rotate-0 transition-transform animate-float z-10"
                            style="animation-delay: 1s;">
                            <i class="fas fa-heart text-3xl text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wave Divider -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" class="w-full fill-current text-gray-50">
                <path
                    d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,58.7C960,64,1056,64,1152,58.7C1248,53,1344,43,1392,37.3L1440,32L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z">
                </path>
            </svg>
        </div>
    </section>

    <!-- Featured Books with Interactive Cards -->
    @if ($featuredBooks->count() > 0)
        <section id="featured" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center mb-12 animate-fade-up">
                    <div class="inline-block bg-purple-100 text-purple-600 px-4 py-2 rounded-full text-sm font-bold mb-4">
                        <i class="fas fa-star mr-2"></i>PILIHAN TERBAIK
                    </div>
                    <h2 class="text-4xl lg:text-5xl font-black text-gray-900 mb-4">
                        Buku <span
                            class="bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-pink-600">Pilihan
                            Editor</span>
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Koleksi buku terbaik yang dipilih khusus untuk Anda
                    </p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach ($featuredBooks as $index => $book)
                        <div class="group animate-scale-in stagger-{{ ($index % 4) + 1 }} opacity-0">
                            <a href="{{ route('books.show', $book->slug) }}" class="block">
                                <div
                                    class="bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-2">
                                    <div class="relative overflow-hidden aspect-[3/4]">
                                        @if ($book->cover_image)
                                            <img src="{{ asset('storage/' . $book->cover_image) }}"
                                                alt="{{ $book->title }}"
                                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                        @else
                                            <div
                                                class="w-full h-full bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center">
                                                <i class="fas fa-book text-purple-300 text-6xl"></i>
                                            </div>
                                        @endif
                                        <!-- Overlay -->
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        </div>

                                        <!-- Badge -->
                                        <span
                                            class="absolute top-3 right-3 bg-yellow-400 text-gray-900 text-xs font-black px-3 py-1.5 rounded-full shadow-lg transform group-hover:scale-110 transition-transform">
                                            <i class="fas fa-crown mr-1"></i>PILIHAN
                                        </span>

                                        <!-- Quick Actions -->
                                        <div
                                            class="absolute bottom-3 left-3 right-3 flex gap-2 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                            <button
                                                class="flex-1 bg-white text-purple-600 py-2 rounded-lg font-bold text-sm hover:bg-purple-600 hover:text-white transition-colors">
                                                <i class="fas fa-shopping-cart mr-1"></i>Beli
                                            </button>
                                            <button
                                                class="bg-white text-red-500 p-2 rounded-lg hover:bg-red-500 hover:text-white transition-colors">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <span
                                            class="inline-block text-xs font-bold text-purple-600 bg-purple-50 px-2 py-1 rounded-lg mb-2">
                                            {{ $book->category->name }}
                                        </span>
                                        <h3
                                            class="font-bold text-gray-900 mb-1 line-clamp-2 group-hover:text-purple-600 transition-colors">
                                            {{ $book->title }}
                                        </h3>
                                        <p class="text-sm text-gray-600 mb-3">{{ $book->author }}</p>
                                        <div class="flex justify-between items-center">
                                            <span
                                                class="text-xl font-black bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                                                Rp {{ number_format($book->price, 0, ',', '.') }}
                                            </span>
                                            @if ($book->stock > 0)
                                                <span
                                                    class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-full">
                                                    <i class="fas fa-check-circle"></i> Tersedia
                                                </span>
                                            @else
                                                <span
                                                    class="text-xs font-semibold text-red-600 bg-red-50 px-2 py-1 rounded-full">
                                                    <i class="fas fa-times-circle"></i> Habis
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- View All Button -->
                <div class="text-center mt-12 animate-fade-up stagger-4">
                    <a href="{{ route('books.index') }}"
                        class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-2xl font-bold text-lg shadow-xl hover:shadow-2xl transition-all transform hover:scale-105">
                        Lihat Semua Koleksi
                        <i class="fas fa-arrow-right ml-3"></i>
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Latest Books with Modern Design -->
    @if ($latestBooks->count() > 0)
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center mb-12 animate-fade-up">
                    <div class="inline-block bg-pink-100 text-pink-600 px-4 py-2 rounded-full text-sm font-bold mb-4">
                        <i class="fas fa-fire mr-2"></i>BARU DIRILIS
                    </div>
                    <h2 class="text-4xl lg:text-5xl font-black text-gray-900 mb-4">
                        Buku <span
                            class="bg-clip-text text-transparent bg-gradient-to-r from-pink-600 to-purple-600">Terbaru</span>
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Koleksi terbaru yang baru saja tiba untuk Anda
                    </p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach ($latestBooks as $index => $book)
                        <div class="group animate-fade-up stagger-{{ ($index % 4) + 1 }}">
                            <a href="{{ route('books.show', $book->slug) }}" class="block">
                                <div
                                    class="bg-white rounded-2xl shadow-lg overflow-hidden border-2 border-gray-100 hover:border-pink-300 transition-all duration-500 hover:shadow-2xl hover:-translate-y-2">
                                    <div class="relative overflow-hidden aspect-[3/4]">
                                        @if ($book->cover_image)
                                            <img src="{{ asset('storage/' . $book->cover_image) }}"
                                                alt="{{ $book->title }}"
                                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                        @else
                                            <div
                                                class="w-full h-full bg-gradient-to-br from-pink-100 to-purple-100 flex items-center justify-center">
                                                <i class="fas fa-book text-pink-300 text-6xl"></i>
                                            </div>
                                        @endif

                                        <!-- New Badge -->
                                        <span
                                            class="absolute top-3 left-3 bg-gradient-to-r from-pink-500 to-rose-500 text-white text-xs font-black px-3 py-1.5 rounded-full shadow-lg animate-pulse">
                                            <i class="fas fa-sparkles mr-1"></i>BARU
                                        </span>

                                        <!-- Hover Overlay -->
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                            <button
                                                class="w-full bg-white text-pink-600 py-2 rounded-lg font-bold hover:bg-pink-600 hover:text-white transition-colors transform translate-y-4 group-hover:translate-y-0">
                                                <i class="fas fa-eye mr-2"></i>Lihat Detail
                                            </button>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <span
                                            class="inline-block text-xs font-bold text-pink-600 bg-pink-50 px-2 py-1 rounded-lg mb-2">
                                            {{ $book->category->name }}
                                        </span>
                                        <h3
                                            class="font-bold text-gray-900 mb-1 line-clamp-2 group-hover:text-pink-600 transition-colors">
                                            {{ $book->title }}
                                        </h3>
                                        <p class="text-sm text-gray-600 mb-3">{{ $book->author }}</p>
                                        <div class="flex justify-between items-center">
                                            <span
                                                class="text-xl font-black bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent">
                                                Rp {{ number_format($book->price, 0, ',', '.') }}
                                            </span>
                                            @if ($book->stock > 0)
                                                <span
                                                    class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-full">
                                                    <i class="fas fa-check-circle"></i> Tersedia
                                                </span>
                                            @else
                                                <span
                                                    class="text-xs font-semibold text-red-600 bg-red-50 px-2 py-1 rounded-full">
                                                    <i class="fas fa-times-circle"></i> Habis
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- View All Button -->
                <div class="text-center mt-12 animate-fade-up stagger-4">
                    <a href="{{ route('books.index') }}"
                        class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-pink-600 to-purple-600 text-white rounded-2xl font-bold text-lg shadow-xl hover:shadow-2xl transition-all transform hover:scale-105">
                        Jelajahi Semua Buku
                        <i class="fas fa-compass ml-3"></i>
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Features Section with Modern Cards -->
    <section class="py-20 bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16 animate-fade-up">
                <h2 class="text-4xl lg:text-5xl font-black text-gray-900 mb-4">
                    Kenapa Pilih <span
                        class="bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-pink-600">BandRame</span>?
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Kami memberikan pengalaman berbelanja buku terbaik untuk Anda
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="animate-scale-in stagger-1 opacity-0">
                    <div
                        class="group bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border-2 border-purple-100 hover:border-purple-300">
                        <div class="relative inline-block mb-6">
                            <div
                                class="absolute inset-0 bg-purple-600 rounded-2xl blur-xl opacity-30 group-hover:opacity-50 transition-opacity">
                            </div>
                            <div class="relative bg-gradient-to-br from-purple-600 to-pink-600 rounded-2xl p-6">
                                <i class="fas fa-shipping-fast text-white text-5xl"></i>
                            </div>
                        </div>
                        <h3 class="text-2xl font-black text-gray-900 mb-3 group-hover:text-purple-600 transition-colors">
                            Pengiriman Kilat
                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            Pesanan Anda akan dikirim dengan cepat dalam waktu 1-3 hari kerja ke seluruh Indonesia
                        </p>
                        <div
                            class="mt-6 flex items-center text-purple-600 font-bold group-hover:translate-x-2 transition-transform">
                            Pelajari Lebih Lanjut <i class="fas fa-arrow-right ml-2"></i>
                        </div>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="animate-scale-in stagger-2 opacity-0">
                    <div
                        class="group bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border-2 border-pink-100 hover:border-pink-300">
                        <div class="relative inline-block mb-6">
                            <div
                                class="absolute inset-0 bg-pink-600 rounded-2xl blur-xl opacity-30 group-hover:opacity-50 transition-opacity">
                            </div>
                            <div class="relative bg-gradient-to-br from-pink-600 to-rose-600 rounded-2xl p-6">
                                <i class="fas fa-lock text-white text-5xl"></i>
                            </div>
                        </div>
                        <h3 class="text-2xl font-black text-gray-900 mb-3 group-hover:text-pink-600 transition-colors">
                            Pembayaran Aman
                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            Transaksi dijamin 100% aman dengan enkripsi SSL dan berbagai metode pembayaran terpercaya
                        </p>
                        <div
                            class="mt-6 flex items-center text-pink-600 font-bold group-hover:translate-x-2 transition-transform">
                            Pelajari Lebih Lanjut <i class="fas fa-arrow-right ml-2"></i>
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="animate-scale-in stagger-3 opacity-0">
                    <div
                        class="group bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border-2 border-blue-100 hover:border-blue-300">
                        <div class="relative inline-block mb-6">
                            <div
                                class="absolute inset-0 bg-blue-600 rounded-2xl blur-xl opacity-30 group-hover:opacity-50 transition-opacity">
                            </div>
                            <div class="relative bg-gradient-to-br from-blue-600 to-cyan-600 rounded-2xl p-6">
                                <i class="fas fa-headset text-white text-5xl"></i>
                            </div>
                        </div>
                        <h3 class="text-2xl font-black text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">
                            Support 24/7
                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            Tim customer service kami siap membantu Anda kapan saja dengan respons yang cepat dan ramah
                        </p>
                        <div
                            class="mt-6 flex items-center text-blue-600 font-bold group-hover:translate-x-2 transition-transform">
                            Pelajari Lebih Lanjut <i class="fas fa-arrow-right ml-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 relative overflow-hidden">
        <!-- Animated Background -->
        <div class="absolute inset-0 opacity-20">
            <div
                class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-float">
            </div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-yellow-300 rounded-full mix-blend-overlay filter blur-3xl animate-float"
                style="animation-delay: 2s;"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <div class="animate-fade-up">
                <h2 class="text-4xl lg:text-6xl font-black mb-6">
                    Siap Memulai Petualangan <br>Membaca Anda?
                </h2>
                <p class="text-xl lg:text-2xl mb-10 text-white/90">
                    Dapatkan diskon 20% untuk pembelian pertama Anda hari ini!
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('register') }}"
                        class="group relative inline-flex items-center px-10 py-5 bg-white text-purple-700 rounded-2xl font-black text-lg shadow-2xl hover:shadow-yellow-400/50 transition-all transform hover:scale-110 overflow-hidden">
                        <span class="relative z-10 flex items-center">
                            <i class="fas fa-user-plus mr-3"></i>
                            Daftar Sekarang
                        </span>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-yellow-300 via-orange-300 to-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity">
                        </div>
                    </a>
                    <a href="{{ route('books.index') }}"
                        class="inline-flex items-center px-10 py-5 bg-white/10 backdrop-blur-lg text-white rounded-2xl font-bold text-lg border-2 border-white/40 hover:bg-white/20 transition-all transform hover:scale-110">
                        <i class="fas fa-book-open mr-3"></i>
                        Lihat Katalog
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
