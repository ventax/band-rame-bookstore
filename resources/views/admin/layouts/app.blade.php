<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - ATigaBookStore Toko Buku Anak')</title>
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
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&family=Poppins:wght@500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        .sidebar-gradient {
            background:
                radial-gradient(circle at 100% -10%, rgba(147, 197, 253, 0.28), transparent 38%),
                linear-gradient(165deg, #1e3a8a 0%, #1d4ed8 48%, #2563eb 100%);
        }

        .admin-nav-item {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.62rem 0.8rem;
            margin-bottom: 0.35rem;
            border-radius: 0.95rem;
            color: rgba(255, 255, 255, 0.95);
            font-weight: 800;
            letter-spacing: 0.1px;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .admin-nav-item:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateX(4px);
            border-color: rgba(255, 255, 255, 0.14);
        }

        .admin-nav-icon {
            width: 2rem;
            height: 2rem;
            border-radius: 0.72rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.16);
            color: #ffffff;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }

        .admin-nav-item:hover .admin-nav-icon {
            background: rgba(255, 255, 255, 0.25);
        }

        .nav-active {
            background: linear-gradient(135deg, rgba(249, 115, 22, 0.24), rgba(245, 158, 11, 0.2)) !important;
            border: 1px solid rgba(253, 186, 116, 0.45);
            box-shadow: 0 8px 18px rgba(29, 78, 216, 0.24);
            transform: translateX(0);
        }

        .nav-active .admin-nav-icon {
            background: linear-gradient(135deg, #fb923c, #f97316);
            box-shadow: 0 6px 14px rgba(249, 115, 22, 0.38);
        }

        .admin-nav-badge {
            margin-left: auto;
            min-width: 24px;
            height: 24px;
            padding: 0 8px;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            line-height: 1;
            font-weight: 800;
            color: #ffffff;
            background: linear-gradient(135deg, #ef4444, #f97316);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 6px 12px rgba(239, 68, 68, 0.3);
        }

        /* Sidebar bottom section separator */
        .sidebar-sep {
            border-color: rgba(255, 255, 255, .15);
        }

        /* Header orange-blue accent */
        .admin-header-border {
            border-bottom: 2px solid #bfdbfe;
        }

        /* Hide custom cursor on admin panel */
        body.admin-panel .custom-cursor {
            display: none !important;
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

<body class="font-sans antialiased bg-blue-50/40 admin-panel" style="background:#f0f6ff;" x-data="{ sidebarOpen: false }">

    <!-- Mobile overlay -->
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-40 lg:hidden"
        x-transition:enter="transition-opacity duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    </div>

    {{-- Mobile drawer: fixed overlay, slides in from left, hidden on desktop --}}
    <aside x-show="sidebarOpen" x-cloak
        class="fixed inset-y-0 left-0 z-50 w-64 sidebar-gradient text-white flex flex-col shadow-2xl lg:hidden"
        x-transition:enter="transition-transform duration-300 ease-out" x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transition-transform duration-200 ease-in"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
        @include('admin.partials.sidebar-nav')
    </aside>

    <div class="flex h-screen overflow-hidden">
        {{-- Desktop sidebar: always in flex flow, never overlaps content --}}
        <aside
            class="hidden lg:flex lg:flex-col w-64 flex-shrink-0 sidebar-gradient text-white shadow-2xl [&_.sidebar-close-btn]:hidden">
            @include('admin.partials.sidebar-nav')
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden min-w-0">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b-2 border-blue-100 flex-shrink-0">
                <div class="flex items-center justify-between px-3 sm:px-6 py-3 gap-2">

                    <!-- Hamburger (mobile only) + Page Title -->
                    <div class="flex items-center gap-3 min-w-0">
                        <button @click="sidebarOpen = true"
                            class="lg:hidden p-2 rounded-xl bg-blue-50 hover:bg-blue-100 border border-blue-100 transition-all flex-shrink-0">
                            <i class="fas fa-bars text-blue-600 text-lg"></i>
                        </button>
                        <h1 class="text-base sm:text-xl font-bold text-blue-800 truncate">
                            @yield('page-title', 'Dashboard')
                        </h1>
                    </div>

                    <div class="flex items-center gap-2 flex-shrink-0">

                        {{-- Bell Notification --}}
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="relative p-2 rounded-xl bg-blue-50 hover:bg-blue-100 border border-blue-100 transition-all focus:outline-none">
                                <i class="fas fa-bell text-blue-500 text-lg"></i>
                                @if (!empty($pendingOrdersCount) && $pendingOrdersCount > 0)
                                    <span
                                        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">
                                        {{ $pendingOrdersCount > 9 ? '9+' : $pendingOrdersCount }}
                                    </span>
                                @endif
                            </button>

                            <div x-show="open" @click.away="open = false" x-cloak
                                class="absolute right-0 mt-2 w-[min(320px,calc(100vw-24px))] bg-white rounded-xl shadow-xl z-50 border border-gray-200 overflow-hidden">
                                <div class="px-4 py-3 bg-blue-600 text-white flex justify-between items-center">
                                    <span class="font-semibold text-sm">Pesanan Perlu Diproses</span>
                                    @if (!empty($pendingOrdersCount) && $pendingOrdersCount > 0)
                                        <span
                                            class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $pendingOrdersCount }}</span>
                                    @endif
                                </div>

                                @if (!empty($latestPendingOrders) && $latestPendingOrders->count() > 0)
                                    <div class="divide-y divide-gray-100 max-h-64 overflow-y-auto">
                                        @foreach ($latestPendingOrders as $pendingOrder)
                                            <a href="{{ route('admin.orders.show', $pendingOrder) }}"
                                                class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                                    <i class="fas fa-user text-orange-500 text-xs"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-semibold text-gray-800 truncate">
                                                        {{ $pendingOrder->user->name ?? '-' }}</p>
                                                    <p class="text-xs text-gray-500">{{ $pendingOrder->order_number }}
                                                    </p>
                                                    <p class="text-xs font-semibold text-blue-600">Rp
                                                        {{ number_format($pendingOrder->total_amount, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                                <p class="text-xs text-gray-400 flex-shrink-0">
                                                    {{ $pendingOrder->created_at->diffForHumans() }}</p>
                                            </a>
                                        @endforeach
                                    </div>
                                    <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}"
                                        class="block text-center text-sm font-semibold text-blue-600 hover:bg-blue-50 py-3 transition-colors border-t">
                                        Lihat Semua Pesanan Processing →
                                    </a>
                                @else
                                    <div class="px-4 py-8 text-center text-gray-400">
                                        <i class="fas fa-check-circle text-3xl mb-2 text-green-400"></i>
                                        <p class="text-sm">Tidak ada pesanan yang perlu diproses</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- User Dropdown --}}
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center gap-2 p-1.5 rounded-xl bg-blue-50 hover:bg-blue-100 border border-blue-100 transition-all focus:outline-none">
                                <div
                                    class="w-8 h-8 sm:w-9 sm:h-9 bg-gradient-to-r from-blue-600 to-orange-500 rounded-full flex items-center justify-center shadow-md flex-shrink-0">
                                    <span
                                        class="text-white font-bold text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                </div>
                                <div class="text-left hidden sm:block">
                                    <p class="text-sm font-bold text-blue-900 leading-tight">{{ Auth::user()->name }}
                                    </p>
                                    <p class="text-xs text-orange-500 font-semibold">Admin</p>
                                </div>
                                <i class="fas fa-chevron-down text-blue-400 text-xs hidden sm:block"></i>
                            </button>

                            <div x-show="open" @click.away="open = false" x-cloak
                                class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl py-2 z-50 border border-gray-200">
                                <div class="px-4 py-2 border-b border-gray-100 sm:hidden">
                                    <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-orange-500">Admin</p>
                                </div>
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-user mr-2 text-gray-500"></i> Profil
                                </a>
                                <form method="POST" action="{{ route('admin.logout') }}">
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

            <!-- Banner izin notifikasi -->
            <div id="notif-permission-banner"
                class="mx-3 sm:mx-6 mt-3 bg-blue-600 text-white rounded-xl px-4 py-3 flex flex-wrap items-center gap-3 shadow-lg">
                <div class="flex-shrink-0 w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-bell text-white text-sm"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-sm">Aktifkan Notifikasi Pesanan</p>
                    <p class="text-xs text-blue-100 hidden sm:block">Agar mendapat notifikasi saat ada pesanan baru</p>
                </div>
                <button id="btn-enable-notif"
                    class="flex-shrink-0 bg-white text-blue-600 font-bold text-xs sm:text-sm px-3 py-1.5 rounded-lg hover:bg-blue-50 transition-colors">
                    <i class="fas fa-bell mr-1"></i> Aktifkan
                </button>
                <button onclick="document.getElementById('notif-permission-banner').remove()"
                    class="flex-shrink-0 text-white/70 hover:text-white text-xl leading-none px-1">×</button>
            </div>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mx-3 sm:mx-6 mt-3">
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
                <div class="mx-3 sm:mx-6 mt-3">
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
            <main class="flex-1 overflow-y-auto p-3 sm:p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')

    <!-- Toast container (pojok kanan bawah, seperti notif WA/IG) -->
    <div id="order-toast-container"
        class="fixed bottom-4 right-3 sm:right-5 z-[9999] flex flex-col-reverse gap-2 pointer-events-none"
        style="max-width:min(330px,calc(100vw - 24px))"></div>

    <script>
        (function() {
            const POLL_INTERVAL = 30000;
            const CHECK_URL = '{{ route('admin.orders.check-new') }}';
            const STORAGE_KEY = 'admin_last_order_id_v2';
            let lastId = -1;
            let initialized = false;
            localStorage.removeItem('admin_last_order_id'); // hapus key lama

            /* ---- BANNER izin notifikasi ---- */
            function checkBannerVisibility() {
                const banner = document.getElementById('notif-permission-banner');
                if (!banner) return;
                // Hanya sembunyikan jika sudah granted
                if ('Notification' in window && Notification.permission === 'granted') {
                    banner.remove();
                }
            }
            const btnEnable = document.getElementById('btn-enable-notif');
            if (btnEnable) {
                btnEnable.addEventListener('click', () => {
                    Notification.requestPermission().then(perm => {
                        if (perm === 'granted') {
                            document.getElementById('notif-permission-banner')?.remove();
                            // Kirim notif test supaya tahu berhasil
                            new Notification('✅ Notifikasi Aktif!', {
                                body: 'Kamu akan mendapat notifikasi saat ada pesanan baru.',
                                icon: '/favicon.ico',
                            });
                        } else {
                            alert(
                                'Izin ditolak browser. Klik ikon kunci di address bar → Notifications → Allow.'
                            );
                        }
                    });
                });
            }
            checkBannerVisibility();

            /* ---- BEEP ---- */
            function playBeep() {
                try {
                    const ctx = new(window.AudioContext || window.webkitAudioContext)();
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(880, ctx.currentTime);
                    gain.gain.setValueAtTime(0.35, ctx.currentTime);
                    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.5);
                    osc.start(ctx.currentTime);
                    osc.stop(ctx.currentTime + 0.5);
                } catch (e) {}
            }

            /* ---- IN-PAGE TOAST (seperti notif WA/IG) ---- */
            function showToast(order) {
                const container = document.getElementById('order-toast-container');
                if (!container) return;
                const id = 'toast-' + Date.now();
                const now = new Date().toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                const div = document.createElement('a');
                div.href = order.url;
                div.id = id;
                div.className =
                    'pointer-events-auto flex items-center gap-3 bg-white rounded-2xl shadow-2xl px-4 py-3 border border-gray-100 cursor-pointer hover:shadow-xl transition-shadow';
                div.style.cssText =
                    'animation: toastIn 0.35s cubic-bezier(.21,1.02,.73,1) forwards; width:min(330px,calc(100vw - 24px));';
                div.innerHTML = `
                <div class="relative flex-shrink-0">
                    <div class="w-11 h-11 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center shadow">
                        <i class="fas fa-store text-white text-base"></i>
                    </div>
                    <span class="absolute -bottom-0.5 -right-0.5 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-baseline">
                        <p class="text-sm font-bold text-gray-900 truncate">Pesanan Baru 🛒</p>
                        <span class="text-xs text-gray-400 ml-2 flex-shrink-0">${now}</span>
                    </div>
                    <p class="text-xs text-gray-700 font-semibold truncate">${order.customer}</p>
                    <p class="text-xs text-gray-400 truncate">${order.order_number} &bull; Rp ${order.total}</p>
                </div>
                <button onclick="event.preventDefault();event.stopPropagation();document.getElementById('${id}').style.animation='toastOut 0.25s ease forwards';setTimeout(()=>document.getElementById('${id}')?.remove(),260)"
                    class="flex-shrink-0 text-gray-300 hover:text-gray-500 text-lg px-1">×</button>
            `;
                container.appendChild(div);
                setTimeout(() => {
                    if (document.getElementById(id)) {
                        div.style.animation = 'toastOut 0.25s ease forwards';
                        setTimeout(() => div.remove(), 260);
                    }
                }, 9000);
            }

            /* ---- BROWSER NOTIFICATION (OS-level, seperti notif WA di desktop) ---- */
            function showBrowserNotif(order) {
                if (!('Notification' in window) || Notification.permission !== 'granted') return;
                const n = new Notification('🛒 Pesanan Baru Masuk!', {
                    body: `${order.customer}\n${order.order_number}  •  Rp ${order.total}`,
                    icon: '/favicon.ico',
                    badge: '/favicon.ico',
                    tag: 'order-' + order.order_number,
                    requireInteraction: true,
                    silent: false,
                });
                n.onclick = () => {
                    window.focus();
                    window.location.href = order.url;
                    n.close();
                };
            }

            /* ---- POLLING ---- */
            async function poll() {
                try {
                    const res = await fetch(CHECK_URL + '?last_id=' + lastId, {
                        credentials: 'same-origin'
                    });
                    if (!res.ok) return;
                    const data = await res.json();

                    if (!initialized) {
                        lastId = data.latest_id;
                        initialized = true;
                        return;
                    }

                    if (data.new_count > 0) {
                        data.orders.forEach(order => {
                            showToast(order);
                            showBrowserNotif(order);
                        });
                        playBeep();
                        lastId = data.latest_id;
                    }
                } catch (e) {}
            }

            // CSS animasi
            const s = document.createElement('style');
            s.textContent = `
            @keyframes toastIn  { from { transform: translateX(110%) scale(0.95); opacity: 0; } to { transform: translateX(0) scale(1); opacity: 1; } }
            @keyframes toastOut { from { transform: translateX(0) scale(1); opacity: 1; } to { transform: translateX(110%) scale(0.95); opacity: 0; } }
        `;
            document.head.appendChild(s);

            // Mulai polling
            poll();
            setInterval(poll, POLL_INTERVAL);
        })();
    </script>
</body>

</html>
