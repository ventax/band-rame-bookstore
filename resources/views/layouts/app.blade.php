<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BandRame - Toko Buku Anak-Anak Seru & Edukatif!')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        .font-display {
            font-family: 'Poppins', 'Nunito', sans-serif;
        }

        /* Rainbow gradient background */
        .gradient-bg {
            background: linear-gradient(135deg, #93c5fd 0%, #ddd6fe 50%, #fbcfe8 100%);
        }

        /* Colorful glass effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-bottom: 4px solid rgba(147, 197, 253, 0.4);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Playful hover effects */
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            bottom: -5px;
            left: 50%;
            background: linear-gradient(90deg, #93c5fd, #a78bfa, #f9a8d4);
            border-radius: 10px;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 100%;
        }

        /* Bouncy float animation */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            25% {
                transform: translateY(-5px) rotate(-5deg);
            }

            50% {
                transform: translateY(-10px) rotate(0deg);
            }

            75% {
                transform: translateY(-5px) rotate(5deg);
            }
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        /* Fun wiggle animation */
        @keyframes wiggle {

            0%,
            100% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(-10deg);
            }

            75% {
                transform: rotate(10deg);
            }
        }

        .wiggle-animation:hover {
            animation: wiggle 0.5s ease-in-out;
        }

        /* Rainbow pulse */
        @keyframes rainbowPulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(147, 197, 253, 0.7);
            }

            50% {
                transform: scale(1.1);
                box-shadow: 0 0 0 10px rgba(147, 197, 253, 0);
            }

            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(147, 197, 253, 0);
            }
        }

        .pulse-animation {
            animation: rainbowPulse 2s ease-in-out infinite;
        }

        /* Star sparkle */
        @keyframes sparkle {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.5;
                transform: scale(1.2);
            }
        }

        .sparkle {
            animation: sparkle 1.5s ease-in-out infinite;
        }

        /* Rainbow scrollbar */
        ::-webkit-scrollbar {
            width: 12px;
        }

        ::-webkit-scrollbar-track {
            background: #fef9e7;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #93c5fd 0%, #c4b5fd 50%, #f9a8d4 100%);
            border-radius: 10px;
            border: 2px solid #fff;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 50%, #f472b6 100%);
        }
    </style>

    @stack('styles')
</head>

