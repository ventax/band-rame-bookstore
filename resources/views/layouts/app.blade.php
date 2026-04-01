<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ATigaBookStore - Toko Buku Anak-Anak Seru & Edukatif!')</title>
    @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('logo/favicon.png'))
        <link rel="icon" type="image/png" href="{{ asset('storage/logo/favicon.png') }}">
    @elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists('logo/logo.png'))
        <link rel="icon" type="image/png" href="{{ asset('storage/logo/logo.png') }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            border: 0;
            background: #ffffff;
        }

        body {
            font-family: 'Nunito', sans-serif;
        }

        .font-display {
            font-family: 'Poppins', 'Nunito', sans-serif;
        }

        /* Blue-orange gradient background */
        .gradient-bg {
            background: linear-gradient(135deg, #93c5fd 0%, #bfdbfe 50%, #fed7aa 100%);
        }

        /* Colorful glass effect */
        .glass-effect {
            background: #ffffff;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
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
            background: linear-gradient(90deg, #60a5fa, #2563eb, #f97316);
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

        /* Elegant Logo Press Animation */
        @keyframes logoElegantPress {
            0% {
                transform: scale(1) translateY(0);
                filter: brightness(1);
            }

            20% {
                transform: scale(0.96) translateY(1px);
                filter: brightness(0.95);
            }

            55% {
                transform: scale(1.04) translateY(-2px);
                filter: brightness(1.1);
            }

            80% {
                transform: scale(1.01) translateY(-1px);
                filter: brightness(1.05);
            }

            100% {
                transform: scale(1) translateY(0);
                filter: brightness(1);
            }
        }

        @keyframes shimmerSweep {
            0% {
                background-position: 200% center;
            }

            100% {
                background-position: -200% center;
            }
        }

        .logo-link {
            transition: filter 0.3s ease, transform 0.3s ease;
        }

        .logo-link:hover {
            filter: brightness(1.08);
        }

        .logo-link:active {
            animation: logoElegantPress 0.55s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        .logo-link:active .logo-brand-text {
            background: linear-gradient(90deg, #1d4ed8, #93c5fd, #f97316, #93c5fd, #1d4ed8);
            background-size: 300% auto;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmerSweep 0.55s ease-out forwards;
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
            background: linear-gradient(135deg, #93c5fd 0%, #3b82f6 50%, #fb923c 100%);
            border-radius: 10px;
            border: 2px solid #fff;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #60a5fa 0%, #2563eb 50%, #f97316 100%);
        }
    </style>

    @stack('styles')
</head>

<body class="font-sans antialiased min-h-screen">
    <!-- Fun decorative elements -->
    <div class="fixed top-48 left-10 w-20 h-20 bg-orange-200 rounded-full opacity-20 blur-2xl wiggle-animation"></div>
    <div class="fixed top-64 right-20 w-32 h-32 bg-blue-300 rounded-full opacity-15 blur-2xl float-animation"></div>
    <div class="fixed bottom-20 left-1/3 w-24 h-24 bg-orange-300 rounded-full opacity-20 blur-2xl sparkle"></div>

    <!-- Navbar -->
    <nav class="glass-effect fixed top-0 left-0 right-0 z-50 shadow-md" style="z-index:1000;" x-data="{ mobileMenu: false, mobileMore: false }">
        <div class="max-w-7xl mx-auto px-4 lg:px-6">
            <div class="flex justify-between items-center h-12 md:h-14 lg:h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2 group logo-link">
                        @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('logo/logo.png'))
                            <img src="{{ asset('storage/logo/logo.png') }}" alt="Logo ATigaBookStore"
                                class="h-8 md:h-10 w-auto object-contain rounded-xl shadow-fun transform transition hover:scale-110">
                        @else
                            <div
                                class="bg-gradient-to-r from-blue-600 via-blue-500 to-orange-400 p-2 md:p-2.5 rounded-2xl shadow-fun transform transition hover:scale-110">
                                <i class="fas fa-book-reader text-base md:text-xl text-white"></i>
                            </div>
                        @endif
                        <div class="hidden sm:block">
                            <span
                                class="logo-brand-text text-2xl font-bold text-blue-700 font-display">ATigaBookStore</span>
                            <p class="text-xs text-blue-600 font-semibold -mt-1">Toko Buku Anak</p>
                        </div>
                    </a>
                </div>

                @if (request()->routeIs('books.index', 'orders.*'))
                    <div class="hidden md:flex flex-1 max-w-xl mx-4" aria-hidden="true"></div>
                @else
                    <!-- Search Bar (Desktop) -->
                    <div class="hidden md:flex flex-1 max-w-xl mx-4" x-data="liveSearch()"
                        @click.away="showResults = false">
                        <div class="w-full relative">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400 text-sm"></i>
                                </div>
                                <input type="text" x-model="searchQuery" @input.debounce.300ms="search()"
                                    @focus="if(searchQuery.length >= 2) showResults = true"
                                    placeholder="Cari buku seru..."
                                    class="w-full pl-9 pr-3 py-2.5 text-sm rounded-2xl border-2 border-blue-200 focus:border-orange-400 focus:ring-4 focus:ring-orange-100 outline-none transition-all bg-white shadow-sm font-medium">
                                <div x-show="loading" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fas fa-spinner fa-spin text-blue-600 text-xs"></i>
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
                                            <h4 class="font-medium text-gray-900 text-xs truncate" x-text="book.title">
                                            </h4>
                                            <p class="text-xs text-gray-500 truncate" x-text="book.author"></p>
                                            <p class="text-xs font-bold text-blue-600 mt-0.5" x-text="book.price"></p>
                                        </div>
                                    </a>
                                </template>
                                <div class="border-t border-gray-200 p-2 bg-gray-50">
                                    <a :href="`/books?search=${searchQuery}`"
                                        class="block text-center text-xs text-blue-600 hover:text-blue-700 font-medium">
                                        Lihat semua hasil →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Navigation Links - Hidden on Mobile -->
                <div class="hidden lg:flex items-center space-x-2 xl:space-x-3 pr-2 xl:pr-3 lg:mr-2 xl:mr-3">
                    <a href="{{ route('home') }}"
                        class="px-4 py-2 text-sm font-bold rounded-2xl transition-all transform hover:scale-105 {{ request()->routeIs('home') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-fun' : 'text-gray-700 hover:bg-blue-100' }}">
                        Beranda
                    </a>
                    <a href="{{ route('books.index') }}"
                        class="px-4 py-2 text-sm font-bold rounded-2xl transition-all transform hover:scale-105 {{ request()->routeIs('books.*') ? 'bg-blue-600 text-white shadow-fun' : 'text-gray-700 hover:bg-blue-50' }}">
                        Katalog
                    </a>
                    @auth
                        <a href="{{ route('orders.index') }}"
                            class="px-4 py-2 text-sm font-bold rounded-2xl transition-all transform hover:scale-105 lg:mr-5 xl:mr-7 {{ request()->routeIs('orders.*') ? 'bg-gradient-to-r from-orange-400 to-orange-500 text-white shadow-fun' : 'text-gray-700 hover:bg-orange-50' }}">
                            Pesanan
                        </a>
                    @endauth
                </div>

                <!-- Right Side -->
                <div class="flex items-center gap-2 lg:gap-4 xl:gap-5 lg:ml-8 xl:ml-10">
                    @auth
                        @if (Auth::user()->role !== 'admin')
                            <div class="hidden sm:block w-4 lg:w-6 xl:w-8 flex-shrink-0" aria-hidden="true"></div>

                            <!-- Wishlist -->
                            <a href="{{ route('wishlist.index') }}"
                                class="relative p-2.5 lg:p-3 bg-gradient-to-r from-orange-100 to-amber-100 rounded-2xl text-orange-500 hover:from-orange-400 hover:to-amber-500 hover:text-white transition-all transform hover:scale-110 shadow-sm hidden sm:block">
                                <i class="fas fa-heart text-lg wiggle-animation inline-block"></i>
                                <span id="wishlist-count"
                                    class="absolute -top-1 -right-1 bg-gradient-to-r from-orange-400 to-orange-600 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center pulse-animation shadow-lg"
                                    style="display:none;">0</span>
                            </a>

                            <!-- Cart -->
                            <a href="{{ route('cart.index') }}" id="cart-icon"
                                class="relative p-2.5 lg:p-3 bg-gradient-to-r from-blue-100 to-blue-200 rounded-2xl text-blue-600 hover:from-blue-500 hover:to-blue-600 hover:text-white transition-all transform hover:scale-110 shadow-sm hidden sm:block">
                                <i class="fas fa-shopping-cart text-lg wiggle-animation inline-block"></i>
                                <span id="cart-count"
                                    class="absolute -top-1 -right-1 bg-gradient-to-r from-orange-400 to-orange-600 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center pulse-animation shadow-lg">
                                    0
                                </span>
                            </a>
                        @endif

                        <!-- User Menu -->
                        <div class="relative hidden sm:block" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center space-x-2 p-2 lg:px-2.5 rounded-2xl bg-gradient-to-r from-blue-100 to-blue-200 hover:from-blue-200 hover:to-blue-300 transition-all transform hover:scale-105 focus:outline-none shadow-sm">
                                <div
                                    class="w-9 h-9 bg-gradient-to-r from-blue-600 via-blue-500 to-orange-400 rounded-full flex items-center justify-center shadow-md">
                                    <span
                                        class="text-white font-bold text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                </div>
                                <span
                                    class="hidden lg:inline text-sm font-bold text-gray-700">{{ Str::limit(Auth::user()->name, 10) }}</span>
                                <i class="fas fa-chevron-down text-xs text-gray-600"></i>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-playful py-2 z-50 border-4 border-blue-100">
                                <div
                                    class="px-4 py-3 border-b-2 border-blue-100 bg-gradient-to-r from-blue-50 to-orange-50 rounded-t-xl">
                                    <p class="text-sm font-bold text-gray-800 truncate">👋 {{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-600 truncate">{{ Auth::user()->email }}</p>
                                </div>

                                @if (Auth::user()->role === 'admin')
                                    <!-- Menu untuk Admin -->
                                    <a href="{{ route('admin.dashboard') }}" @click="open = false"
                                        class="flex items-center px-3 py-2 text-xs text-blue-600 hover:bg-blue-50 transition-colors font-medium">
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
                            class="hidden sm:inline-flex px-5 py-2.5 text-sm font-bold bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-2xl hover:from-blue-600 hover:to-blue-700 transition-all transform hover:scale-105 shadow-fun">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                            class="hidden sm:inline-flex px-5 py-2.5 text-sm font-bold bg-gradient-to-r from-orange-400 to-orange-500 text-white rounded-2xl hover:from-orange-500 hover:to-orange-600 transition-all transform hover:scale-105 shadow-fun">
                            Daftar
                        </a>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenu = !mobileMenu"
                        class="md:hidden p-1.5 text-gray-700 hover:text-blue-600 focus:outline-none transition-colors">
                        <i class="fas" :class="mobileMenu ? 'fa-xmark text-xl' : 'fa-bars text-xl'"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenu" @click.away="mobileMenu = false" x-transition
                class="md:hidden fixed left-2 right-2 border border-gray-200 bg-white rounded-2xl shadow-xl max-h-[70vh] overflow-y-auto"
                style="top:52px; z-index:1100;">

                <!-- Navigation Menu -->
                <div class="px-2 py-2">
                    <a href="{{ route('home') }}"
                        class="flex items-center py-1.5 px-2.5 text-[13px] rounded-lg text-slate-800 hover:bg-gray-50 transition-colors {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                        <i class="fas fa-home w-4 text-slate-700 text-xs"></i>
                        <span class="ml-2">Beranda</span>
                    </a>
                    <a href="{{ route('books.index') }}"
                        class="flex items-center py-1.5 px-2.5 text-[13px] rounded-lg text-slate-800 hover:bg-gray-50 transition-colors {{ request()->routeIs('books.*') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                        <i class="fas fa-book w-4 text-slate-700 text-xs"></i>
                        <span class="ml-2">Katalog</span>
                    </a>

                    @auth
                        <a href="{{ route('cart.index') }}"
                            class="flex items-center py-1.5 px-2.5 text-[13px] rounded-lg text-slate-800 hover:bg-gray-50 transition-colors {{ request()->routeIs('cart.*') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                            <i class="fas fa-shopping-cart w-4 text-slate-700 text-xs"></i>
                            <span class="ml-2">Keranjang</span>
                            <span id="mobile-cart-count"
                                class="ml-auto bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">0</span>
                        </a>
                        <a href="{{ route('wishlist.index') }}"
                            class="flex items-center py-1.5 px-2.5 text-[13px] rounded-lg text-slate-800 hover:bg-gray-50 transition-colors {{ request()->routeIs('wishlist.*') ? 'bg-orange-50 text-orange-500 font-medium' : '' }}">
                            <i class="fas fa-heart w-4 text-red-500 text-xs"></i>
                            <span class="ml-2">Wishlist</span>
                            <span id="mobile-wishlist-count"
                                class="ml-auto bg-gradient-to-r from-orange-400 to-orange-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center"
                                style="display:none;">0</span>
                        </a>
                        <a href="{{ route('orders.index') }}"
                            class="flex items-center py-1.5 px-2.5 text-[13px] rounded-lg text-slate-800 hover:bg-gray-50 transition-colors {{ request()->routeIs('orders.*') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                            <i class="fas fa-box w-4 text-slate-700 text-xs"></i>
                            <span class="ml-2">Pesanan</span>
                        </a>

                        <button type="button" @click="mobileMore = !mobileMore"
                            class="w-full flex items-center justify-between py-1.5 px-2.5 mt-1 text-[13px] rounded-lg text-slate-800 hover:bg-gray-50 transition-colors border border-gray-100">
                            <span class="flex items-center">
                                <i class="fas fa-ellipsis-h w-4 text-slate-700 text-xs"></i>
                                <span class="ml-2">Menu Lainnya</span>
                            </span>
                            <i class="fas text-[11px] text-slate-700"
                                :class="mobileMore ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                        </button>

                        <div x-show="mobileMore" x-transition x-cloak class="border-t border-gray-200 mt-1 pt-1.5">
                            <a href="{{ route('addresses.index') }}"
                                class="flex items-center py-1.5 px-2.5 text-[13px] rounded-lg text-slate-800 hover:bg-gray-50 transition-colors {{ request()->routeIs('addresses.*') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                                <i class="fas fa-map-marker-alt w-4 text-slate-700 text-xs"></i>
                                <span class="ml-2">Alamat Saya</span>
                            </a>
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center py-1.5 px-2.5 text-[13px] rounded-lg text-slate-800 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-user-edit w-4 text-slate-700 text-xs"></i>
                                <span class="ml-2">Profil</span>
                            </a>
                            @if (Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}"
                                    class="flex items-center py-1.5 px-2.5 text-[13px] rounded-lg text-slate-800 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-cog w-4 text-slate-700 text-xs"></i>
                                    <span class="ml-2">Admin</span>
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center py-1.5 px-2.5 text-[13px] rounded-lg text-red-600 hover:bg-red-50 transition-colors">
                                    <i class="fas fa-sign-out-alt w-4 text-xs"></i>
                                    <span class="ml-2">Logout</span>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="border-t border-gray-200 mt-1.5 pt-1.5 space-y-1.5 px-2.5">
                            <a href="{{ route('login') }}"
                                class="flex items-center justify-center py-1.5 text-[13px] rounded-lg text-slate-800 border border-gray-300 hover:bg-gray-50 transition-colors font-medium">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}"
                                class="flex items-center justify-center py-1.5 text-[13px] rounded-lg bg-gradient-to-r from-blue-600 to-orange-500 text-white font-medium hover:shadow-lg transition-all">
                                Daftar
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="bg-gradient-to-br from-blue-50 via-slate-50 to-orange-50 min-h-screen" style="padding-top: 30px;">

        <!-- Main Content -->
        <main class="min-h-screen @yield('mobile_main_padding', 'pb-20') md:pb-0">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer
            class="{{ request()->routeIs('home') ? 'block' : 'hidden md:block' }} relative bg-gradient-to-br from-gray-900 via-blue-900 to-gray-900 text-white mt-10 md:mt-20">
            <!-- Decorative wave -->
            <div class="absolute top-0 left-0 right-0">
                <svg viewBox="0 0 1440 120" class="w-full h-12 fill-current text-slate-50">
                    <path
                        d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,58.7C960,64,1056,64,1152,58.7C1248,53,1344,43,1392,37.3L1440,32L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z">
                    </path>
                </svg>
            </div>

            <div
                class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-14 {{ request()->routeIs('home') ? 'pb-24' : 'pb-8' }} md:py-16 relative">
                <!-- Mobile: 2-column grid for links & contact, About spans full width -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-12 mb-8 md:mb-12">
                    <!-- About: full width on mobile, 2 cols on desktop -->
                    <div class="col-span-2">
                        <div class="flex items-center space-x-3 mb-3">
                            @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('logo/logo.png'))
                                <img src="{{ asset('storage/logo/logo.png') }}" alt="Logo ATigaBookStore"
                                    class="h-10 md:h-12 w-auto object-contain rounded-xl">
                            @else
                                <div class="bg-blue-600 p-2 md:p-3 rounded-lg">
                                    <i class="fas fa-book-open text-xl md:text-2xl text-white"></i>
                                </div>
                            @endif
                            <div>
                                <h3 class="text-xl md:text-2xl font-display font-bold text-blue-400">
                                    {{ setting('store_name', 'ATigaBookStore') }}</h3>
                                <p class="text-xs md:text-sm text-gray-400">
                                    {{ setting('store_tagline', 'Jendela Dunia Lewat Buku') }}</p>
                            </div>
                        </div>
                        <p class="text-gray-300 mb-4 leading-relaxed text-sm hidden md:block">
                            {{ setting('store_description', 'Toko buku online terpercaya dengan koleksi lengkap dan harga terbaik. Kami berkomitmen memberikan pengalaman berbelanja buku yang menyenangkan dan mudah untuk semua kalangan.') }}
                        </p>
                        <div class="flex space-x-2 md:space-x-3">
                            <a href="{{ setting('social_facebook', '#') }}"
                                class="w-9 h-9 md:w-10 md:h-10 bg-white/10 hover:bg-gradient-to-r hover:from-blue-500 hover:to-orange-500 rounded-full flex items-center justify-center transition-all transform hover:scale-110">
                                <i class="fab fa-facebook-f text-sm"></i>
                            </a>
                            <a href="{{ setting('social_instagram', '#') }}"
                                class="w-9 h-9 md:w-10 md:h-10 bg-white/10 hover:bg-gradient-to-r hover:from-blue-500 hover:to-orange-500 rounded-full flex items-center justify-center transition-all transform hover:scale-110">
                                <i class="fab fa-instagram text-sm"></i>
                            </a>
                            <a href="{{ setting('social_twitter', '#') }}"
                                class="w-9 h-9 md:w-10 md:h-10 bg-white/10 hover:bg-gradient-to-r hover:from-blue-500 hover:to-orange-500 rounded-full flex items-center justify-center transition-all transform hover:scale-110">
                                <i class="fab fa-twitter text-sm"></i>
                            </a>
                            <a href="{{ setting('social_youtube', '#') }}"
                                class="w-9 h-9 md:w-10 md:h-10 bg-white/10 hover:bg-gradient-to-r hover:from-blue-500 hover:to-orange-500 rounded-full flex items-center justify-center transition-all transform hover:scale-110">
                                <i class="fab fa-youtube text-sm"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="font-display font-bold mb-4 md:mb-6 text-base md:text-lg">Navigasi</h4>
                        <ul class="space-y-2 md:space-y-3">
                            <li>
                                <a href="{{ route('home') }}"
                                    class="text-gray-300 hover:text-white flex items-center space-x-2 group transition-all text-sm">
                                    <i
                                        class="fas fa-chevron-right text-xs text-orange-400 group-hover:translate-x-1 transition-transform"></i>
                                    <span>Beranda</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('books.index') }}"
                                    class="text-gray-300 hover:text-white flex items-center space-x-2 group transition-all text-sm">
                                    <i
                                        class="fas fa-chevron-right text-xs text-orange-400 group-hover:translate-x-1 transition-transform"></i>
                                    <span>Katalog</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="text-gray-300 hover:text-white flex items-center space-x-2 group transition-all text-sm">
                                    <i
                                        class="fas fa-chevron-right text-xs text-orange-400 group-hover:translate-x-1 transition-transform"></i>
                                    <span>Tentang Kami</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="text-gray-300 hover:text-white flex items-center space-x-2 group transition-all text-sm">
                                    <i
                                        class="fas fa-chevron-right text-xs text-orange-400 group-hover:translate-x-1 transition-transform"></i>
                                    <span>Promo</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h4 class="font-display font-bold mb-4 md:mb-6 text-base md:text-lg">Kontak</h4>
                        <ul class="space-y-3 md:space-y-4">
                            <li class="flex items-start space-x-2 md:space-x-3">
                                <div class="bg-blue-500/20 p-1.5 md:p-2 rounded-lg mt-0.5 flex-shrink-0">
                                    <i class="fas fa-envelope text-blue-400 text-xs md:text-sm"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-gray-400">Email</p>
                                    <a href="mailto:{{ setting('store_email', 'info@ATigaBookStore.com') }}"
                                        class="text-gray-200 hover:text-white text-xs md:text-sm break-all">{{ setting('store_email', 'info@ATigaBookStore.com') }}</a>
                                </div>
                            </li>
                            <li class="flex items-start space-x-2 md:space-x-3">
                                <div class="bg-orange-500/20 p-1.5 md:p-2 rounded-lg mt-0.5 flex-shrink-0">
                                    <i class="fas fa-phone text-orange-400 text-xs md:text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">Telepon</p>
                                    <a href="tel:{{ setting('store_phone', '+62123456789') }}"
                                        class="text-gray-200 hover:text-white text-xs md:text-sm">{{ setting('store_phone', '+62 123 456 789') }}</a>
                                </div>
                            </li>
                            <li class="flex items-start space-x-2 md:space-x-3">
                                <div class="bg-blue-500/20 p-1.5 md:p-2 rounded-lg mt-0.5 flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-blue-400 text-xs md:text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">Alamat</p>
                                    <p class="text-gray-200 text-xs md:text-sm">
                                        {{ setting('store_address', 'Jakarta, Indonesia') }}</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Bottom Bar -->
                <div
                    class="border-t border-white/10 pt-5 md:pt-8 flex flex-col items-center space-y-3 md:flex-row md:justify-between md:items-center md:space-y-0">
                    <p class="text-gray-400 text-xs md:text-sm text-center md:text-left">
                        &copy; {{ date('Y') }} <span
                            class="font-semibold text-white">{{ setting('store_name', 'ATigaBookStore') }}</span>.
                        {{ setting('footer_copyright', 'All rights reserved.') }}
                    </p>
                    <div class="flex flex-wrap justify-center items-center gap-x-4 gap-y-2 text-xs md:text-sm">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">Kebijakan
                            Privasi</a>
                        <span class="text-gray-600 hidden sm:inline">•</span>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">Syarat &
                            Ketentuan</a>
                        <span class="text-gray-600 hidden sm:inline">•</span>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">FAQ</a>
                    </div>
                </div>
            </div>
        </footer>

    </div><!-- /gradient wrapper -->

    <!-- Mobile Bottom Navigation -->
    <nav class="fixed bottom-0 left-0 right-0 z-50 md:hidden"
        style="background:rgba(255,255,255,0.97); backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); border-top:1px solid rgba(0,0,0,0.08); box-shadow:0 -4px 20px rgba(0,0,0,0.10); padding-bottom:env(safe-area-inset-bottom,0px);">
        <div style="display:flex; align-items:flex-end; justify-content:space-around; padding:4px 4px 8px;">

            <!-- Home -->
            <a href="{{ route('home') }}"
                style="display:flex; flex-direction:column; align-items:center; gap:2px; padding:4px 8px; text-decoration:none; position:relative; transition:transform .15s; {{ request()->routeIs('home') ? 'color:#2563eb;' : 'color:#334155;' }}"
                ontouchstart="this.style.transform='scale(0.9)'" ontouchend="this.style.transform='scale(1)'">
                @if (request()->routeIs('home'))
                    <span
                        style="position:absolute;top:0;left:50%;transform:translateX(-50%);width:20px;height:3px;background:#2563eb;border-radius:99px;"></span>
                @endif
                <span
                    style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;border-radius:14px;{{ request()->routeIs('home') ? 'background:#eff6ff;' : '' }}">
                    <i class="fas fa-home" style="font-size:19px;"></i>
                </span>
                <span style="font-size:9px;font-weight:700;letter-spacing:0.04em;">Beranda</span>
            </a>

            <!-- Catalog -->
            <a href="{{ route('books.index') }}"
                style="display:flex; flex-direction:column; align-items:center; gap:2px; padding:4px 8px; text-decoration:none; position:relative; transition:transform .15s; {{ request()->routeIs('books.*') ? 'color:#2563eb;' : 'color:#334155;' }}"
                ontouchstart="this.style.transform='scale(0.9)'" ontouchend="this.style.transform='scale(1)'">
                @if (request()->routeIs('books.*'))
                    <span
                        style="position:absolute;top:0;left:50%;transform:translateX(-50%);width:20px;height:3px;background:#2563eb;border-radius:99px;"></span>
                @endif
                <span
                    style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;border-radius:14px;{{ request()->routeIs('books.*') ? 'background:#eff6ff;' : '' }}">
                    <i class="fas fa-book-open" style="font-size:19px;"></i>
                </span>
                <span style="font-size:9px;font-weight:700;letter-spacing:0.04em;">Katalog</span>
            </a>

            <!-- Cart (elevated FAB center) -->
            <a href="{{ route('cart.index') }}"
                style="display:flex; flex-direction:column; align-items:center; gap:4px; padding:0 8px; text-decoration:none; margin-top:-20px; transition:transform .15s;"
                ontouchstart="this.style.transform='scale(0.9)'" ontouchend="this.style.transform='scale(1)'">
                <span
                    style="position:relative; width:54px; height:54px; display:flex; align-items:center; justify-content:center; border-radius:18px; background:linear-gradient(135deg,#2563eb,#1d4ed8); box-shadow:0 6px 20px rgba(37,99,235,0.45);">
                    <i class="fas fa-shopping-bag" style="font-size:22px; color:white;"></i>
                    @auth
                        @php $cartCount = auth()->user()->cart()->count(); @endphp
                        <span id="mobile-bottom-cart-count"
                            style="position:absolute;top:-6px;right:-6px;background:#f97316;color:white;font-size:9px;font-weight:700;border-radius:9999px;min-width:18px;height:18px;display:{{ $cartCount > 0 ? 'flex' : 'none' }};align-items:center;justify-content:center;padding:0 3px;border:2px solid white;">{{ $cartCount }}</span>
                    @endauth
                </span>
                <span
                    style="font-size:9px;font-weight:700;letter-spacing:0.04em;{{ request()->routeIs('cart.*') ? 'color:#2563eb;' : 'color:#334155;' }}">Keranjang</span>
            </a>

            <!-- Wishlist -->
            @auth
                <a href="{{ route('wishlist.index') }}"
                    style="display:flex; flex-direction:column; align-items:center; gap:2px; padding:4px 8px; text-decoration:none; position:relative; transition:transform .15s; {{ request()->routeIs('wishlist.*') ? 'color:#ec4899;' : 'color:#334155;' }}"
                    ontouchstart="this.style.transform='scale(0.9)'" ontouchend="this.style.transform='scale(1)'">
                    @if (request()->routeIs('wishlist.*'))
                        <span
                            style="position:absolute;top:0;left:50%;transform:translateX(-50%);width:20px;height:3px;background:#ec4899;border-radius:99px;"></span>
                    @endif
                    <span
                        style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;border-radius:14px;{{ request()->routeIs('wishlist.*') ? 'background:#fdf2f8;' : '' }}">
                        <i class="fas fa-heart" style="font-size:19px;"></i>
                    </span>
                    <span style="font-size:9px;font-weight:700;letter-spacing:0.04em;">Wishlist</span>
                </a>
            @else
                <a href="{{ route('login') }}"
                    style="display:flex; flex-direction:column; align-items:center; gap:2px; padding:4px 8px; text-decoration:none; color:#334155; transition:transform .15s;"
                    ontouchstart="this.style.transform='scale(0.9)'" ontouchend="this.style.transform='scale(1)'">
                    <span
                        style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;border-radius:14px;">
                        <i class="fas fa-heart" style="font-size:19px;"></i>
                    </span>
                    <span style="font-size:9px;font-weight:700;letter-spacing:0.04em;">Wishlist</span>
                </a>
            @endauth

            <!-- Profile / Login -->
            @auth
                <a href="{{ route('profile.edit') }}"
                    style="display:flex; flex-direction:column; align-items:center; gap:2px; padding:4px 8px; text-decoration:none; position:relative; transition:transform .15s; {{ request()->routeIs('profile.*') ? 'color:#2563eb;' : 'color:#334155;' }}"
                    ontouchstart="this.style.transform='scale(0.9)'" ontouchend="this.style.transform='scale(1)'">
                    @if (request()->routeIs('profile.*'))
                        <span
                            style="position:absolute;top:0;left:50%;transform:translateX(-50%);width:20px;height:3px;background:#2563eb;border-radius:99px;"></span>
                    @endif
                    <span
                        style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;border-radius:14px;{{ request()->routeIs('profile.*') ? 'background:#eff6ff;' : '' }}">
                        <i class="fas fa-user-circle" style="font-size:19px;"></i>
                    </span>
                    <span style="font-size:9px;font-weight:700;letter-spacing:0.04em;">Profil</span>
                </a>
            @else
                <a href="{{ route('login') }}"
                    style="display:flex; flex-direction:column; align-items:center; gap:2px; padding:4px 8px; text-decoration:none; color:#334155; transition:transform .15s;"
                    ontouchstart="this.style.transform='scale(0.9)'" ontouchend="this.style.transform='scale(1)'">
                    <span
                        style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;border-radius:14px;">
                        <i class="fas fa-sign-in-alt" style="font-size:19px;"></i>
                    </span>
                    <span style="font-size:9px;font-weight:700;letter-spacing:0.04em;">Masuk</span>
                </a>
            @endauth

        </div>
    </nav>

    <!-- Toast Notification Component -->
    @include('components.toast')

    <!-- Slide-over Cart Component -->
    @auth
        @include('components.slide-over-cart')
    @endauth

    @stack('scripts')

    <script>
        // Global toast helper so any page can trigger notifications consistently.
        window.showToast = function(type, message, duration = 3000) {
            window.dispatchEvent(new CustomEvent('toast', {
                detail: {
                    type: type || 'info',
                    message: message || 'Notifikasi',
                    duration
                }
            }));
        };

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

        // Update cart & wishlist counts on page load
        @auth
        const applyWishlistCount = (count) => {
            const wCount = Number(count) || 0;
            const desktopEl = document.getElementById('wishlist-count');
            const mobileEl = document.getElementById('mobile-wishlist-count');

            if (desktopEl) {
                desktopEl.textContent = wCount;
                desktopEl.style.display = wCount > 0 ? 'flex' : 'none';
            }

            if (mobileEl) {
                mobileEl.textContent = wCount;
                mobileEl.style.display = wCount > 0 ? 'flex' : 'none';
            }
        };

        window.applyWishlistCount = applyWishlistCount;

        fetch('{{ route('cart.count') }}')
            .then(response => response.json())
            .then(data => {
                const cartCountElements = document.querySelectorAll(
                    '#cart-count, #mobile-cart-count, #mobile-bottom-cart-count');
                cartCountElements.forEach(el => {
                    el.textContent = data.count;
                });
            });

        fetch('{{ route('wishlist.count') }}')
            .then(response => response.json())
            .then(data => {
                applyWishlistCount(data.count);
            });

        window.addEventListener('wishlist-updated', (event) => {
            const incomingCount = Number(event?.detail?.count);

            if (Number.isFinite(incomingCount)) {
                applyWishlistCount(incomingCount);
                return;
            }

            fetch('{{ route('wishlist.count') }}')
                .then(response => response.json())
                .then(data => applyWishlistCount(data.count));
        });
        @endauth
    </script>

    <!-- WhatsApp Floating Button -->
    @php
        $hideWhatsappFloating = request()->routeIs('cart.*', 'checkout.payment', 'checkout.process');
        $waNumber = setting('store_whatsapp', '');
        if (empty($waNumber)) {
            $waNumber = setting('store_phone', '6281234567890');
        }
        $waNumber = preg_replace('/[^0-9]/', '', $waNumber);
        if (str_starts_with($waNumber, '0')) {
            $waNumber = '62' . substr($waNumber, 1);
        }
        if (empty($waNumber)) {
            $waNumber = '6281234567890';
        }
        $waText = urlencode('Halo, saya ingin bertanya tentang produk di ' . setting('store_name', 'ATigaBookStore'));
        $waUrl = 'https://wa.me/' . $waNumber . '?text=' . $waText;
    @endphp
    @unless ($hideWhatsappFloating)
        <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
            style="position:fixed; right:1rem; bottom:88px; z-index:9999;"
            class="md:!bottom-6 bg-green-500 hover:bg-green-600 text-white p-4 rounded-full shadow-2xl hover:shadow-3xl transition-all transform hover:scale-110 flex items-center justify-center w-14 h-14"
            title="Chat via WhatsApp">
            <i class="fab fa-whatsapp" style="font-size:28px;"></i>
        </a>
    @endunless

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</body>

</html>
