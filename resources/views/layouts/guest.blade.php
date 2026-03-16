<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ATigaBookStore') }}</title>
    @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('logo/favicon.png'))
        <link rel="icon" type="image/png" href="{{ asset('storage/logo/favicon.png') }}">
    @elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists('logo/logo.png'))
        <link rel="icon" type="image/png" href="{{ asset('storage/logo/logo.png') }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap"
        rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            border: 0;
            height: 100%;
        }

        html {
            background: #f1f5f9;
        }

        body {
            background: #f1f5f9;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Left panel */
        .auth-left {
            background: linear-gradient(160deg, #0f172a 0%, #1e3a8a 40%, #1d4ed8 100%);
            position: relative;
            overflow: hidden;
        }

        .auth-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* Animated orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            animation: orbFloat 8s ease-in-out infinite;
        }

        .orb-1 {
            width: 380px;
            height: 380px;
            background: #3b82f6;
            top: -100px;
            right: -100px;
            opacity: 0.22;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 280px;
            height: 280px;
            background: #f97316;
            bottom: -80px;
            left: -80px;
            opacity: 0.18;
            animation-delay: -3s;
        }

        .orb-3 {
            width: 180px;
            height: 180px;
            background: #8b5cf6;
            top: 45%;
            right: 8%;
            opacity: 0.2;
            animation-delay: -6s;
        }

        @keyframes orbFloat {

            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-18px) scale(1.04);
            }
        }

        /* Stats */
        .stat-number {
            font-size: 1.9rem;
            font-weight: 800;
            color: #fff;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.68rem;
            color: #93c5fd;
            margin-top: 3px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        /* Testimonial card */
        .testimonial-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 18px;
            padding: 20px;
        }

        /* Feature row */
        .feature-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .feature-dot {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background 0.2s;
        }

        /* Form card */
        .form-card {
            background: #fff;
            border-radius: 24px;
            padding: clamp(1rem, 3.8vw, 2.5rem);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.07), 0 20px 50px -10px rgba(0, 0, 0, 0.1);
            animation: fadeUp 0.45s ease both;
        }

        @media (max-width: 640px) {
            .form-card {
                border-radius: 18px;
            }

            .field-wrap input {
                padding: 1rem 2.7rem 0.38rem 2.6rem;
            }

            .field-label {
                left: 2.6rem;
            }

            .field-icon-l {
                left: 0.85rem;
            }

            .field-icon-r {
                right: 0.7rem;
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(22px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Floating label inputs */
        .field-wrap {
            position: relative;
        }

        .field-wrap input {
            width: 100%;
            padding: 1.15rem 3rem 0.4rem 2.9rem;
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            font-size: 0.9rem;
            font-weight: 500;
            color: #1e293b;
            background: #f8fafc;
            outline: none;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
            font-family: 'Inter', sans-serif;
        }

        .field-wrap input:focus,
        .field-wrap input:not(:placeholder-shown) {
            background: #fff;
        }

        .field-wrap input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.09);
        }

        .field-wrap input.is-valid {
            border-color: #16a34a;
        }

        .field-wrap input.is-valid:focus {
            box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.09);
        }

        .field-wrap input.is-error {
            border-color: #dc2626;
        }

        .field-wrap input.is-error:focus {
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.09);
        }

        .field-wrap input::placeholder {
            color: transparent;
        }

        .field-label {
            position: absolute;
            left: 2.9rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.875rem;
            font-weight: 500;
            color: #94a3b8;
            pointer-events: none;
            transition: all 0.18s ease;
        }

        .field-wrap input:focus~.field-label,
        .field-wrap input:not(:placeholder-shown)~.field-label {
            top: 0.55rem;
            transform: none;
            font-size: 0.67rem;
            font-weight: 700;
            color: #2563eb;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .field-wrap input.is-valid~.field-label {
            color: #16a34a;
        }

        .field-wrap input.is-error~.field-label {
            color: #dc2626;
        }

        .field-icon-l {
            position: absolute;
            left: 0.95rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.875rem;
            color: #94a3b8;
            pointer-events: none;
            transition: color 0.2s;
        }

        .field-wrap:focus-within .field-icon-l {
            color: #2563eb;
        }

        .field-wrap input.is-valid~.field-icon-l {
            color: #16a34a;
        }

        .field-icon-r {
            position: absolute;
            right: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.875rem;
            color: #94a3b8;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px 6px;
            border-radius: 8px;
            transition: color 0.2s, background 0.2s;
        }

        .field-icon-r:hover {
            color: #2563eb;
            background: #eff6ff;
        }

        /* Password strength */
        .strength-bar {
            display: flex;
            gap: 4px;
            margin-top: 7px;
        }

        .seg {
            flex: 1;
            height: 3px;
            border-radius: 99px;
            background: #e2e8f0;
            transition: background 0.3s;
        }

        .seg.w {
            background: #ef4444;
        }

        .seg.f {
            background: #f97316;
        }

        .seg.g {
            background: #eab308;
        }

        .seg.s {
            background: #22c55e;
        }

        .strength-hint {
            font-size: 0.72rem;
            font-weight: 600;
            margin-top: 4px;
        }

        /* Submit button */
        .btn-auth {
            width: 100%;
            padding: 0.9rem 1.5rem;
            background: #1d4ed8;
            color: #fff;
            border: none;
            border-radius: 14px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.01em;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-auth:hover:not(:disabled) {
            background: #1e40af;
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(29, 78, 216, 0.38);
        }

        .btn-auth:active:not(:disabled) {
            transform: translateY(0);
        }

        .btn-auth:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }

        .btn-auth .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: scale(0);
            animation: rippleAnim 0.65s linear;
            pointer-events: none;
        }

        @keyframes rippleAnim {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* Divider */
        .auth-divider {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        /* Error */
        .err-msg {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #dc2626;
            font-size: 0.78rem;
            font-weight: 500;
            margin-top: 6px;
            animation: shakeX 0.4s ease;
        }

        @keyframes shakeX {

            0%,
            100% {
                transform: translateX(0);
            }

            20%,
            60% {
                transform: translateX(-4px);
            }

            40%,
            80% {
                transform: translateX(4px);
            }
        }

        /* Match indicator */
        .match-hint {
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }
    </style>
</head>

<body class="antialiased" style="margin:0;padding:0;background:#f1f5f9;font-family:'Inter',sans-serif;">
    <div class="min-h-screen flex flex-col lg:flex-row">

        {{-- LEFT PANEL --}}
        <div class="auth-left hidden lg:flex lg:w-[42%] xl:w-[44%] flex-col justify-between p-10 xl:p-14">
            <div class="orb orb-1"></div>
            <div class="orb orb-2"></div>
            <div class="orb orb-3"></div>

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 relative z-10 w-fit group">
                @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('logo/logo.png'))
                    <img src="{{ asset('storage/logo/logo.png') }}" alt="ATigaBookStore"
                        class="h-10 w-auto object-contain rounded-xl transition group-hover:scale-105">
                @else
                    <div
                        class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center transition group-hover:scale-105">
                        <i class="fas fa-book-open text-white text-lg"></i>
                    </div>
                @endif
                <span class="text-white text-xl font-bold tracking-tight">ATigaBookStore</span>
            </a>

            {{-- Center --}}
            <div class="relative z-10 space-y-7">
                <div>
                    <div
                        class="inline-flex items-center gap-2 bg-white/10 border border-white/15 text-blue-200 text-xs font-semibold px-3 py-1.5 rounded-full mb-5">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span>
                        Ribuan buku tersedia hari ini
                    </div>
                    <h1 class="text-4xl xl:text-5xl font-extrabold text-white leading-tight mb-4"
                        style="font-family:'Playfair Display',serif;">
                        Dunia Buku<br><span class="text-blue-300">di Ujung Jari</span><br>Anda
                    </h1>
                    <p class="text-blue-200 text-sm leading-relaxed">
                        Temukan koleksi buku terlengkap dari berbagai genre. Harga terjangkau, pengiriman cepat,
                        pengalaman belanja yang menyenangkan.
                    </p>
                </div>

                {{-- Stats --}}
                <div class="grid grid-cols-3 gap-3 py-4 border-y border-white/10">
                    <div class="text-center">
                        <div class="stat-number">5K+</div>
                        <div class="stat-label">Judul Buku</div>
                    </div>
                    <div class="text-center">
                        <div class="stat-number">12K+</div>
                        <div class="stat-label">Pembaca</div>
                    </div>
                    <div class="text-center">
                        <div class="stat-number">4.9</div>
                        <div class="stat-label">Rating</div>
                    </div>
                </div>

                {{-- Features --}}
                <div class="space-y-3">
                    <div class="feature-row">
                        <div class="feature-dot"><i class="fas fa-book text-white text-sm"></i></div>
                        <span class="text-blue-100 text-sm">Koleksi buku dari ratusan penulis ternama</span>
                    </div>
                    <div class="feature-row">
                        <div class="feature-dot"><i class="fas fa-shield-halved text-white text-sm"></i></div>
                        <span class="text-blue-100 text-sm">Transaksi 100% aman &amp; terenkripsi SSL</span>
                    </div>
                    <div class="feature-row">
                        <div class="feature-dot"><i class="fas fa-truck-fast text-white text-sm"></i></div>
                        <span class="text-blue-100 text-sm">Pengiriman cepat ke seluruh Indonesia</span>
                    </div>
                </div>

                {{-- Testimonial --}}
                <div class="testimonial-card">
                    <div class="flex gap-0.5 mb-3">
                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                    </div>
                    <p class="text-white/90 text-sm leading-relaxed italic mb-4">&ldquo;ATigaBookStore benar-benar
                        mengubah
                        cara saya berbelanja buku. Koleksinya lengkap dan pengirimannya super cepat!&rdquo;</p>
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                            SA</div>
                        <div>
                            <div class="text-white text-xs font-semibold">Siti Aisyah</div>
                            <div class="text-blue-300 text-xs">Pelanggan setia ATigaBookStore</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-blue-400 text-xs relative z-10">&copy; {{ date('Y') }} ATigaBookStore. All rights
                reserved.
            </div>
        </div>

        {{-- RIGHT PANEL --}}
        <div
            class="flex-1 flex items-start lg:items-center justify-center bg-slate-50 px-3 py-4 sm:px-6 sm:py-8 lg:p-12">
            <div class="w-full max-w-md">

                {{-- Mobile logo --}}
                <div class="lg:hidden flex justify-center mb-4 sm:mb-6">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                        @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('logo/logo.png'))
                            <img src="{{ asset('storage/logo/logo.png') }}" alt="ATigaBookStore"
                                class="h-9 w-auto object-contain rounded-lg">
                        @else
                            <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-book-open text-white"></i>
                            </div>
                        @endif
                        <span class="text-blue-700 text-xl font-bold">ATigaBookStore</span>
                    </a>
                </div>

                {{-- Form card --}}
                <div class="form-card">
                    {{ $slot }}
                </div>

                <p class="text-center text-xs text-gray-400 mt-5">
                    <a href="{{ route('home') }}"
                        class="hover:text-blue-600 transition-colors inline-flex items-center gap-1">
                        <i class="fas fa-arrow-left text-xs"></i> Kembali ke Beranda
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script>
        /* Ripple on .btn-auth */
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-auth');
            if (!btn || btn.disabled) return;
            const rect = btn.getBoundingClientRect();
            const ripple = document.createElement('span');
            ripple.className = 'ripple';
            const size = Math.max(rect.width, rect.height);
            ripple.style.cssText =
                `width:${size}px;height:${size}px;left:${e.clientX-rect.left-size/2}px;top:${e.clientY-rect.top-size/2}px;`;
            btn.appendChild(ripple);
            setTimeout(() => ripple.remove(), 700);
        });

        /* Loading state on form submit */
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const btn = this.querySelector('.btn-auth');
                if (!btn) return;
                btn.disabled = true;
                const icon = btn.querySelector('i');
                const txt = btn.querySelector('.btn-text');
                if (icon) icon.className = 'fas fa-spinner fa-spin';
                if (txt) txt.textContent = 'Memproses...';
            });
        });

        /* Toggle password visibility */
        function togglePwd(inputId, btn) {
            const inp = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (inp.type === 'password') {
                inp.type = 'text';
                btn.title = 'Sembunyikan password';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                inp.type = 'password';
                btn.title = 'Tampilkan password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>

</html>