<body class="font-sans antialiased bg-gradient-to-br from-yellow-50 via-pink-50 to-blue-50 min-h-screen">
    <!-- Fun decorative elements -->
    <div class="fixed top-10 left-10 w-20 h-20 bg-kidYellow-300 rounded-full opacity-20 blur-2xl wiggle-animation">
    </div>
    <div class="fixed top-32 right-20 w-32 h-32 bg-kidBlue-300 rounded-full opacity-20 blur-2xl float-animation"></div>
    <div class="fixed bottom-20 left-1/3 w-24 h-24 bg-kidGreen-300 rounded-full opacity-20 blur-2xl sparkle"></div>

    <!-- Navbar -->
    <nav class="glass-effect sticky top-0 z-50 shadow-md" x-data="{ mobileMenu: false }">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-14">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2 group wiggle-animation">
                        <div
                            class="bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 p-2.5 rounded-2xl shadow-fun transform transition hover:scale-110">
                            <i class="fas fa-book-reader text-xl text-white"></i>
                        </div>
                        <div class="hidden sm:block">
                            <span
                                class="text-2xl font-bold bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 bg-clip-text text-transparent font-display">BandRame</span>
                            <p class="text-xs text-blue-600 font-semibold -mt-1">Toko Buku Anak</p>
                        </div>
                    </a>
                </div>

                <!-- Search Bar (Desktop) -->
                <div class="hidden md:flex flex-1 max-w-xl mx-4" x-data="liveSearch()"
                    @click.away="showResults = false">
                    <div class="w-full relative">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400 text-sm"></i>
                            </div>
                            <input type="text" x-model="searchQuery" @input.debounce.300ms="search()"
                                @focus="if(searchQuery.length >= 2) showResults = true" placeholder="Cari buku seru..."
                                class="w-full pl-9 pr-3 py-2.5 text-sm rounded-2xl border-2 border-blue-200 focus:border-pink-400 focus:ring-4 focus:ring-pink-100 outline-none transition-all bg-white shadow-sm font-medium">
                            <div x-show="loading" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-spinner fa-spin text-purple-600 text-xs"></i>
                            </div>
                        </div>

                        <!-- Live Search Results -->
                        <div x-show="showResults && results.length > 0" x-cloak
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="absolute top-full mt-1 w-full bg-white rounded-lg shadow-xl border border-gray-200 overflow-hidden z-50 max-h-80 overflow-y-auto">
                            <template x-for="book in results" :key="book.id">
                                <a :href="`/books/${book.slug}`"
                                    class="flex items-center p-2 hover:bg-gray-50 transition-colors">
                                    <img :src="book.image" :alt="book.title"
                                        class="w-10 h-14 object-cover rounded">
                                    <div class="ml-2 flex-1 min-w-0">
                                        <h4 class="font-medium text-gray-900 text-xs truncate" x-text="book.title"></h4>
                                        <p class="text-xs text-gray-500 truncate" x-text="book.author"></p>
                                        <p class="text-xs font-bold text-purple-600 mt-0.5" x-text="book.price"></p>
                                    </div>
                                </a>
                            </template>
                            <div class="border-t border-gray-200 p-2 bg-gray-50">
                                <a :href="`/books?search=${searchQuery}`"
                                    class="block text-center text-xs text-purple-600 hover:text-purple-700 font-medium">
                                    Lihat semua hasil →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Links - Hidden on Mobile -->
                <div class="hidden lg:flex items-center space-x-1">
                    <a href="{{ route('home') }}"
                        class="px-4 py-2 text-sm font-bold rounded-2xl transition-all transform hover:scale-105 {{ request()->routeIs('home') ? 'bg-gradient-to-r from-blue-400 to-purple-400 text-white shadow-fun' : 'text-gray-700 hover:bg-blue-100' }}">
                        Beranda
                    </a>
                    <a href="{{ route('books.index') }}"
                        class="px-4 py-2 text-sm font-bold rounded-2xl transition-all transform hover:scale-105 {{ request()->routeIs('books.*') ? 'bg-gradient-to-r from-purple-400 to-pink-400 text-white shadow-fun' : 'text-gray-700 hover:bg-purple-100' }}">
                        Katalog
                    </a>
                    @auth
                        <a href="{{ route('orders.index') }}"
                            class="px-4 py-2 text-sm font-bold rounded-2xl transition-all transform hover:scale-105 {{ request()->routeIs('orders.*') ? 'bg-gradient-to-r from-pink-400 to-rose-400 text-white shadow-fun' : 'text-gray-700 hover:bg-pink-100' }}">
                            Pesanan
                        </a>
                    @endauth
                </div>

                <!-- Right Side -->
                <div class="flex items-center space-x-2">
                    @auth
                        @if (Auth::user()->role !== 'admin')
                            <!-- Wishlist -->
                            <a href="{{ route('wishlist.index') }}"
                                class="relative p-2.5 bg-gradient-to-r from-pink-100 to-red-100 rounded-2xl text-red-500 hover:from-red-400 hover:to-pink-400 hover:text-white transition-all transform hover:scale-110 shadow-sm wiggle-animation hidden sm:block">
                                <i class="fas fa-heart text-lg"></i>
                            </a>

                            <!-- Cart -->
                            <a href="{{ route('cart.index') }}" id="cart-icon"
                                class="relative p-2.5 bg-gradient-to-r from-blue-100 to-purple-100 rounded-2xl text-purple-600 hover:from-blue-400 hover:to-purple-400 hover:text-white transition-all transform hover:scale-110 shadow-sm wiggle-animation hidden sm:block">
                                <i class="fas fa-shopping-cart text-lg"></i>
                                <span id="cart-count"
                                    class="absolute -top-1 -right-1 bg-gradient-to-r from-pink-400 to-rose-500 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center pulse-animation shadow-lg">
                                    0
                                </span>
                            </a>
                        @endif

                        <!-- User Menu -->
                        <div class="relative hidden sm:block" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center space-x-2 p-2 rounded-2xl bg-gradient-to-r from-blue-100 to-purple-100 hover:from-blue-200 hover:to-purple-200 transition-all transform hover:scale-105 focus:outline-none shadow-sm">
                                <div
                                    class="w-9 h-9 bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 rounded-full flex items-center justify-center shadow-md">
                                    <span
                                        class="text-white font-bold text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                </div>
                                <span
                                    class="hidden lg:inline text-sm font-bold text-gray-700">{{ Str::limit(Auth::user()->name, 12) }}</span>
                                <i class="fas fa-chevron-down text-xs text-gray-600"></i>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-playful py-2 z-50 border-4 border-kidYellow-200">
                                <div
                                    class="px-4 py-3 border-b-2 border-kidYellow-100 bg-gradient-to-r from-kidPurple-50 to-pink-50 rounded-t-xl">
                                    <p class="text-sm font-bold text-gray-800 truncate">👋 {{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-600 truncate">{{ Auth::user()->email }}</p>
                                </div>

                                @if (Auth::user()->role === 'admin')
                                    <!-- Menu untuk Admin -->
                                    <a href="{{ route('admin.dashboard') }}" @click="open = false"
                                        class="flex items-center px-3 py-2 text-xs text-purple-600 hover:bg-purple-50 transition-colors font-medium">
                                        <i class="fas fa-tachometer-alt w-4"></i>
                                        <span class="ml-2">Admin Dashboard</span>
                                    </a>
                                    <a href="{{ route('admin.books.index') }}" @click="open = false"
                                        class="flex items-center px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-book w-4 text-gray-500"></i>
                                        <span class="ml-2">Kelola Buku</span>
                                    </a>
                                    <a href="{{ route('admin.categories.index') }}" @click="open = false"
                                        class="flex items-center px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-tags w-4 text-gray-500"></i>
                                        <span class="ml-2">Kelola Kategori</span>
                                    </a>
                                    <a href="{{ route('admin.orders.index') }}" @click="open = false"
                                        class="flex items-center px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-shopping-bag w-4 text-gray-500"></i>
                                        <span class="ml-2">Kelola Pesanan</span>
                                    </a>
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <a href="{{ route('home') }}" @click="open = false"
                                        class="flex items-center px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-store w-4 text-gray-500"></i>
                                        <span class="ml-2">Lihat Toko</span>
                                    </a>
                                @else
                                    <!-- Menu untuk Customer -->
                                    <a href="{{ route('profile.edit') }}"
                                        class="flex items-center px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-user-edit w-4 text-gray-500"></i>
                                        <span class="ml-2">Profil</span>
                                    </a>
                                    <a href="{{ route('orders.index') }}" @click="open = false"
                                        class="flex items-center px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-box w-4 text-gray-500"></i>
                                        <span class="ml-2">Pesanan</span>
                                    </a>
                                    <a href="{{ route('addresses.index') }}" @click="open = false"
                                        class="flex items-center px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-map-marker-alt w-4 text-gray-500"></i>
                                        <span class="ml-2">Alamat Saya</span>
                                    </a>
                                @endif

                                <div class="border-t border-gray-100"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center px-3 py-2 text-xs text-red-600 hover:bg-red-50 transition-colors">
                                        <i class="fas fa-sign-out-alt w-4"></i>
                                        <span class="ml-2">Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="hidden sm:inline-flex px-5 py-2.5 text-sm font-bold bg-gradient-to-r from-blue-400 to-purple-400 text-white rounded-2xl hover:from-blue-500 hover:to-purple-500 transition-all transform hover:scale-105 shadow-fun">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                            class="hidden sm:inline-flex px-5 py-2.5 text-sm font-bold bg-gradient-to-r from-purple-400 to-pink-400 text-white rounded-2xl hover:from-purple-500 hover:to-pink-500 transition-all transform hover:scale-105 shadow-fun">
                            Daftar
                        </a>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenu = !mobileMenu"
                        class="md:hidden p-2 text-gray-700 hover:text-purple-600 focus:outline-none transition-colors">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenu" @click.away="mobileMenu = false" x-transition
                class="md:hidden border-t border-gray-200 bg-white shadow-lg">

                <!-- Mobile Search -->
                <div class="px-3 py-2">
                    <form action="{{ route('books.index') }}" method="GET">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400 text-sm"></i>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari buku..."
                                class="w-full pl-9 pr-3 py-2 text-sm rounded-lg border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-100 outline-none transition-all bg-white">
                        </div>
                    </form>
                </div>

                <!-- Navigation Menu -->
                <div class="px-3 py-2">
                    <a href="{{ route('home') }}"
                        class="flex items-center py-2 px-3 text-sm rounded-lg text-gray-700 hover:bg-gray-50 transition-colors {{ request()->routeIs('home') ? 'bg-gray-100 text-purple-600 font-medium' : '' }}">
                        <i class="fas fa-home w-4 text-gray-500"></i>
                        <span class="ml-2">Beranda</span>
                    </a>
                    <a href="{{ route('books.index') }}"
                        class="flex items-center py-2 px-3 text-sm rounded-lg text-gray-700 hover:bg-gray-50 transition-colors {{ request()->routeIs('books.*') ? 'bg-gray-100 text-purple-600 font-medium' : '' }}">
                        <i class="fas fa-book w-4 text-gray-500"></i>
                        <span class="ml-2">Katalog</span>
                    </a>

                    @auth
                        <a href="{{ route('cart.index') }}"
                            class="flex items-center py-2 px-3 text-sm rounded-lg text-gray-700 hover:bg-gray-50 transition-colors {{ request()->routeIs('cart.*') ? 'bg-gray-100 text-purple-600 font-medium' : '' }}">
                            <i class="fas fa-shopping-cart w-4 text-gray-500"></i>
                            <span class="ml-2">Keranjang</span>
                            <span id="mobile-cart-count"
                                class="ml-auto bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">0</span>
                        </a>
                        <a href="{{ route('wishlist.index') }}"
                            class="flex items-center py-2 px-3 text-sm rounded-lg text-gray-700 hover:bg-gray-50 transition-colors {{ request()->routeIs('wishlist.*') ? 'bg-gray-100 text-purple-600 font-medium' : '' }}">
                            <i class="fas fa-heart w-4 text-red-500"></i>
                            <span class="ml-2">Wishlist</span>
                        </a>
                        <a href="{{ route('orders.index') }}"
                            class="flex items-center py-2 px-3 text-sm rounded-lg text-gray-700 hover:bg-gray-50 transition-colors {{ request()->routeIs('orders.*') ? 'bg-gray-100 text-purple-600 font-medium' : '' }}">
                            <i class="fas fa-box w-4 text-gray-500"></i>
                            <span class="ml-2">Pesanan</span>
                        </a>
                        <a href="{{ route('addresses.index') }}"
                            class="flex items-center py-2 px-3 text-sm rounded-lg text-gray-700 hover:bg-gray-50 transition-colors {{ request()->routeIs('addresses.*') ? 'bg-gray-100 text-purple-600 font-medium' : '' }}">
                            <i class="fas fa-map-marker-alt w-4 text-gray-500"></i>
                            <span class="ml-2">Alamat Saya</span>
                        </a>

                        <div class="border-t border-gray-200 mt-2 pt-2">
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center py-2 px-3 text-sm rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-user-edit w-4 text-gray-500"></i>
                                <span class="ml-2">Profil</span>
                            </a>
                            @if (Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}"
                                    class="flex items-center py-2 px-3 text-sm rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-cog w-4 text-gray-500"></i>
                                    <span class="ml-2">Admin</span>
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center py-2 px-3 text-sm rounded-lg text-red-600 hover:bg-red-50 transition-colors">
                                    <i class="fas fa-sign-out-alt w-4"></i>
                                    <span class="ml-2">Logout</span>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="border-t border-gray-200 mt-2 pt-2 space-y-2 px-3">
                            <a href="{{ route('login') }}"
                                class="flex items-center justify-center py-2 text-sm rounded-lg text-gray-700 border border-gray-300 hover:bg-gray-50 transition-colors font-medium">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}"
                                class="flex items-center justify-center py-2 text-sm rounded-lg bg-gradient-to-r from-purple-600 to-pink-600 text-white font-medium hover:shadow-lg transition-all">
                                Daftar
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6" x-data="{ show: true }" x-show="show" x-transition>
            <div
                class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-xl shadow-lg flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="bg-green-500 rounded-full p-2">
                        <i class="fas fa-check text-white"></i>
                    </div>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-green-600 hover:text-green-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6" x-data="{ show: true }" x-show="show" x-transition>
            <div
                class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 text-red-800 px-6 py-4 rounded-xl shadow-lg flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="bg-red-500 rounded-full p-2">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
                <button @click="show = false" class="text-red-600 hover:text-red-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="relative bg-gradient-to-br from-gray-900 via-purple-900 to-gray-900 text-white mt-20">
        <!-- Decorative wave -->
        <div class="absolute top-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" class="w-full h-12 fill-current text-purple-50">
                <path
                    d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,58.7C960,64,1056,64,1152,58.7C1248,53,1344,43,1392,37.3L1440,32L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z">
                </path>
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <!-- About -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-3 rounded-lg">
                            <i class="fas fa-book-open text-2xl text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-display font-bold">BandRame</h3>
                            <p class="text-sm text-gray-400">Jendela Dunia Lewat Buku</p>
                        </div>
                    </div>
                    <p class="text-gray-300 mb-6 leading-relaxed">
                        Toko buku online terpercaya dengan koleksi lengkap dan harga terbaik. Kami berkomitmen
                        memberikan pengalaman berbelanja buku yang menyenangkan dan mudah untuk semua kalangan.
                    </p>
                    <div class="flex space-x-3">
                        <a href="#"
                            class="w-10 h-10 bg-white/10 hover:bg-gradient-to-r hover:from-purple-500 hover:to-pink-500 rounded-full flex items-center justify-center transition-all transform hover:scale-110">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-white/10 hover:bg-gradient-to-r hover:from-purple-500 hover:to-pink-500 rounded-full flex items-center justify-center transition-all transform hover:scale-110">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-white/10 hover:bg-gradient-to-r hover:from-purple-500 hover:to-pink-500 rounded-full flex items-center justify-center transition-all transform hover:scale-110">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-white/10 hover:bg-gradient-to-r hover:from-purple-500 hover:to-pink-500 rounded-full flex items-center justify-center transition-all transform hover:scale-110">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-display font-bold mb-6 text-lg">Navigasi Cepat</h4>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('home') }}"
                                class="text-gray-300 hover:text-white flex items-center space-x-2 group transition-all">
                                <i
                                    class="fas fa-chevron-right text-xs text-purple-400 group-hover:translate-x-1 transition-transform"></i>
                                <span>Beranda</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('books.index') }}"
                                class="text-gray-300 hover:text-white flex items-center space-x-2 group transition-all">
                                <i
                                    class="fas fa-chevron-right text-xs text-purple-400 group-hover:translate-x-1 transition-transform"></i>
                                <span>Katalog</span>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="text-gray-300 hover:text-white flex items-center space-x-2 group transition-all">
                                <i
                                    class="fas fa-chevron-right text-xs text-purple-400 group-hover:translate-x-1 transition-transform"></i>
                                <span>Tentang Kami</span>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="text-gray-300 hover:text-white flex items-center space-x-2 group transition-all">
                                <i
                                    class="fas fa-chevron-right text-xs text-purple-400 group-hover:translate-x-1 transition-transform"></i>
                                <span>Promo & Diskon</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="font-display font-bold mb-6 text-lg">Hubungi Kami</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start space-x-3">
                            <div class="bg-purple-500/20 p-2 rounded-lg mt-1">
                                <i class="fas fa-envelope text-purple-400"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">Email</p>
                                <a href="mailto:info@bandrame.com"
                                    class="text-gray-200 hover:text-white">info@bandrame.com</a>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <div class="bg-purple-500/20 p-2 rounded-lg mt-1">
                                <i class="fas fa-phone text-purple-400"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">Telepon</p>
                                <a href="tel:+62123456789" class="text-gray-200 hover:text-white">+62 123 456 789</a>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <div class="bg-purple-500/20 p-2 rounded-lg mt-1">
                                <i class="fas fa-map-marker-alt text-purple-400"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">Alamat</p>
                                <p class="text-gray-200">Jakarta, Indonesia</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Newsletter -->
            <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-8 mb-8 border border-white/10">
                <div class="max-w-2xl mx-auto text-center">
                    <h4 class="font-display font-bold text-2xl mb-2">Dapatkan Update Terbaru</h4>
                    <p class="text-gray-300 mb-6">Subscribe newsletter kami untuk info promo dan buku-buku terbaru</p>
                    <form class="flex gap-3 max-w-md mx-auto">
                        <input type="email" placeholder="Masukkan email Anda..."
                            class="flex-1 px-6 py-3 rounded-full bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:border-purple-400 transition-all">
                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full font-semibold hover:shadow-xl transition-all transform hover:scale-105 whitespace-nowrap">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div
                class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <p class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} <span class="font-semibold text-white">BandRame</span>. All rights
                    reserved.
                </p>
                <div class="flex items-center space-x-6 text-sm">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">Kebijakan Privasi</a>
                    <span class="text-gray-600">•</span>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">Syarat & Ketentuan</a>
                    <span class="text-gray-600">•</span>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">FAQ</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Toast Notification Component -->
    @include('components.toast')

    <!-- Slide-over Cart Component -->
    @auth
        @include('components.slide-over-cart')
    @endauth

    @stack('scripts')

    <script>
        // Live Search Function
        function liveSearch() {
            return {
                searchQuery: '',
                results: [],
                showResults: false,
                loading: false,

                async search() {
                    console.log('🔍 Search query:', this.searchQuery);

                    if (this.searchQuery.length < 2) {
                        this.results = [];
                        this.showResults = false;
                        console.log('❌ Query too short');
                        return;
                    }

                    this.loading = true;
                    try {
                        const url = `/search?q=${encodeURIComponent(this.searchQuery)}`;
                        console.log('📡 Fetching:', url);

                        const response = await fetch(url, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP ${response.status}`);
                        }

                        const data = await response.json();
                        console.log('✅ Results:', data);

                        this.results = Array.isArray(data) ? data : [];
                        this.showResults = this.results.length > 0;

                        console.log(`📊 Found ${this.results.length} results, showing: ${this.showResults}`);
                    } catch (error) {
                        console.error('❌ Search error:', error);
                        this.results = [];
                        this.showResults = false;
                    } finally {
                        this.loading = false;
                    }
                }
            };
        }

        // Update cart count on page load
        @auth
        fetch('{{ route('cart.count') }}')
            .then(response => response.json())
            .then(data => {
                const cartCountElements = document.querySelectorAll('#cart-count, #mobile-cart-count');
                cartCountElements.forEach(el => {
                    el.textContent = data.count;
                });
            });
        @endauth

        // Back to top button
        window.addEventListener('scroll', function() {
            const backToTop = document.getElementById('back-to-top');
            if (backToTop) {
                if (window.pageYOffset > 300) {
                    backToTop.classList.remove('hidden');
                } else {
                    backToTop.classList.add('hidden');
                }
            }
        });
    </script>

    <!-- Back to Top Button -->
    <button id="back-to-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
        class="hidden fixed bottom-4 right-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white p-4 rounded-full shadow-2xl hover:shadow-3xl transition-all transform hover:scale-110 z-40">
        <i class="fas fa-arrow-up text-xl"></i>
    </button>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</body>

</html>
