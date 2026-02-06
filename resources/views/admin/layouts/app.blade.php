<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - BandRame')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-gray-900 to-gray-800 text-white flex-shrink-0 shadow-2xl">
            <div class="p-6 border-b border-gray-700">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book-reader text-xl text-white"></i>
                    </div>
                    <div>
                        <span class="text-xl font-bold text-white">BandRame</span>
                        <p class="text-xs text-gray-300">Admin Panel</p>
                    </div>
                </a>
            </div>

            <nav class="mt-4 px-3">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-3 mb-1 rounded-lg transition-all duration-200 text-gray-100 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 shadow-lg' : 'hover:bg-gray-700' }}">
                    <i class="fas fa-home w-5 text-center"></i>
                    <span class="ml-3 font-medium">Dashboard</span>
                </a>

                <a href="{{ route('admin.books.index') }}"
                    class="flex items-center px-4 py-3 mb-1 rounded-lg transition-all duration-200 text-gray-100 {{ request()->routeIs('admin.books.*') ? 'bg-blue-600 shadow-lg' : 'hover:bg-gray-700' }}">
                    <i class="fas fa-book w-5 text-center"></i>
                    <span class="ml-3 font-medium">Kelola Buku</span>
                </a>

                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center px-4 py-3 mb-1 rounded-lg transition-all duration-200 text-gray-100 {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600 shadow-lg' : 'hover:bg-gray-700' }}">
                    <i class="fas fa-tags w-5 text-center"></i>
                    <span class="ml-3 font-medium">Kategori</span>
                </a>

                <a href="{{ route('admin.orders.index') }}"
                    class="flex items-center px-4 py-3 mb-1 rounded-lg transition-all duration-200 text-gray-100 {{ request()->routeIs('admin.orders.*') ? 'bg-blue-600 shadow-lg' : 'hover:bg-gray-700' }}">
                    <i class="fas fa-shopping-cart w-5 text-center"></i>
                    <span class="ml-3 font-medium">Pesanan</span>
                </a>

                <div class="border-t border-gray-700 my-4 mx-2"></div>

                <a href="{{ route('home') }}"
                    class="flex items-center px-4 py-3 mb-1 rounded-lg transition-all duration-200 text-gray-300 hover:text-white hover:bg-gray-700"
                    target="_blank">
                    <i class="fas fa-external-link-alt w-5 text-center"></i>
                    <span class="ml-3 font-medium">Lihat Website</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <h1 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>

                    <div class="flex items-center space-x-4">
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
                                <div class="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center">
                                    <span
                                        class="text-white font-semibold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                </div>
                                <div class="text-left">
                                    <p class="text-sm font-semibold text-gray-700">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">Admin</p>
                                </div>
                                <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i> Profil
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
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
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mx-6 mt-4">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
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
