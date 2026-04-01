@extends('layouts.app')

@section('title', 'Wishlist Saya - ATigaBookStore')
@section('mobile_main_padding', 'pb-20')

@section('content')
    @php
        $wishlistCount = method_exists($wishlists, 'total') ? $wishlists->total() : $wishlists->count();
    @endphp

    <style>
        .wishlist-check-control {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            user-select: none;
        }

        .wishlist-check-dot {
            width: 18px;
            height: 18px;
            border-radius: 9999px;
            border: 2px solid #d1d5db;
            background: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 10px;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .wishlist-check-dot.square {
            border-radius: 6px;
        }

        .wishlist-check-dot.card {
            width: 16px;
            height: 16px;
            border-width: 1.5px;
            font-size: 9px;
            box-shadow: 0 1px 4px rgba(15, 23, 42, 0.16);
        }

        .wishlist-check-control input:checked+.wishlist-check-dot {
            border-color: #2563eb;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.16);
            transform: translateY(-1px);
        }

        .wishlist-check-control input:focus-visible+.wishlist-check-dot {
            outline: 2px solid rgba(37, 99, 235, 0.32);
            outline-offset: 2px;
        }

        .wishlist-check-control input:not(:checked)+.wishlist-check-dot i {
            opacity: 0;
            transform: scale(0.8);
        }

        .wishlist-check-control input:checked+.wishlist-check-dot i {
            opacity: 1;
            transform: scale(1);
            transition: all 0.18s ease;
        }
    </style>

    <div style="background:#f3f4f6; min-height:100vh;">

        {{-- ===== MOBILE STICKY HEADER ===== --}}
        <div class="md:hidden"
            style="position:sticky; top:48px; z-index:20; background:#ffffff; border-bottom:1px solid #e5e7eb; padding:10px 16px 8px;">
            <div style="display:flex; align-items:center; justify-content:space-between;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <div
                        style="width:32px; height:32px; background:linear-gradient(135deg,#2563eb,#1d4ed8); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-heart" style="color:#fff; font-size:14px;"></i>
                    </div>
                    <div>
                        <div style="font-weight:700; font-size:15px; color:#111827; line-height:1.2;">Wishlist Saya</div>
                        <div style="font-size:11px; color:#6b7280;">{{ $wishlistCount }} buku tersimpan</div>
                    </div>
                </div>
                <a href="{{ route('books.index') }}"
                    style="display:flex; align-items:center; gap:4px; font-size:12px; font-weight:600; color:#2563eb; text-decoration:none; background:#eff6ff; padding:6px 12px; border-radius:20px;">
                    <i class="fas fa-plus" style="font-size:10px;"></i> Tambah
                </a>
            </div>
        </div>

        {{-- ===== DESKTOP HEADER ===== --}}
        <div class="hidden md:block" style="padding:32px 32px 0;">
            <div class="max-w-7xl mx-auto">
                <div style="margin-bottom:28px;">
                    <h1
                        style="font-size:28px; font-weight:800; color:#111827; margin-bottom:6px; display:flex; align-items:center; gap:10px;">
                        <i class="fas fa-heart" style="color:#2563eb;"></i> Wishlist Saya
                    </h1>
                    <p style="color:#6b7280; font-size:15px;">{{ $wishlistCount }} buku favorit yang Anda simpan</p>
                </div>
            </div>
        </div>

        {{-- ===== CONTENT ===== --}}
        @if ($wishlists->count() > 0)
            <div id="wishlist-results-anchor"></div>

            <form id="wishlist-bulk-delete-form" method="POST" action="{{ route('wishlist.bulk-destroy') }}"
                class="hidden">
                @csrf
                @method('DELETE')
                <div id="wishlist-bulk-delete-inputs"></div>
            </form>

            {{-- MOBILE: compact responsive grid --}}
            <div class="md:hidden" style="padding:12px 12px 8px;">
                <label
                    style="display:flex; align-items:center; justify-content:space-between; background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:10px 12px; margin-bottom:10px;">
                    <span class="wishlist-check-control">
                        <input type="checkbox" class="wishlist-select-all sr-only" checked>
                        <span class="wishlist-check-dot square"><i class="fas fa-check"></i></span>
                        <span style="font-size:12px; font-weight:700; color:#374151;">Pilih semua item</span>
                    </span>
                    <button type="button" id="wishlist-bulk-delete-btn-mobile"
                        style="font-size:11px; font-weight:700; color:#dc2626; background:#fff1f2; border:1px solid #fecdd3; border-radius:9999px; padding:5px 10px; cursor:pointer;">
                        <i class="fas fa-trash-alt" style="margin-right:4px;"></i> Hapus Terpilih
                    </button>
                </label>

                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(150px, 1fr)); gap:10px;">
                    @foreach ($wishlists as $wishlist)
                        <div style="background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 1px 8px rgba(0,0,0,0.08);"
                            ontouchstart="this.style.transform='scale(0.97)'" ontouchend="this.style.transform='scale(1)'">
                            {{-- Cover --}}
                            <div style="position:relative;">
                                <label class="wishlist-check-control"
                                    style="position:absolute; top:8px; left:8px; z-index:12; padding:0;">
                                    <input type="checkbox" class="wishlist-item-checkbox sr-only"
                                        data-item-id="{{ $wishlist->id }}" checked>
                                    <span class="wishlist-check-dot square card"><i class="fas fa-check"></i></span>
                                </label>

                                <a href="{{ route('books.show', $wishlist->book->slug) }}"
                                    style="display:block; position:relative;">
                                    @if ($wishlist->book->cover_image)
                                        <img src="{{ asset('storage/' . $wishlist->book->cover_image) }}"
                                            alt="{{ $wishlist->book->title }}"
                                            style="width:100%; height:155px; object-fit:cover; object-position:center top; display:block;">
                                    @else
                                        <div
                                            style="width:100%; height:155px; background:linear-gradient(135deg,#dbeafe,#eff6ff); display:flex; align-items:center; justify-content:center;">
                                            <i class="fas fa-book" style="color:#93c5fd; font-size:36px;"></i>
                                        </div>
                                    @endif

                                    {{-- Discount badge --}}
                                    @if ($wishlist->book->discount > 0)
                                        <div
                                            style="position:absolute; top:8px; left:32px; background:linear-gradient(135deg,#ef4444,#f97316); color:#fff; font-size:10px; font-weight:800; padding:2px 6px; border-radius:8px; line-height:1.4;">
                                            -{{ $wishlist->book->discount }}%
                                        </div>
                                    @endif

                                    {{-- Stock badge --}}
                                    @if ($wishlist->book->stock <= 0)
                                        <div
                                            style="position:absolute; bottom:0; left:0; right:0; background:rgba(0,0,0,0.55); color:#fff; font-size:10px; font-weight:600; text-align:center; padding:3px 0;">
                                            Stok Habis
                                        </div>
                                    @endif
                                </a>
                            </div>

                            {{-- Remove button --}}
                            <div style="position:relative;">
                                <form action="{{ route('wishlist.destroy', $wishlist) }}" method="POST"
                                    style="position:absolute; top:-16px; right:8px; z-index:10;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="width:30px; height:30px; background:#fff; border:none; border-radius:50%; box-shadow:0 2px 8px rgba(0,0,0,0.15); display:flex; align-items:center; justify-content:center; cursor:pointer; color:#ef4444; padding:0;">
                                        <i class="fas fa-heart" style="font-size:13px;"></i>
                                    </button>
                                </form>
                            </div>

                            {{-- Info --}}
                            <div style="padding:10px 10px 12px;">
                                <div
                                    style="font-size:10px; font-weight:600; color:#2563eb; background:#eff6ff; display:inline-block; padding:2px 8px; border-radius:20px; margin-bottom:5px; max-width:100%; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                    {{ $wishlist->book->category->name }}
                                </div>
                                <div
                                    style="font-size:12px; font-weight:700; color:#111827; line-height:1.35; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; margin-bottom:4px; min-height:32px;">
                                    {{ $wishlist->book->title }}
                                </div>
                                <div
                                    style="font-size:11px; color:#9ca3af; margin-bottom:6px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                    {{ $wishlist->book->author }}
                                </div>

                                {{-- Price --}}
                                @if ($wishlist->book->discount > 0)
                                    <div
                                        style="font-size:13px; font-weight:800; color:#dc2626; line-height:1.2; margin-bottom:2px;">
                                        Rp {{ number_format($wishlist->book->discounted_price, 0, ',', '.') }}
                                    </div>
                                    <div
                                        style="font-size:10px; color:#9ca3af; text-decoration:line-through; margin-bottom:6px;">
                                        Rp {{ number_format($wishlist->book->price, 0, ',', '.') }}
                                    </div>
                                @else
                                    <div style="font-size:13px; font-weight:800; color:#2563eb; margin-bottom:8px;">
                                        Rp {{ number_format($wishlist->book->discounted_price, 0, ',', '.') }}
                                    </div>
                                @endif

                                <a href="{{ route('books.show', $wishlist->book->slug) }}"
                                    style="display:block; width:100%; background:linear-gradient(90deg,#2563eb,#1d4ed8); color:#fff; font-size:11px; font-weight:700; text-align:center; padding:7px 4px; border-radius:10px; text-decoration:none; box-sizing:border-box;">
                                    <i class="fas fa-eye" style="margin-right:3px;"></i>Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- DESKTOP: compact grid like catalog --}}
            <div class="hidden md:block" style="padding:0 32px 40px;">
                <div class="max-w-7xl mx-auto">
                    <label
                        style="display:inline-flex; align-items:center; gap:10px; padding:8px 12px; border:1px solid #e5e7eb; border-radius:9999px; background:#fff; margin-bottom:14px;">
                        <span class="wishlist-check-control">
                            <input type="checkbox" class="wishlist-select-all sr-only" checked>
                            <span class="wishlist-check-dot square"><i class="fas fa-check"></i></span>
                            <span class="text-sm font-semibold text-gray-700">Pilih semua item</span>
                        </span>
                        <button type="button" id="wishlist-bulk-delete-btn-desktop"
                            style="font-size:12px; font-weight:700; color:#dc2626; background:#fff1f2; border:1px solid #fecdd3; border-radius:9999px; padding:6px 12px; cursor:pointer; margin-left:6px;">
                            <i class="fas fa-trash-alt" style="margin-right:5px;"></i> Hapus Terpilih
                        </button>
                    </label>

                    <div
                        style="display:grid; grid-template-columns:repeat(auto-fill, minmax(190px, 1fr)); gap:16px; margin-bottom:24px;">
                        @foreach ($wishlists as $wishlist)
                            <div style="background:#fff; border-radius:16px; box-shadow:0 2px 10px rgba(0,0,0,0.07); overflow:hidden; display:flex; flex-direction:column; transition:transform 0.2s, box-shadow 0.2s;"
                                onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 28px rgba(0,0,0,0.13)';"
                                onmouseout="this.style.transform=''; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.07)';">

                                <div style="position:relative; overflow:hidden;">
                                    <label class="wishlist-check-control"
                                        style="position:absolute; top:8px; left:8px; z-index:4; padding:0;">
                                        <input type="checkbox" class="wishlist-item-checkbox sr-only"
                                            data-item-id="{{ $wishlist->id }}" checked>
                                        <span class="wishlist-check-dot square card"><i class="fas fa-check"></i></span>
                                    </label>

                                    @if ($wishlist->book->cover_image)
                                        <img src="{{ asset('storage/' . $wishlist->book->cover_image) }}"
                                            alt="{{ $wishlist->book->title }}"
                                            style="width:100%; height:195px; object-fit:cover; object-position:center top; display:block; transition:transform 0.4s;"
                                            onmouseover="this.style.transform='scale(1.06)'"
                                            onmouseout="this.style.transform=''">
                                    @else
                                        <div
                                            style="width:100%; height:195px; background:linear-gradient(135deg,#dbeafe,#eff6ff); display:flex; align-items:center; justify-content:center;">
                                            <i class="fas fa-book" style="font-size:40px; color:#93c5fd;"></i>
                                        </div>
                                    @endif

                                    @if ($wishlist->book->discount > 0)
                                        <div
                                            style="position:absolute; top:8px; left:32px; background:linear-gradient(135deg,#ef4444,#f97316); color:#fff; font-size:10px; font-weight:800; padding:2px 8px; border-radius:8px; z-index:2;">
                                            <span style="display:inline-flex; align-items:center; gap:4px;">
                                                <i class="fas fa-bolt" style="font-size:9px; color:#fde68a;"></i>
                                                -{{ $wishlist->book->discount }}%
                                            </span>
                                        </div>
                                    @endif

                                    <form action="{{ route('wishlist.destroy', $wishlist) }}" method="POST"
                                        style="position:absolute; top:8px; right:8px; z-index:3;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            style="width:30px; height:30px; background:#fff; border:none; border-radius:50%; box-shadow:0 2px 8px rgba(0,0,0,0.12); display:flex; align-items:center; justify-content:center; cursor:pointer; color:#ef4444; padding:0;">
                                            <i class="fas fa-heart" style="font-size:13px;"></i>
                                        </button>
                                    </form>
                                </div>

                                <div style="padding:12px 12px 14px; flex:1; display:flex; flex-direction:column;">
                                    <span
                                        style="font-size:10px; font-weight:600; color:#2563eb; background:#eff6ff; display:inline-block; padding:2px 8px; border-radius:20px; margin-bottom:6px; max-width:100%; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                        {{ $wishlist->book->category->name }}
                                    </span>
                                    <a href="{{ route('books.show', $wishlist->book->slug) }}"
                                        style="font-size:13px; font-weight:700; color:#111827; text-decoration:none; line-height:1.35; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; margin-bottom:3px; flex:1; min-height:35px;"
                                        onmouseover="this.style.color='#2563eb'" onmouseout="this.style.color='#111827'">
                                        {{ $wishlist->book->title }}
                                    </a>
                                    <p
                                        style="font-size:11px; color:#9ca3af; margin-bottom:8px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                        {{ $wishlist->book->author }}
                                    </p>

                                    <div
                                        style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:10px;">
                                        <div>
                                            @if ($wishlist->book->discount > 0)
                                                <div style="display:flex; align-items:center; gap:6px; margin-bottom:1px;">
                                                    <span
                                                        style="font-size:10px; color:#9ca3af; text-decoration:line-through;">Rp
                                                        {{ number_format($wishlist->book->price, 0, ',', '.') }}</span>
                                                </div>
                                                <span
                                                    style="font-size:16px; font-weight:900; color:#dc2626; line-height:1.2;">Rp
                                                    {{ number_format($wishlist->book->discounted_price, 0, ',', '.') }}</span><br>
                                                <span
                                                    style="display:inline-flex; align-items:center; gap:4px; font-size:10px; font-weight:700; color:#047857; background:#ecfdf5; border:1px solid #a7f3d0; padding:2px 8px; border-radius:9999px; margin-top:3px;">
                                                    <i class="fas fa-piggy-bank" style="font-size:10px;"></i> Hemat Rp
                                                    {{ number_format($wishlist->book->price - $wishlist->book->discounted_price, 0, ',', '.') }}
                                                </span>
                                            @else
                                                <span style="font-size:16px; font-weight:900; color:#2563eb;">
                                                    Rp {{ number_format($wishlist->book->discounted_price, 0, ',', '.') }}
                                                </span>
                                            @endif
                                        </div>
                                        @if ($wishlist->book->stock > 0)
                                            <span style="font-size:10px; color:#059669; font-weight:700;"><i
                                                    class="fas fa-check-circle"></i> Tersedia</span>
                                        @else
                                            <span style="font-size:10px; color:#dc2626; font-weight:700;"><i
                                                    class="fas fa-times-circle"></i> Habis</span>
                                        @endif
                                    </div>

                                    <a href="{{ route('books.show', $wishlist->book->slug) }}"
                                        style="display:block; width:100%; background:linear-gradient(90deg,#2563eb,#1d4ed8); color:#fff; font-size:12px; font-weight:700; text-align:center; padding:8px 6px; border-radius:10px; text-decoration:none; box-sizing:border-box;">
                                        <i class="fas fa-eye" style="margin-right:4px;"></i>Lihat Detail
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @if (method_exists($wishlists, 'hasPages') && $wishlists->hasPages())
                @php
                    $current = $wishlists->currentPage();
                    $last = $wishlists->lastPage();
                    $start = max(1, $current - 2);
                    $end = min($last, $current + 2);
                    $pages = [];

                    if ($start > 1) {
                        $pages[] = 1;
                        if ($start > 2) {
                            $pages[] = '...';
                        }
                    }

                    for ($i = $start; $i <= $end; $i++) {
                        $pages[] = $i;
                    }

                    if ($end < $last) {
                        if ($end < $last - 1) {
                            $pages[] = '...';
                        }
                        $pages[] = $last;
                    }
                @endphp
                <div style="padding:0 16px 12px;">
                    <div class="max-w-7xl mx-auto">
                        <p style="text-align:center; font-size:12px; color:#6b7280; margin-bottom:8px;">
                            Halaman {{ $current }} dari {{ $last }}
                        </p>
                        <div style="display:flex; justify-content:center;">
                            <nav aria-label="Pagination"
                                style="display:inline-flex; align-items:center; gap:6px; flex-wrap:wrap; background:#fff; border:1px solid #dbeafe; border-radius:14px; padding:6px; box-shadow:0 6px 20px rgba(37,99,235,0.12);">
                                {{-- Prev --}}
                                @if ($wishlists->onFirstPage())
                                    <span
                                        style="width:36px; height:36px; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#cbd5e1; background:#f8fafc; cursor:not-allowed;">
                                        <i class="fas fa-chevron-left" style="font-size:12px;"></i>
                                    </span>
                                @else
                                    <a href="{{ $wishlists->previousPageUrl() }}" data-pagination-link="true"
                                        style="width:36px; height:36px; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#2563eb; text-decoration:none; background:#eff6ff;">
                                        <i class="fas fa-chevron-left" style="font-size:12px;"></i>
                                    </a>
                                @endif

                                {{-- Page numbers --}}
                                @foreach ($pages as $page)
                                    @if ($page === '...')
                                        <span
                                            style="min-width:28px; height:36px; display:flex; align-items:center; justify-content:center; color:#94a3b8; font-weight:700;">...</span>
                                    @elseif ($page == $wishlists->currentPage())
                                        <span
                                            style="min-width:36px; height:36px; padding:0 10px; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#fff; font-weight:700; font-size:13px; background:linear-gradient(90deg,#2563eb,#1d4ed8);">
                                            {{ $page }}
                                        </span>
                                    @else
                                        @php $url = $wishlists->url($page); @endphp
                                        <a href="{{ $url }}" data-pagination-link="true"
                                            style="min-width:36px; height:36px; padding:0 10px; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#334155; font-weight:600; font-size:13px; text-decoration:none; background:#f8fafc;">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                {{-- Next --}}
                                @if ($wishlists->hasMorePages())
                                    <a href="{{ $wishlists->nextPageUrl() }}" data-pagination-link="true"
                                        style="width:36px; height:36px; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#2563eb; text-decoration:none; background:#eff6ff;">
                                        <i class="fas fa-chevron-right" style="font-size:12px;"></i>
                                    </a>
                                @else
                                    <span
                                        style="width:36px; height:36px; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#cbd5e1; background:#f8fafc; cursor:not-allowed;">
                                        <i class="fas fa-chevron-right" style="font-size:12px;"></i>
                                    </span>
                                @endif
                            </nav>
                        </div>
                    </div>
                </div>
            @endif
        @else
            {{-- MOBILE EMPTY STATE --}}
            <div class="md:hidden" style="padding:48px 24px; text-align:center;">
                <div
                    style="width:80px; height:80px; background:linear-gradient(135deg,#dbeafe,#eff6ff); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                    <i class="fas fa-heart-broken" style="font-size:36px; color:#d1d5db;"></i>
                </div>
                <div style="font-size:16px; font-weight:700; color:#374151; margin-bottom:8px;">Wishlist Masih Kosong</div>
                <div style="font-size:13px; color:#6b7280; margin-bottom:24px;">Belum ada buku yang ditambahkan ke wishlist
                </div>
                <a href="{{ route('books.index') }}"
                    style="display:inline-flex; align-items:center; gap:8px; background:linear-gradient(90deg,#2563eb,#1d4ed8); color:#fff; font-size:14px; font-weight:700; padding:12px 28px; border-radius:20px; text-decoration:none;">
                    <i class="fas fa-book"></i> Jelajahi Buku
                </a>
            </div>

            {{-- DESKTOP EMPTY STATE --}}
            <div class="hidden md:block" style="padding:0 32px 40px;">
                <div class="max-w-7xl mx-auto">
                    <div class="bg-white rounded-xl shadow-lg p-16 text-center">
                        <i class="fas fa-heart-broken text-gray-300 text-6xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">Wishlist Anda Kosong</h3>
                        <p class="text-gray-500 mb-6">Belum ada buku yang ditambahkan ke wishlist</p>
                        <a href="{{ route('books.index') }}"
                            class="inline-block bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-8 rounded-lg transition-all transform hover:scale-105 hover:shadow-lg">
                            <i class="fas fa-book mr-2"></i>Jelajahi Buku
                        </a>
                    </div>
                </div>
            </div>

        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-pagination-link="true"]').forEach((link) => {
                link.addEventListener('click', (event) => {
                    event.preventDefault();
                    const anchor = document.getElementById('wishlist-results-anchor');
                    if (anchor) {
                        anchor.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }

                    setTimeout(() => {
                        window.location.href = link.href;
                    }, 120);
                });
            });

            const itemCheckboxes = document.querySelectorAll('.wishlist-item-checkbox');
            const selectAllCheckboxes = document.querySelectorAll('.wishlist-select-all');
            const bulkDeleteButtons = document.querySelectorAll(
                '#wishlist-bulk-delete-btn-mobile, #wishlist-bulk-delete-btn-desktop');
            const bulkDeleteForm = document.getElementById('wishlist-bulk-delete-form');
            const bulkDeleteInputs = document.getElementById('wishlist-bulk-delete-inputs');

            const getSelectedIds = () => {
                return Array.from(itemCheckboxes)
                    .filter((checkbox) => checkbox.checked)
                    .map((checkbox) => checkbox.dataset.itemId)
                    .filter((id) => !!id);
            };

            const syncBulkDeleteState = () => {
                const selectedCount = getSelectedIds().length;

                bulkDeleteButtons.forEach((button) => {
                    const disabled = selectedCount < 1;
                    button.disabled = disabled;
                    button.style.opacity = disabled ? '0.45' : '1';
                    button.style.cursor = disabled ? 'not-allowed' : 'pointer';
                });
            };

            const syncSelectAll = () => {
                const totalItems = itemCheckboxes.length;
                const selectedItems = Array.from(itemCheckboxes).filter((checkbox) => checkbox.checked).length;
                const allChecked = totalItems > 0 && selectedItems === totalItems;

                selectAllCheckboxes.forEach((checkbox) => {
                    checkbox.checked = allChecked;
                });

                syncBulkDeleteState();
            };

            itemCheckboxes.forEach((checkbox) => {
                checkbox.addEventListener('change', syncSelectAll);
            });

            selectAllCheckboxes.forEach((checkbox) => {
                checkbox.addEventListener('change', (event) => {
                    const checked = event.target.checked;

                    itemCheckboxes.forEach((itemCheckbox) => {
                        itemCheckbox.checked = checked;
                    });

                    selectAllCheckboxes.forEach((selectAllCheckbox) => {
                        selectAllCheckbox.checked = checked;
                    });

                    syncBulkDeleteState();
                });
            });

            bulkDeleteButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    const selectedIds = getSelectedIds();

                    if (selectedIds.length < 1) {
                        if (typeof window.showToast === 'function') {
                            window.showToast('error', 'Pilih minimal 1 item untuk dihapus.');
                        }
                        return;
                    }

                    if (!bulkDeleteForm || !bulkDeleteInputs) {
                        return;
                    }

                    bulkDeleteInputs.innerHTML = '';
                    selectedIds.forEach((id) => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'wishlist_ids[]';
                        input.value = id;
                        bulkDeleteInputs.appendChild(input);
                    });

                    bulkDeleteForm.submit();
                });
            });

            syncSelectAll();
        });
    </script>
@endsection
