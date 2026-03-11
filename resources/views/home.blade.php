@extends('layouts.app')

@section('title', 'Beranda - ATigaBookStore')

@push('styles')
    <style>
        @keyframes fadeInUp {
            from {
                transform: translateY(28px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeInLeft {
            from {
                transform: translateX(-40px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeInRight {
            from {
                transform: translateX(40px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes floatY {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-14px);
            }
        }

        .anim-fade-up {
            animation: fadeInUp 0.7s ease-out both;
        }

        .anim-fade-left {
            animation: fadeInLeft 0.8s ease-out both;
        }

        .anim-fade-right {
            animation: fadeInRight 0.8s ease-out both;
        }

        .anim-float {
            animation: floatY 4s ease-in-out infinite;
        }

        .delay-1 {
            animation-delay: 0.1s;
        }

        .delay-2 {
            animation-delay: 0.2s;
        }

        .delay-3 {
            animation-delay: 0.3s;
        }

        .delay-4 {
            animation-delay: 0.4s;
        }

        .delay-5 {
            animation-delay: 0.5s;
        }

        .delay-6 {
            animation-delay: 0.6s;
        }

        /* Hero */
        .hero-section {
            background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 50%, #ea580c 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.18;
            pointer-events: none;
        }

        .hero-book-card {
            background: rgba(255, 255, 255, 0.09);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 1.25rem;
        }

        /* Stats */
        .stat-card {
            background: white;
            border-radius: 1.25rem;
            box-shadow: 0 4px 24px rgba(30, 58, 138, .09);
            transition: transform .3s, box-shadow .3s;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(30, 58, 138, .15);
        }

        /* Categories */
        .cat-card {
            background: white;
            border-radius: 1.25rem;
            border: 2px solid transparent;
            box-shadow: 0 2px 16px rgba(0, 0, 0, .07);
            transition: all .35s cubic-bezier(.34, 1.56, .64, 1);
            cursor: pointer;
        }

        .cat-card:hover {
            transform: translateY(-6px) scale(1.03);
            box-shadow: 0 16px 36px rgba(30, 58, 138, .15);
            border-color: #bfdbfe;
        }

        .cat-icon-wrap {
            width: 58px;
            height: 58px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 0.7rem;
        }

        /* Spotlight */
        .spotlight-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 4px 24px rgba(0, 0, 0, .08);
            overflow: hidden;
            transition: all .4s ease;
        }

        .spotlight-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 48px rgba(30, 58, 138, .16);
        }

        .spotlight-lead {
            display: grid;
            grid-template-columns: 220px 1fr;
            min-height: 300px;
        }

        @media (max-width: 767px) {
            .spotlight-lead {
                grid-template-columns: 1fr;
            }
        }

        /* Feature & Testimonial cards */
        .feature-card,
        .testi-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 4px 24px rgba(0, 0, 0, .07);
            border: 2px solid transparent;
            transition: all .35s ease;
        }

        .feature-card {
            padding: 2rem;
        }

        .feature-card:hover,
        .testi-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(30, 58, 138, .14);
        }

        .testi-card {
            padding: 1.75rem;
            position: relative;
        }

        .testi-card::before {
            content: '\201C';
            position: absolute;
            top: -6px;
            left: 18px;
            font-size: 4.5rem;
            line-height: 1;
            font-family: Georgia, serif;
            color: #dbeafe;
            pointer-events: none;
        }

        /* Section label pill */
        .section-label {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            padding: .35rem 1rem;
            border-radius: 9999px;
        }
    </style>
@endpush

@section('content')

    {{-- HERO --}}


    <section class="hero-section py-14 lg:py-32" style="margin-top: -56px;">
        <div class="hero-blob w-96 h-96 bg-blue-300" style="top:-80px;left:-80px;"></div>
        <div class="hero-blob w-72 h-72 bg-orange-400" style="bottom:-60px;right:5%;"></div>
        <div class="hero-blob w-48 h-48 bg-indigo-400" style="top:30%;right:28%;"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">

                {{-- Copy --}}
                <div class="flex-1 text-white text-center lg:text-left space-y-6">
                    <div class="anim-fade-left">
                        <span
                            class="inline-flex items-center gap-2 bg-white/15 backdrop-blur px-4 py-1.5 rounded-full border border-white/25 text-sm font-semibold">
                            <span class="relative flex h-2.5 w-2.5">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-300 opacity-75"></span>
                                <span class="inline-flex rounded-full h-2.5 w-2.5 bg-yellow-300"></span>
                            </span>
                            {{ setting('hero_badge_text', '🎉 Promo spesial — diskon hingga 50%') }}
                        </span>
                    </div>
                    <h1 class="anim-fade-left delay-1 text-4xl sm:text-5xl lg:text-6xl font-black leading-tight">
                        {{ setting('hero_title_line1', 'Jendela') }} <span
                            class="bg-gradient-to-r from-yellow-300 to-orange-400 bg-clip-text text-transparent">{{ setting('hero_title_line2', 'Dunia') }}</span>
                        <br>{{ setting('hero_title_line3', 'Ada di Sini') }}
                    </h1>
                    <p
                        class="anim-fade-left delay-2 text-lg lg:text-xl text-white/85 leading-relaxed max-w-xl mx-auto lg:mx-0">
                        {{ setting('hero_subtitle', 'Temukan ribuan buku dari berbagai genre — fiksi, sains, hingga buku anak — dengan harga terjangkau dan pengiriman cepat ke seluruh Indonesia.') }}
                    </p>
                    <div class="anim-fade-left delay-3 flex flex-wrap justify-center lg:justify-start gap-4 pt-2">
                        <a href="{{ route('books.index') }}"
                            class="group relative inline-flex items-center gap-2 px-8 py-4 bg-white text-blue-700 font-bold text-base rounded-2xl shadow-2xl hover:shadow-orange-400/40 transition-all hover:scale-105 overflow-hidden">
                            <span class="relative z-10 flex items-center gap-2">
                                <i class="fas fa-book-open"></i> {{ setting('hero_btn1_text', 'Jelajahi Katalog') }}
                                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </span>
                            <span
                                class="absolute inset-0 bg-gradient-to-r from-orange-200 to-yellow-200 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                        </a>
                        <a href="#categories"
                            class="inline-flex items-center gap-2 px-8 py-4 bg-white/10 backdrop-blur text-white font-bold text-base rounded-2xl border-2 border-white/30 hover:bg-white/20 transition-all hover:scale-105">
                            <i class="fas fa-th-large"></i> {{ setting('hero_btn2_text', 'Lihat Kategori') }}
                        </a>
                    </div>

                    {{-- Mobile-only promo chips --}}
                    <div class="lg:hidden flex flex-wrap justify-center gap-2 pt-2 anim-fade-up delay-4">
                        <span
                            class="inline-flex items-center gap-1.5 bg-white/15 backdrop-blur border border-white/20 text-white text-xs font-semibold px-3 py-1.5 rounded-full">
                            <i class="fas fa-fire text-yellow-300 text-xs"></i> Diskon 50%
                        </span>
                        <span
                            class="inline-flex items-center gap-1.5 bg-white/15 backdrop-blur border border-white/20 text-white text-xs font-semibold px-3 py-1.5 rounded-full">
                            <i class="fas fa-truck-fast text-blue-200 text-xs"></i> Gratis Ongkir
                        </span>
                        <span
                            class="inline-flex items-center gap-1.5 bg-white/15 backdrop-blur border border-white/20 text-white text-xs font-semibold px-3 py-1.5 rounded-full">
                            <i class="fas fa-gift text-orange-300 text-xs"></i> Cashback 10%
                        </span>
                    </div>
                </div>

                {{-- Promo cards (desktop only) --}}
                <div class="hidden lg:flex flex-col flex-shrink-0 w-full max-w-xs anim-fade-right delay-2 space-y-4">
                    <div class="hero-book-card p-5 flex items-center gap-4 anim-float">
                        <div class="w-14 h-14 bg-yellow-400/25 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-fire text-yellow-300 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-white/65 text-xs font-semibold uppercase tracking-wider">
                                {{ setting('hero_promo1_label', 'Flash Sale') }}</p>
                            <p class="text-white font-black text-2xl">{{ setting('hero_promo1_value', 'Diskon 50%') }}</p>
                            <p class="text-white/60 text-xs">{{ setting('hero_promo1_sub', 'Terbatas hari ini') }}</p>
                        </div>
                    </div>
                    <div class="hero-book-card p-5 flex items-center gap-4"
                        style="animation:floatY 4s .8s ease-in-out infinite;">
                        <div class="w-14 h-14 bg-blue-400/25 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-truck-fast text-blue-200 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-white/65 text-xs font-semibold uppercase tracking-wider">
                                {{ setting('hero_promo2_label', 'Gratis Ongkir') }}</p>
                            <p class="text-white font-black text-2xl">{{ setting('hero_promo2_value', 'Min. Rp 50.000') }}
                            </p>
                            <p class="text-white/60 text-xs">{{ setting('hero_promo2_sub', 'Seluruh Indonesia') }}</p>
                        </div>
                    </div>
                    <div class="hero-book-card p-5 flex items-center gap-4"
                        style="animation:floatY 4s 1.6s ease-in-out infinite;">
                        <div class="w-14 h-14 bg-orange-400/25 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-gift text-orange-300 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-white/65 text-xs font-semibold uppercase tracking-wider">
                                {{ setting('hero_promo3_label', 'Member Baru') }}</p>
                            <p class="text-white font-black text-2xl">{{ setting('hero_promo3_value', 'Cashback 10%') }}
                            </p>
                            <p class="text-white/60 text-xs">{{ setting('hero_promo3_sub', 'Pembelian pertama') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0 pointer-events-none">
            <svg viewBox="0 0 1440 80" class="w-full fill-current text-slate-50">
                <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" />
            </svg>
        </div>
    </section>

    {{-- STATS STRIP --}}


    <section class="bg-slate-50 py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @php
                    $stats = [
                        [
                            'value' => number_format($totalBooks) . '+',
                            'label' => 'Judul Buku',
                            'icon' => 'fas fa-book',
                            'bg' => 'bg-blue-100',
                            'text' => 'text-blue-600',
                        ],
                        [
                            'value' => $totalCategories . '+',
                            'label' => 'Kategori',
                            'icon' => 'fas fa-th-large',
                            'bg' => 'bg-orange-100',
                            'text' => 'text-orange-600',
                        ],
                        [
                            'value' => '10.000+',
                            'label' => 'Pelanggan',
                            'icon' => 'fas fa-users',
                            'bg' => 'bg-blue-100',
                            'text' => 'text-blue-600',
                        ],
                        [
                            'value' => '4.9',
                            'label' => 'Rating Toko',
                            'icon' => 'fas fa-star',
                            'bg' => 'bg-orange-100',
                            'text' => 'text-orange-600',
                            'suffix_icon' => 'fas fa-star text-amber-400',
                        ],
                    ];
                @endphp
                @foreach ($stats as $i => $s)
                    <div class="stat-card p-5 text-center anim-fade-up delay-{{ $i + 1 }}">
                        <div
                            class="{{ $s['bg'] }} {{ $s['text'] }} w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <i class="{{ $s['icon'] }} text-xl"></i>
                        </div>
                        <div class="text-2xl font-black text-gray-900 flex items-center justify-center gap-1">
                            {{ $s['value'] }}
                            @isset($s['suffix_icon'])
                                <i class="{{ $s['suffix_icon'] }} text-lg"></i>
                            @endisset
                        </div>
                        <div class="text-sm text-gray-500 font-medium mt-0.5">{{ $s['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- BROWSE CATEGORIES --}}


    <section id="categories" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-12 anim-fade-up">
                <span class="section-label bg-blue-100 text-blue-700 mb-3">
                    <i class="fas fa-th-large"></i> Kategori
                </span>
                <h2 class="text-3xl lg:text-4xl font-black text-gray-900 mt-3 mb-3">
                    Temukan Buku <span
                        class="bg-gradient-to-r from-blue-600 to-orange-500 bg-clip-text text-transparent">yang Anda
                        Cari</span>
                </h2>
                <p class="text-gray-500 max-w-xl mx-auto">Pilih kategori favorit Anda dan mulai perjalanan membaca</p>
            </div>

            @php
                $catColors = [
                    ['bg' => 'bg-blue-100', 'text' => 'text-blue-600'],
                    ['bg' => 'bg-orange-100', 'text' => 'text-orange-600'],
                    ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-600'],
                    ['bg' => 'bg-amber-100', 'text' => 'text-amber-600'],
                    ['bg' => 'bg-sky-100', 'text' => 'text-sky-600'],
                    ['bg' => 'bg-red-100', 'text' => 'text-red-600'],
                    ['bg' => 'bg-teal-100', 'text' => 'text-teal-600'],
                    ['bg' => 'bg-violet-100', 'text' => 'text-violet-600'],
                ];
                $catIcons = [
                    'fa-book',
                    'fa-flask',
                    'fa-heart',
                    'fa-child',
                    'fa-graduation-cap',
                    'fa-globe',
                    'fa-paint-brush',
                    'fa-briefcase',
                ];
            @endphp

            @if ($categories->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 lg:gap-5">
                    @foreach ($categories as $i => $cat)
                        @php $c = $catColors[$i % count($catColors)]; @endphp
                        <a href="{{ route('books.index', ['category' => $cat->slug]) }}"
                            class="cat-card p-5 text-center anim-fade-up delay-{{ min($i + 1, 6) }}">
                            <div class="cat-icon-wrap {{ $c['bg'] }} {{ $c['text'] }}">
                                <i class="fas {{ $catIcons[$i % count($catIcons)] }}"></i>
                            </div>
                            <h3 class="font-bold text-gray-800 text-sm leading-snug mb-1">{{ $cat->name }}</h3>
                            <p class="text-xs text-gray-400 font-medium">{{ $cat->books_count }} buku</p>
                        </a>
                    @endforeach
                </div>
            @endif

            <div class="text-center mt-10 anim-fade-up delay-5">
                <a href="{{ route('books.index') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 border-2 border-blue-600 text-blue-600 font-bold rounded-2xl hover:bg-blue-600 hover:text-white transition-all">
                    Semua Kategori <i class="fas fa-arrow-right text-sm"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- EDITORIAL SPOTLIGHT --}}


    @if ($featuredBooks->count() > 0)
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-12">
                    <div class="anim-fade-up">
                        <span class="section-label bg-orange-100 text-orange-700 mb-3">
                            <i class="fas fa-star"></i> Pilihan Editor
                        </span>
                        <h2 class="text-3xl lg:text-4xl font-black text-gray-900 mt-3">
                            Buku <span
                                class="bg-gradient-to-r from-orange-500 to-blue-600 bg-clip-text text-transparent">Terpilih</span>
                            Bulan Ini
                        </h2>
                    </div>
                    <a href="{{ route('books.index') }}"
                        class="anim-fade-up delay-2 inline-flex items-center gap-2 text-blue-600 font-bold hover:gap-3 transition-all whitespace-nowrap self-start sm:self-auto">
                        Lihat semua <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                </div>

                @php
                    $lead = $featuredBooks->first();
                    $rest = $featuredBooks->skip(1);
                @endphp

                {{-- Lead book --}}
                <div class="spotlight-card spotlight-lead mb-6 anim-fade-up delay-1">
                    <div class="relative">
                        @if ($lead->cover_image)
                            <img src="{{ asset('storage/' . $lead->cover_image) }}" alt="{{ $lead->title }}"
                                class="w-full h-full object-cover" style="max-height:340px;">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-100 to-orange-100 flex items-center justify-center"
                                style="min-height:280px;">
                                <i class="fas fa-book text-blue-300 text-7xl"></i>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                        <span
                            class="absolute top-4 left-4 bg-orange-500 text-white text-xs font-black px-3 py-1.5 rounded-full shadow">
                            <i class="fas fa-crown mr-1"></i> #1 PILIHAN
                        </span>
                    </div>
                    <div class="p-7 lg:p-8 flex flex-col justify-center">
                        <span
                            class="inline-block text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-lg mb-4 self-start">
                            {{ $lead->category->name }}
                        </span>
                        <h3 class="text-2xl lg:text-3xl font-black text-gray-900 mb-2 leading-tight">{{ $lead->title }}
                        </h3>
                        <p class="text-gray-500 mb-3 font-medium">{{ $lead->author }}</p>
                        @if ($lead->description)
                            <p class="text-gray-600 leading-relaxed mb-6 line-clamp-3 text-sm">{{ $lead->description }}
                            </p>
                        @endif
                        <div class="flex items-center gap-3 mt-auto flex-wrap">
                            <div>
                                @if ($lead->discount > 0)
                                    <div class="flex items-center gap-2 mb-1">
                                        <span
                                            class="inline-flex items-center gap-1 bg-gradient-to-r from-red-500 to-orange-400 text-white text-xs font-black px-2.5 py-1 rounded-lg shadow">
                                            <i class="fas fa-bolt text-yellow-300 text-xs"></i> -{{ $lead->discount }}%
                                        </span>
                                        <span class="text-sm text-gray-400 line-through">Rp
                                            {{ number_format($lead->price, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                                <span
                                    class="text-2xl font-black bg-gradient-to-r from-blue-600 to-orange-500 bg-clip-text text-transparent">
                                    Rp {{ number_format($lead->discounted_price, 0, ',', '.') }}
                                </span>
                                @if ($lead->discount > 0)
                                    <span
                                        class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full ml-2">
                                        <i class="fas fa-piggy-bank text-xs"></i> Hemat Rp
                                        {{ number_format($lead->price - $lead->discounted_price, 0, ',', '.') }}
                                    </span>
                                @endif
                            </div>
                            @if ($lead->stock > 0)
                                <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-full">
                                    <i class="fas fa-check-circle mr-1"></i>Tersedia
                                </span>
                            @endif
                        </div>
                        <a href="{{ route('books.show', $lead->slug) }}"
                            class="mt-5 inline-flex items-center gap-2 self-start px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all hover:shadow-lg text-sm">
                            Lihat Detail <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                {{-- Rest (3 books) --}}
                @if ($rest->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach ($rest as $i => $book)
                            <a href="{{ route('books.show', $book->slug) }}"
                                class="spotlight-card flex gap-4 p-4 anim-fade-up delay-{{ $i + 2 }} group">
                                <div class="relative w-20 flex-shrink-0 rounded-xl overflow-hidden bg-blue-50"
                                    style="aspect-ratio:2/3;min-height:100px;">
                                    @if ($book->cover_image)
                                        <img src="{{ asset('storage/' . $book->cover_image) }}"
                                            alt="{{ $book->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fas fa-book text-blue-300 text-2xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex flex-col justify-center py-1 min-w-0">
                                    <span
                                        class="text-xs font-bold text-orange-600 bg-orange-50 px-2 py-0.5 rounded-lg self-start mb-2">{{ $book->category->name }}</span>
                                    <h4
                                        class="font-bold text-gray-900 text-sm leading-snug line-clamp-2 group-hover:text-blue-600 transition-colors mb-1">
                                        {{ $book->title }}</h4>
                                    <p class="text-xs text-gray-400 mb-2">{{ $book->author }}</p>
                                    @if ($book->discount > 0)
                                        <span class="text-xs text-gray-400 line-through">Rp
                                            {{ number_format($book->price, 0, ',', '.') }}</span><br>
                                    @endif
                                    <span class="text-sm font-black text-blue-600">Rp
                                        {{ number_format($book->discounted_price, 0, ',', '.') }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif

            </div>
        </section>
    @endif

    {{-- WHY ATigaBookStore --}}


    <section class="py-20 bg-gradient-to-br from-blue-50 via-slate-50 to-orange-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-14 anim-fade-up">
                <span class="section-label bg-blue-100 text-blue-700 mb-3">
                    <i class="fas fa-shield-halved"></i> Keunggulan Kami
                </span>
                <h2 class="text-3xl lg:text-4xl font-black text-gray-900 mt-3 mb-3">
                    Kenapa Pilih <span
                        class="bg-gradient-to-r from-blue-600 to-orange-500 bg-clip-text text-transparent">ATigaBookStore</span>?
                </h2>
                <p class="text-gray-500 max-w-xl mx-auto">Kami berkomitmen memberikan pengalaman berbelanja buku terbaik
                    untuk Anda</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6 lg:gap-8">
                @php
                    $features = [
                        [
                            'icon' => 'fas fa-shipping-fast',
                            'iconBg' => 'bg-blue-600',
                            'border' => 'hover:border-blue-300',
                            'title' => setting('feature1_title', 'Pengiriman Kilat'),
                            'desc' => setting(
                                'feature1_desc',
                                'Pesanan dikirim 1–3 hari kerja ke seluruh Indonesia via kurir terpercaya.',
                            ),
                        ],
                        [
                            'icon' => 'fas fa-lock',
                            'iconBg' => 'bg-orange-500',
                            'border' => 'hover:border-orange-300',
                            'title' => setting('feature2_title', 'Pembayaran Aman'),
                            'desc' => setting(
                                'feature2_desc',
                                'Transaksi 100% aman dengan enkripsi SSL dan berbagai metode pembayaran.',
                            ),
                        ],
                        [
                            'icon' => 'fas fa-headset',
                            'iconBg' => 'bg-blue-600',
                            'border' => 'hover:border-blue-300',
                            'title' => setting('feature3_title', 'Support 24/7'),
                            'desc' => setting(
                                'feature3_desc',
                                'Tim kami siap membantu kapan saja — chat, email, atau telepon.',
                            ),
                        ],
                    ];
                @endphp
                @foreach ($features as $i => $f)
                    <div class="feature-card {{ $f['border'] }} anim-fade-up delay-{{ $i + 1 }}">
                        <div
                            class="{{ $f['iconBg'] }} w-14 h-14 rounded-2xl flex items-center justify-center mb-5 shadow-md">
                            <i class="{{ $f['icon'] }} text-2xl text-white"></i>
                        </div>
                        <h3 class="text-xl font-black text-gray-900 mb-2">{{ $f['title'] }}</h3>
                        <p class="text-gray-500 leading-relaxed text-sm">{{ $f['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- TESTIMONIALS --}}


    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-14 anim-fade-up">
                <span class="section-label bg-orange-100 text-orange-700 mb-3">
                    <i class="fas fa-comment-dots"></i> Testimoni
                </span>
                <h2 class="text-3xl lg:text-4xl font-black text-gray-900 mt-3 mb-3">
                    Apa Kata <span
                        class="bg-gradient-to-r from-orange-500 to-blue-600 bg-clip-text text-transparent">Pembaca
                        Kami</span>?
                </h2>
                <p class="text-gray-500 max-w-xl mx-auto">Ribuan pelanggan telah mempercayakan kebutuhan buku mereka kepada
                    ATigaBookStore</p>
            </div>

            @php
                $testimonials = [
                    [
                        'name' => 'Rina Kusuma',
                        'role' => 'Guru SD, Bandung',
                        'avatar' => 'RK',
                        'avatarBg' => 'bg-blue-500',
                        'stars' => 5,
                        'text' =>
                            'Koleksinya lengkap banget! Saya rutin beli buku pelajaran di sini. Pengirimannya cepat, 2 hari sudah sampai. Sangat rekomendasikan untuk para guru.',
                    ],
                    [
                        'name' => 'Budi Santoso',
                        'role' => 'Mahasiswa Teknik',
                        'avatar' => 'BS',
                        'avatarBg' => 'bg-orange-500',
                        'stars' => 5,
                        'text' =>
                            'Harganya jauh lebih murah dibanding toko buku biasa. Kualitas bukunya original dan tidak mengecewakan. Pilihan utama saya untuk buku teknik.',
                    ],
                    [
                        'name' => 'Dewi Anggraini',
                        'role' => 'Ibu Rumah Tangga',
                        'avatar' => 'DA',
                        'avatarBg' => 'bg-indigo-500',
                        'stars' => 5,
                        'text' =>
                            'Anak-anak saya sangat suka dengan buku cerita yang saya beli di sini. Banyak pilihan edukatif. Packing rapi, buku tetap mulus saat diterima.',
                    ],
                ];
            @endphp
            <div class="grid md:grid-cols-3 gap-6 lg:gap-8">
                @foreach ($testimonials as $i => $t)
                    <div class="testi-card anim-fade-up delay-{{ $i + 1 }}">
                        <div class="flex gap-0.5 mb-4">
                            @for ($s = 0; $s < $t['stars']; $s++)
                                <i class="fas fa-star text-amber-400 text-sm"></i>
                            @endfor
                        </div>
                        <p class="text-gray-600 leading-relaxed mb-5 text-sm">{{ $t['text'] }}</p>
                        <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                            <div
                                class="{{ $t['avatarBg'] }} w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                {{ $t['avatar'] }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 text-sm">{{ $t['name'] }}</p>
                                <p class="text-xs text-gray-400">{{ $t['role'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}


    <section class="py-20 bg-gradient-to-r from-blue-800 via-blue-600 to-orange-500 relative overflow-hidden">
        <div class="absolute inset-0 opacity-15 pointer-events-none">
            <div class="absolute top-0 left-0 w-80 h-80 bg-white rounded-full blur-3xl mix-blend-overlay"></div>
            <div class="absolute bottom-0 right-0 w-80 h-80 bg-yellow-300 rounded-full blur-3xl mix-blend-overlay"></div>
        </div>
        <div class="relative z-10 max-w-3xl mx-auto px-4 sm:px-6 text-center text-white anim-fade-up">
            <span class="section-label bg-white/20 text-white border border-white/30 mb-5">
                <i class="fas fa-bolt"></i> Mulai Sekarang
            </span>
            <h2 class="text-3xl lg:text-5xl font-black mt-4 mb-4 leading-tight">
                {{ setting('cta_title', 'Siap Membuka Jendela Dunia Baru?') }}
            </h2>
            <p class="text-white/80 text-lg mb-10">
                {{ setting('cta_subtitle', 'Daftar sekarang dan dapatkan diskon 20% untuk pembelian pertama Anda.') }}
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('register') }}"
                    class="group relative inline-flex items-center gap-2 px-9 py-4 bg-white text-blue-700 font-black text-base rounded-2xl shadow-2xl hover:shadow-orange-400/40 transition-all hover:scale-105 overflow-hidden">
                    <span class="relative z-10 flex items-center gap-2">
                        <i class="fas fa-user-plus"></i> {{ setting('cta_btn_text', 'Daftar Gratis') }}
                    </span>
                    <span
                        class="absolute inset-0 bg-gradient-to-r from-orange-200 to-yellow-200 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                </a>
                <a href="{{ route('books.index') }}"
                    class="inline-flex items-center gap-2 px-9 py-4 bg-white/10 backdrop-blur text-white font-bold text-base rounded-2xl border-2 border-white/30 hover:bg-white/20 transition-all hover:scale-105">
                    <i class="fas fa-book-open"></i> Lihat Katalog
                </a>
            </div>
        </div>
    </section>

@endsection
