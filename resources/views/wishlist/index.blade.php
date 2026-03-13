@extends('layouts.app')

@section('title', 'Wishlist Saya - ATigaBookStore')

@section('content')
    <div style="background:#f3f4f6; min-height:100vh;">

        {{-- ===== MOBILE STICKY HEADER ===== --}}
        <div class="md:hidden"
            style="position:sticky; top:56px; z-index:50; background:#ffffff; border-bottom:1px solid #e5e7eb; padding:10px 16px 8px;">
            <div style="display:flex; align-items:center; justify-content:space-between;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <div
                        style="width:32px; height:32px; background:linear-gradient(135deg,#7c3aed,#ec4899); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-heart" style="color:#fff; font-size:14px;"></i>
                    </div>
                    <div>
                        <div style="font-weight:700; font-size:15px; color:#111827; line-height:1.2;">Wishlist Saya</div>
                        <div style="font-size:11px; color:#6b7280;">{{ $wishlists->count() }} buku tersimpan</div>
                    </div>
                </div>
                <a href="{{ route('books.index') }}"
                    style="display:flex; align-items:center; gap:4px; font-size:12px; font-weight:600; color:#7c3aed; text-decoration:none; background:#f3f0ff; padding:6px 12px; border-radius:20px;">
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
                        <i class="fas fa-heart" style="color:#ef4444;"></i> Wishlist Saya
                    </h1>
                    <p style="color:#6b7280; font-size:15px;">{{ $wishlists->count() }} buku favorit yang Anda simpan</p>
                </div>
            </div>
        </div>

        {{-- ===== CONTENT ===== --}}
        @if ($wishlists->count() > 0)

            {{-- MOBILE: 2-col compact grid --}}
            <div class="md:hidden" style="padding:12px 12px 24px;">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    @foreach ($wishlists as $wishlist)
                        <div style="background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 1px 8px rgba(0,0,0,0.08);"
                            ontouchstart="this.style.transform='scale(0.97)'" ontouchend="this.style.transform='scale(1)'">
                            {{-- Cover --}}
                            <a href="{{ route('books.show', $wishlist->book->slug) }}"
                                style="display:block; position:relative;">
                                @if ($wishlist->book->cover_image)
                                    <img src="{{ asset('storage/' . $wishlist->book->cover_image) }}"
                                        alt="{{ $wishlist->book->title }}"
                                        style="width:100%; height:155px; object-fit:cover; object-position:center top; display:block;">
                                @else
                                    <div
                                        style="width:100%; height:155px; background:linear-gradient(135deg,#ede9fe,#fce7f3); display:flex; align-items:center; justify-content:center;">
                                        <i class="fas fa-book" style="color:#c4b5fd; font-size:36px;"></i>
                                    </div>
                                @endif

                                {{-- Discount badge --}}
                                @if ($wishlist->book->discount > 0)
                                    <div
                                        style="position:absolute; top:6px; left:6px; background:linear-gradient(135deg,#ef4444,#f97316); color:#fff; font-size:10px; font-weight:800; padding:2px 6px; border-radius:8px; line-height:1.4;">
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
                                    style="font-size:10px; font-weight:600; color:#7c3aed; background:#f3f0ff; display:inline-block; padding:2px 8px; border-radius:20px; margin-bottom:5px; max-width:100%; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
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
                                    <div style="font-size:13px; font-weight:800; color:#7c3aed; margin-bottom:8px;">
                                        Rp {{ number_format($wishlist->book->discounted_price, 0, ',', '.') }}
                                    </div>
                                @endif

                                <a href="{{ route('books.show', $wishlist->book->slug) }}"
                                    style="display:block; width:100%; background:linear-gradient(90deg,#7c3aed,#ec4899); color:#fff; font-size:11px; font-weight:700; text-align:center; padding:7px 4px; border-radius:10px; text-decoration:none; box-sizing:border-box;">
                                    <i class="fas fa-eye" style="margin-right:3px;"></i>Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- DESKTOP: original 4-col grid --}}
            <div class="hidden md:block" style="padding:0 32px 40px;">
                <div class="max-w-7xl mx-auto">
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($wishlists as $wishlist)
                            <div
                                class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                                <div class="relative overflow-hidden">
                                    @if ($wishlist->book->cover_image)
                                        <img src="{{ asset('storage/' . $wishlist->book->cover_image) }}"
                                            alt="{{ $wishlist->book->title }}"
                                            class="w-full h-72 object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div
                                            class="w-full h-72 bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center">
                                            <i class="fas fa-book text-purple-300 text-6xl"></i>
                                        </div>
                                    @endif

                                    @if ($wishlist->book->discount > 0)
                                        <div class="absolute top-3 left-3">
                                            <span
                                                class="inline-flex items-center gap-1 bg-gradient-to-r from-red-500 to-orange-500 text-white text-xs font-black px-2 py-1 rounded-lg shadow-sm">
                                                <i class="fas fa-bolt text-yellow-200" style="font-size:9px"></i>
                                                -{{ $wishlist->book->discount }}%
                                            </span>
                                        </div>
                                    @endif

                                    <form action="{{ route('wishlist.destroy', $wishlist) }}" method="POST"
                                        class="absolute top-3 right-3">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-10 h-10 bg-white bg-opacity-90 hover:bg-opacity-100 rounded-full shadow-lg flex items-center justify-center transition-all transform hover:scale-110 text-red-500">
                                            <i class="fas fa-heart text-lg"></i>
                                        </button>
                                    </form>
                                </div>

                                <div class="p-5">
                                    <span class="text-xs text-purple-600 font-semibold bg-purple-50 px-3 py-1 rounded-full">
                                        {{ $wishlist->book->category->name }}
                                    </span>
                                    <h3
                                        class="font-bold text-gray-900 mt-3 mb-2 line-clamp-2 text-lg hover:text-purple-600 transition-colors">
                                        <a
                                            href="{{ route('books.show', $wishlist->book->slug) }}">{{ $wishlist->book->title }}</a>
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-3">
                                        <i class="fas fa-user text-gray-400 mr-1"></i>{{ $wishlist->book->author }}
                                    </p>

                                    <div class="flex justify-between items-end mb-4">
                                        <div>
                                            @if ($wishlist->book->discount > 0)
                                                <div class="flex items-center gap-1.5 mb-1">
                                                    <span class="text-xs text-gray-400 line-through">Rp
                                                        {{ number_format($wishlist->book->price, 0, ',', '.') }}</span>
                                                </div>
                                                <span class="text-xl font-black text-red-600">
                                                    Rp {{ number_format($wishlist->book->discounted_price, 0, ',', '.') }}
                                                </span><br>
                                                <span
                                                    class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full mt-1">
                                                    <i class="fas fa-piggy-bank text-xs"></i> Hemat Rp
                                                    {{ number_format($wishlist->book->price - $wishlist->book->discounted_price, 0, ',', '.') }}
                                                </span>
                                            @else
                                                <span
                                                    class="text-xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                                                    Rp {{ number_format($wishlist->book->discounted_price, 0, ',', '.') }}
                                                </span>
                                            @endif
                                        </div>
                                        @if ($wishlist->book->stock > 0)
                                            <span class="text-xs text-green-600 font-medium"><i
                                                    class="fas fa-check-circle"></i> Tersedia</span>
                                        @else
                                            <span class="text-xs text-red-600 font-medium"><i
                                                    class="fas fa-times-circle"></i> Habis</span>
                                        @endif
                                    </div>

                                    <a href="{{ route('books.show', $wishlist->book->slug) }}"
                                        class="block w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-semibold py-2.5 px-4 rounded-lg text-center transition-all transform hover:scale-105 hover:shadow-lg">
                                        <i class="fas fa-eye mr-2"></i>Lihat Detail
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            {{-- MOBILE EMPTY STATE --}}
            <div class="md:hidden" style="padding:48px 24px; text-align:center;">
                <div
                    style="width:80px; height:80px; background:linear-gradient(135deg,#f3f0ff,#fce7f3); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                    <i class="fas fa-heart-broken" style="font-size:36px; color:#d1d5db;"></i>
                </div>
                <div style="font-size:16px; font-weight:700; color:#374151; margin-bottom:8px;">Wishlist Masih Kosong</div>
                <div style="font-size:13px; color:#6b7280; margin-bottom:24px;">Belum ada buku yang ditambahkan ke wishlist
                </div>
                <a href="{{ route('books.index') }}"
                    style="display:inline-flex; align-items:center; gap:8px; background:linear-gradient(90deg,#7c3aed,#ec4899); color:#fff; font-size:14px; font-weight:700; padding:12px 28px; border-radius:20px; text-decoration:none;">
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
                            class="inline-block bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-semibold py-3 px-8 rounded-lg transition-all transform hover:scale-105 hover:shadow-lg">
                            <i class="fas fa-book mr-2"></i>Jelajahi Buku
                        </a>
                    </div>
                </div>
            </div>

        @endif
    </div>
@endsection
