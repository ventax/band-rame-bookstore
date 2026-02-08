<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - BandRame Toko Buku Anak')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&family=Poppins:wght@500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        .sidebar-gradient {
            background: linear-gradient(135deg, #1e40af 0%, #6366f1 50%, #8b5cf6 100%);
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        .bounce-hover:hover {
            animation: bounce 0.5s ease-in-out;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 sidebar-gradient text-white flex-shrink-0 shadow-2xl">
            <div class="p-6 border-b border-white/20">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 bounce-hover">
                    <div
                        class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg transform hover:scale-110 transition">
                        <i class="fas fa-book-reader text-2xl text-white"></i>
                    </div>
                    <div>
                        <span class="text-2xl font-bold text-white">BandRame</span>
                        <p class="text-xs text-white/80 font-semibold">Admin Panel</p>
                    </div>
                </a>
            </div>

            <nav class="mt-4 px-3">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-3 mb-2 rounded-2xl transition-all duration-200 text-white font-bold {{ request()->routeIs('admin.dashboard') ? 'bg-white/30 backdrop-blur-sm shadow-lg scale-105' : 'hover:bg-white/20' }}">
                    <i class="fas fa-home w-6 text-center text-lg"></i>
                    <span class="ml-3">Dashboard</span>
                </a>

                <a href="{{ route('admin.books.index') }}"
                    class="flex items-center px-4 py-3 mb-2 rounded-2xl transition-all duration-200 text-white font-bold {{ request()->routeIs('admin.books.*') ? 'bg-white/30 backdrop-blur-sm shadow-lg scale-105' : 'hover:bg-white/20' }}">
                    <i class="fas fa-book w-6 text-center text-lg"></i>
                    <span class="ml-3">Kelola Buku</span>
                </a>

                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center px-4 py-3 mb-2 rounded-2xl transition-all duration-200 text-white font-bold {{ request()->routeIs('admin.categories.*') ? 'bg-white/30 backdrop-blur-sm shadow-lg scale-105' : 'hover:bg-white/20' }}">
                    <i class="fas fa-tags w-6 text-center text-lg"></i>
                    <span class="ml-3">Kategori</span>
                </a>

                <a href="{{ route('admin.orders.index') }}"
                    class="flex items-center px-4 py-3 mb-2 rounded-2xl transition-all duration-200 text-white font-bold {{ request()->routeIs('admin.orders.*') ? 'bg-white/30 backdrop-blur-sm shadow-lg scale-105' : 'hover:bg-white/20' }}">
                    <i class="fas fa-shopping-cart w-6 text-center text-lg"></i>
                    <span class="ml-3">Pesanan</span>
                </a>

                <div class="border-t border-white/20 my-4 mx-2"></div>

                <a href="{{ route('home') }}"
                    class="flex items-center px-4 py-3 mb-2 rounded-2xl transition-all duration-200 text-white/80 font-bold hover:text-white hover:bg-white/20"
                    target="_blank">
                    <i class="fas fa-external-link-alt w-6 text-center text-lg"></i>
                    <span class="ml-3">Lihat Website</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow-md border-b-2 border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <h1 class="text-2xl font-bold text-gray-800">
                        @yield('page-title', 'Dashboard')</h1>

                    <div class="flex items-center space-x-4">
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center space-x-3 p-2 rounded-xl bg-gray-100 hover:bg-gray-200 transition-all focus:outline-none">
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center shadow-md">
                                    <span
                                        class="text-white font-semibold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                </div>
                                <div class="text-left">
                                    <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-600 font-semibold">Admin</p>
                                </div>
                                <i class="fas fa-chevron-down text-gray-600 text-sm"></i>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-xl py-2 z-50 border border-gray-200">
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-user mr-2 text-gray-500"></i> Profil
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50 transition-colors">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mx-6 mt-4">
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-800 px-5 py-4 rounded-lg shadow-sm"
                        role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-3 text-green-500"></i>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mx-6 mt-4">
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-800 px-5 py-4 rounded-lg shadow-sm"
                        role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
