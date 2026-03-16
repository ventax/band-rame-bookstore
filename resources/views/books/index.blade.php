@extends('layouts.app')

@section('title', 'Katalog Buku - ATigaBookStore')
@section('mobile_main_padding', 'pb-20')

@section('content')
    <div x-data="booksInteractive()">
        @php
            $bookPageQuery = [
                'category' => request('category'),
                'search' => request('search'),
                'sort' => request('sort'),
            ];
            $bookCurrent = $books->currentPage();
            $bookLast = $books->lastPage();
            $bookStart = max(1, $bookCurrent - 2);
            $bookEnd = min($bookLast, $bookCurrent + 2);
            $bookPages = [];

            if ($bookStart > 1) {
                $bookPages[] = 1;
                if ($bookStart > 2) {
                    $bookPages[] = '...';
                }
            }

            for ($i = $bookStart; $i <= $bookEnd; $i++) {
                $bookPages[] = $i;
            }

            if ($bookEnd < $bookLast) {
                if ($bookEnd < $bookLast - 1) {
                    $bookPages[] = '...';
                }
                $bookPages[] = $bookLast;
            }
        @endphp

        <div id="books-results-anchor"></div>

        {{-- ───────── MOBILE HEADER ───────── --}}
        <div class="md:hidden"
            style="position:sticky; top:48px; z-index:20; background:#ffffff; box-shadow:0 1px 6px rgba(0,0,0,0.07); border-bottom:1px solid #f3f4f6; padding:10px 12px 8px;"
            x-data="{
                searchQuery: '{{ request('search') }}',
                showFilter: false,
                searchTimeout: null,
                liveSearch() {
                    clearTimeout(this.searchTimeout);
                    this.searchTimeout = setTimeout(() => {
                        let params = [];
                        if (this.searchQuery) params.push('search=' + encodeURIComponent(this.searchQuery));
                        if ('{{ request('category') }}') params.push('category={{ request('category') }}');
                        if ('{{ request('sort') }}') params.push('sort={{ request('sort') }}');
                        window.location.href = '{{ route('books.index') }}' + (params.length ? '?' + params.join('&') : '');
                    }, 600);
                }
            }">
            {{-- Search row --}}
            <div class="flex gap-2">
                <div class="relative flex-1">
                    <i
                        class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                    <input type="text" x-model="searchQuery" @input="liveSearch()" placeholder="Cari buku, penulis…"
                        class="w-full pl-9 pr-8 py-2 text-sm rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none bg-gray-50">
                    <button x-show="searchQuery" @click="searchQuery=''; liveSearch()"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 text-xs">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                {{-- Sort --}}
                <select
                    onchange="window.location.href='{{ route('books.index') }}?sort='+this.value+'&category={{ request('category') }}&search={{ request('search') }}'"
                    class="text-xs px-2 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:border-blue-400 outline-none">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Termurah</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Termahal</option>
                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>A–Z</option>
                </select>
            </div>

            {{-- Category pills (horizontal scroll) --}}
            <div class="flex gap-2 mt-2 overflow-x-auto pb-1 scrollbar-hide" style="-webkit-overflow-scrolling:touch;">
                <a href="{{ route('books.index', ['search' => request('search'), 'sort' => request('sort')]) }}"
                    class="flex-shrink-0 text-xs font-bold px-3 py-1.5 rounded-full whitespace-nowrap transition-all
                          {{ !request('category') ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600' }}">
                    Semua
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('books.index', ['category' => $cat->id, 'search' => request('search'), 'sort' => request('sort')]) }}"
                        class="flex-shrink-0 text-xs font-bold px-3 py-1.5 rounded-full whitespace-nowrap transition-all
                              {{ request('category') == $cat->id ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600' }}">
                        {{ $cat->name }}
                        <span class="ml-0.5 opacity-70">({{ $cat->books_count }})</span>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- ───────── DESKTOP LAYOUT ───────── --}}
        <div class="hidden md:block" style="background:#f3f4f6; min-height:100vh; padding:28px 32px 48px;">
            <div class="max-w-7xl mx-auto">

                {{-- Page title --}}
                <div style="margin-bottom:20px;">
                    <h1 style="font-size:22px; font-weight:800; color:#111827;">Katalog Buku</h1>
                    <p style="font-size:12px; color:#9ca3af; margin-top:2px;">{{ $books->total() }} buku tersedia</p>
                </div>

                {{-- Main: sidebar + right column --}}
                <div style="display:grid; grid-template-columns:210px 1fr; gap:20px; align-items:start;">

                    {{-- Sidebar --}}
                    <div
                        style="background:#fff; border-radius:16px; box-shadow:0 2px 10px rgba(0,0,0,0.06); padding:20px; position:sticky; top:90px;">
                        <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px;">
                            <i class="fas fa-layer-group" style="color:#7c3aed; font-size:14px;"></i>
                            <span style="font-size:14px; font-weight:700; color:#111827;">Kategori</span>
                        </div>
                        <div style="display:flex; flex-direction:column; gap:2px;">
                            <a href="{{ route('books.index', ['search' => request('search'), 'sort' => request('sort')]) }}"
                                style="display:flex; align-items:center; justify-content:space-between; padding:8px 10px; border-radius:10px; font-size:13px; font-weight:{{ !request('category') ? '700' : '500' }}; text-decoration:none; transition:background 0.15s;
                               {{ !request('category') ? 'background:linear-gradient(90deg,#ede9fe,#fce7f3); color:#6d28d9;' : 'color:#374151;' }}"
                                onmouseover="{{ !request('category') ? '' : "this.style.background='#f9fafb'" }}"
                                onmouseout="{{ !request('category') ? '' : "this.style.background=''" }}">
                                <span>Semua</span>
                                <span
                                    style="font-size:11px; padding:2px 8px; border-radius:20px; {{ !request('category') ? 'background:#ddd6fe; color:#6d28d9;' : 'background:#f3f4f6; color:#6b7280;' }}">{{ $categories->sum('books_count') }}</span>
                            </a>
                            @foreach ($categories as $category)
                                @php $isActive = request('category') == $category->id; @endphp
                                <a href="{{ route('books.index', ['category' => $category->id, 'search' => request('search'), 'sort' => request('sort')]) }}"
                                    style="display:flex; align-items:center; justify-content:space-between; padding:8px 10px; border-radius:10px; font-size:13px; font-weight:{{ $isActive ? '700' : '500' }}; text-decoration:none; transition:background 0.15s;
                               {{ $isActive ? 'background:linear-gradient(90deg,#ede9fe,#fce7f3); color:#6d28d9;' : 'color:#374151;' }}"
                                    onmouseover="{{ $isActive ? '' : "this.style.background='#f9fafb'" }}"
                                    onmouseout="{{ $isActive ? '' : "this.style.background=''" }}">
                                    <span>{{ $category->name }}</span>
                                    <span
                                        style="font-size:11px; padding:2px 8px; border-radius:20px; {{ $isActive ? 'background:#ddd6fe; color:#6d28d9;' : 'background:#f3f4f6; color:#6b7280;' }}">{{ $category->books_count }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Right column: search bar + filter chips + book grid --}}
                    <div x-data="{
                        searchQuery: '{{ request('search') }}',
                        searchTimeout: null,
                        liveSearch() {
                            clearTimeout(this.searchTimeout);
                            this.searchTimeout = setTimeout(() => {
                                let params = [];
                                if (this.searchQuery) params.push('search=' + encodeURIComponent(this.searchQuery));
                                if ('{{ request('category') }}') params.push('category={{ request('category') }}');
                                if ('{{ request('sort') }}') params.push('sort={{ request('sort') }}');
                                window.location.href = '{{ route('books.index') }}' + (params.length ? '?' + params.join('&') : '');
                            }, 500);
                        }
                    }">
                        {{-- Search + Sort bar --}}
                        <div style="display:flex; align-items:center; gap:12px; margin-bottom:16px;">
                            {{-- Search --}}
                            <div style="flex:1; position:relative;">
                                <i class="fas fa-search"
                                    style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#9ca3af; font-size:13px; pointer-events:none;"></i>
                                <input type="text" x-model="searchQuery" @input="liveSearch()"
                                    placeholder="Cari judul, penulis…"
                                    style="width:100%; padding:10px 36px 10px 38px; border:1.5px solid #e5e7eb; border-radius:12px; font-size:13px; outline:none; background:#fff; box-sizing:border-box; transition:border-color 0.2s;"
                                    onfocus="this.style.borderColor='#7c3aed'" onblur="this.style.borderColor='#e5e7eb'">
                                <button x-show="searchQuery" @click="searchQuery=''; liveSearch()"
                                    style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#9ca3af; font-size:12px; padding:0;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            {{-- Sort --}}
                            <div style="position:relative;">
                                <select
                                    onchange="window.location.href='{{ route('books.index') }}?sort='+this.value+'&category={{ request('category') }}&search={{ request('search') }}'"
                                    style="appearance:none; padding:10px 36px 10px 14px; border:1.5px solid #e5e7eb; border-radius:12px; font-size:13px; color:#374151; background:#fff; outline:none; cursor:pointer; white-space:nowrap;">
                                    <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>
                                        Terbaru</option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>
                                        Termurah</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>
                                        Termahal</option>
                                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>A–Z</option>
                                </select>
                                <i class="fas fa-chevron-down"
                                    style="position:absolute; right:12px; top:50%; transform:translateY(-50%); color:#9ca3af; font-size:11px; pointer-events:none;"></i>
                            </div>
                        </div>

                        {{-- Active filter chips --}}
                        @if (request('category') || request('search'))
                            <div style="display:flex; align-items:center; gap:8px; margin-bottom:14px; flex-wrap:wrap;">
                                <span style="font-size:12px; color:#6b7280;">Filter aktif:</span>
                                @if (request('search'))
                                    <span
                                        style="display:inline-flex; align-items:center; gap:5px; background:#ede9fe; color:#6d28d9; font-size:12px; font-weight:600; padding:4px 12px; border-radius:20px;">
                                        <i class="fas fa-search" style="font-size:10px;"></i> "{{ request('search') }}"
                                    </span>
                                @endif
                                @if (request('category'))
                                    @php $activeCat = $categories->firstWhere('id', request('category')); @endphp
                                    @if ($activeCat)
                                        <span
                                            style="display:inline-flex; align-items:center; gap:5px; background:#ede9fe; color:#6d28d9; font-size:12px; font-weight:600; padding:4px 12px; border-radius:20px;">
                                            <i class="fas fa-tag" style="font-size:10px;"></i> {{ $activeCat->name }}
                                        </span>
                                    @endif
                                @endif
                                <a href="{{ route('books.index', ['sort' => request('sort')]) }}"
                                    style="font-size:12px; color:#ef4444; font-weight:600; text-decoration:none;">
                                    <i class="fas fa-times-circle"></i> Hapus semua
                                </a>
                            </div>
                        @endif
                        @if ($books->count() > 0)
                            <div
                                style="display:grid; grid-template-columns:repeat(auto-fill, minmax(190px, 1fr)); gap:16px; margin-bottom:24px;">
                                @foreach ($books as $book)
                                    <div style="background:#fff; border-radius:16px; box-shadow:0 2px 10px rgba(0,0,0,0.07); overflow:hidden; display:flex; flex-direction:column; transition:transform 0.2s, box-shadow 0.2s; cursor:pointer;"
                                        onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 28px rgba(0,0,0,0.13)';"
                                        onmouseout="this.style.transform=''; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.07)';">

                                        {{-- Cover --}}
                                        <a href="{{ route('books.show', $book->slug) }}"
                                            style="display:block; position:relative; overflow:hidden;">
                                            @if ($book->cover_image)
                                                <img src="{{ asset('storage/' . $book->cover_image) }}"
                                                    alt="{{ $book->title }}"
                                                    style="width:100%; height:195px; object-fit:cover; object-position:center top; display:block; transition:transform 0.4s;"
                                                    onmouseover="this.style.transform='scale(1.06)'"
                                                    onmouseout="this.style.transform=''">
                                            @else
                                                <div
                                                    style="width:100%; height:195px; background:linear-gradient(135deg,#eff6ff,#ffedd5); display:flex; align-items:center; justify-content:center;">
                                                    <i class="fas fa-book" style="font-size:40px; color:#93c5fd;"></i>
                                                </div>
                                            @endif

                                            {{-- Discount badge --}}
                                            @if ($book->discount > 0)
                                                <div
                                                    style="position:absolute; top:8px; left:8px; background:linear-gradient(135deg,#ef4444,#f97316); color:#fff; font-size:10px; font-weight:800; padding:2px 8px; border-radius:8px; z-index:2;">
                                                    -{{ $book->discount }}%
                                                </div>
                                            @elseif($loop->index < 4)
                                                <div
                                                    style="position:absolute; top:8px; left:8px; background:#f59e0b; color:#fff; font-size:10px; font-weight:800; padding:2px 8px; border-radius:8px; z-index:2;">
                                                    ★ Best
                                                </div>
                                            @endif

                                            {{-- Quick view overlay --}}
                                            <div style="position:absolute; inset:0; background:rgba(0,0,0,0); display:flex; align-items:center; justify-content:center; transition:background 0.3s; z-index:1;"
                                                onmouseover="this.style.background='rgba(0,0,0,0.45)'; this.querySelector('.qv-btn').style.opacity='1'; this.querySelector('.qv-btn').style.transform='translateY(0)';"
                                                onmouseout="this.style.background='rgba(0,0,0,0)'; this.querySelector('.qv-btn').style.opacity='0'; this.querySelector('.qv-btn').style.transform='translateY(8px)';"
                                                @click.prevent="quickView({{ $book->id }})">
                                                <div class="qv-btn"
                                                    style="background:#fff; color:#7c3aed; font-size:12px; font-weight:700; padding:8px 16px; border-radius:10px; opacity:0; transform:translateY(8px); transition:opacity 0.25s, transform 0.25s; pointer-events:none;">
                                                    <i class="fas fa-eye" style="margin-right:5px;"></i>Quick View
                                                </div>
                                            </div>
                                        </a>

                                        {{-- Wishlist --}}
                                        @auth
                                            <div style="position:relative;">
                                                <button @click="toggleWishlist({{ $book->id }}, $event)"
                                                    :class="wishlistBooks.includes({{ $book->id }}) ? 'text-red-500' :
                                                        'text-gray-400'"
                                                    style="position:absolute; top:-36px; right:8px; width:30px; height:30px; background:#fff; border:none; border-radius:50%; box-shadow:0 2px 8px rgba(0,0,0,0.12); display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:13px; z-index:3;">
                                                    <i :class="wishlistBooks.includes({{ $book->id }}) ? 'fas' : 'far'"
                                                        class="fa-heart"></i>
                                                </button>
                                            </div>
                                        @endauth

                                        {{-- Info --}}
                                        <div style="padding:12px 12px 14px; flex:1; display:flex; flex-direction:column;">
                                            <div
                                                style="font-size:10px; font-weight:600; color:#2563eb; background:#eff6ff; display:inline-block; padding:2px 8px; border-radius:20px; margin-bottom:6px; max-width:100%; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                                {{ $book->category->name }}
                                            </div>
                                            <a href="{{ route('books.show', $book->slug) }}"
                                                style="font-size:13px; font-weight:700; color:#111827; text-decoration:none; line-height:1.35; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; margin-bottom:3px; flex:1; min-height:35px;"
                                                onmouseover="this.style.color='#2563eb'"
                                                onmouseout="this.style.color='#111827'">
                                                {{ $book->title }}
                                            </a>
                                            <div
                                                style="font-size:11px; color:#9ca3af; margin-bottom:8px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                                {{ $book->author }}
                                            </div>

                                            {{-- Price --}}
                                            <div style="margin-bottom:10px;">
                                                @if ($book->discount > 0)
                                                    <div
                                                        style="font-size:11px; color:#9ca3af; text-decoration:line-through; line-height:1.2;">
                                                        Rp {{ number_format($book->price, 0, ',', '.') }}
                                                    </div>
                                                    <div
                                                        style="font-size:16px; font-weight:900; color:#dc2626; line-height:1.2;">
                                                        Rp {{ number_format($book->discounted_price, 0, ',', '.') }}
                                                    </div>
                                                    <div
                                                        style="display:inline-flex; align-items:center; gap:3px; background:#ecfdf5; border:1px solid #6ee7b7; color:#065f46; font-size:10px; font-weight:700; padding:2px 7px; border-radius:20px; margin-top:2px;">
                                                        <i class="fas fa-piggy-bank" style="font-size:9px;"></i>
                                                        Hemat Rp
                                                        {{ number_format($book->price - $book->discounted_price, 0, ',', '.') }}
                                                    </div>
                                                @else
                                                    <div
                                                        style="font-size:16px; font-weight:900; color:#2563eb; line-height:1.2;">
                                                        Rp {{ number_format($book->discounted_price, 0, ',', '.') }}
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- Stock + CTA --}}
                                            @auth
                                                @if ($book->stock > 0)
                                                    <button @click="addToCart({{ $book->id }})"
                                                        style="display:flex; align-items:center; justify-content:center; gap:6px; width:100%; background:linear-gradient(90deg,#2563eb,#1d4ed8); color:#fff; font-size:12px; font-weight:700; padding:9px; border:none; border-radius:10px; cursor:pointer; transition:opacity 0.2s; box-sizing:border-box;"
                                                        onmouseover="this.style.opacity='0.88'"
                                                        onmouseout="this.style.opacity='1'">
                                                        <i class="fas fa-shopping-cart"></i> Keranjang
                                                    </button>
                                                @else
                                                    <button disabled
                                                        style="width:100%; background:#f3f4f6; color:#9ca3af; font-size:12px; font-weight:700; padding:9px; border:none; border-radius:10px; cursor:not-allowed; box-sizing:border-box;">
                                                        Stok Habis
                                                    </button>
                                                @endif
                                            @else
                                                <a href="{{ route('login') }}"
                                                    style="display:block; text-align:center; width:100%; background:linear-gradient(90deg,#2563eb,#f97316); color:#fff; font-size:12px; font-weight:700; padding:9px; border-radius:10px; text-decoration:none; box-sizing:border-box;">
                                                    <i class="fas fa-sign-in-alt" style="margin-right:4px;"></i>Login & Beli
                                                </a>
                                            @endauth
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Pagination --}}
                            @if ($books->hasPages())
                                <div>
                                    <p style="text-align:center; font-size:12px; color:#6b7280; margin-bottom:8px;">
                                        Halaman {{ $bookCurrent }} dari {{ $bookLast }}
                                    </p>
                                    <div style="display:flex; justify-content:center;">
                                        <nav aria-label="Pagination"
                                            style="display:inline-flex; align-items:center; gap:6px; flex-wrap:wrap; background:#fff; border:1px solid #dbeafe; border-radius:14px; padding:6px; box-shadow:0 6px 20px rgba(37,99,235,0.12);">
                                            @if ($books->onFirstPage())
                                                <span
                                                    style="width:36px; height:36px; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#cbd5e1; background:#f8fafc; cursor:not-allowed;">
                                                    <i class="fas fa-chevron-left" style="font-size:12px;"></i>
                                                </span>
                                            @else
                                                <a href="{{ $books->appends($bookPageQuery)->previousPageUrl() }}"
                                                    data-pagination-link="true"
                                                    style="width:36px; height:36px; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#2563eb; text-decoration:none; background:#eff6ff;">
                                                    <i class="fas fa-chevron-left" style="font-size:12px;"></i>
                                                </a>
                                            @endif

                                            @foreach ($bookPages as $page)
                                                @if ($page === '...')
                                                    <span
                                                        style="min-width:28px; height:36px; display:flex; align-items:center; justify-content:center; color:#94a3b8; font-weight:700;">...</span>
                                                @elseif ($page == $bookCurrent)
                                                    <span
                                                        style="min-width:36px; height:36px; padding:0 10px; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#fff; font-weight:700; font-size:13px; background:linear-gradient(90deg,#2563eb,#1d4ed8);">
                                                        {{ $page }}
                                                    </span>
                                                @else
                                                    <a href="{{ $books->appends($bookPageQuery)->url($page) }}"
                                                        data-pagination-link="true"
                                                        style="min-width:36px; height:36px; padding:0 10px; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#334155; font-weight:600; font-size:13px; text-decoration:none; background:#f8fafc;">
                                                        {{ $page }}
                                                    </a>
                                                @endif
                                            @endforeach

                                            @if ($books->hasMorePages())
                                                <a href="{{ $books->appends($bookPageQuery)->nextPageUrl() }}"
                                                    data-pagination-link="true"
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
                            @endif
                        @else
                            <div
                                style="background:#fff; border-radius:16px; padding:80px 32px; text-align:center; box-shadow:0 2px 10px rgba(0,0,0,0.06);">
                                <i class="fas fa-search"
                                    style="font-size:48px; color:#d1d5db; display:block; margin-bottom:16px;"></i>
                                <h3 style="font-size:18px; font-weight:700; color:#374151; margin-bottom:6px;">Buku tidak
                                    ditemukan</h3>
                                <p style="color:#9ca3af; font-size:14px;">Coba kata kunci atau filter yang berbeda</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        {{-- ───────── MOBILE BOOK LIST ───────── --}}
        <div class="md:hidden bg-gray-50 px-3 pt-4 pb-2">
            @if (request('category') || request('search'))
                <div class="mb-3 flex items-center justify-between bg-blue-50 border border-blue-100 rounded-xl px-3 py-2">
                    <span class="text-xs font-semibold text-blue-700">
                        @if (request('search'))
                            "{{ request('search') }}"
                        @endif
                        @if (request('category') && isset($activeCategory))
                            · {{ $categories->firstWhere('id', request('category'))?->name }}
                        @endif
                    </span>
                    <a href="{{ route('books.index', ['sort' => request('sort')]) }}"
                        class="text-xs text-blue-500 font-semibold ml-2"><i class="fas fa-times"></i> Hapus</a>
                </div>
            @endif

            @if ($books->count() > 0)
                <p class="text-xs text-gray-500 mb-3">{{ $books->total() }} buku ditemukan</p>

                {{-- 2-column compact grid --}}
                <div class="grid grid-cols-2 gap-3">
                    @foreach ($books as $book)
                        <div class="bg-white rounded-2xl shadow-sm overflow-hidden active:scale-95 transition-transform duration-150"
                            style="animation-delay:{{ $loop->index * 30 }}ms">

                            {{-- Cover --}}
                            <a href="{{ route('books.show', $book->slug) }}" class="block relative">
                                @if ($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                        class="w-full object-cover" style="height:160px; object-position:center top;">
                                @else
                                    <div class="w-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-orange-50"
                                        style="height:160px;">
                                        <i class="fas fa-book text-blue-200 text-4xl"></i>
                                    </div>
                                @endif

                                {{-- Badge --}}
                                @if ($book->discount > 0)
                                    <span
                                        class="absolute top-2 left-2 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow">-{{ $book->discount }}%</span>
                                @elseif($loop->index < 3)
                                    <span
                                        class="absolute top-2 left-2 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow"
                                        style="background:#f59e0b">★ Best</span>
                                @endif

                                {{-- Wishlist --}}
                                @auth
                                    <button @click.prevent="toggleWishlist({{ $book->id }}, $event)"
                                        :class="wishlistBooks.includes({{ $book->id }}) ? 'text-red-500 bg-white' :
                                            'text-gray-500 bg-white/80'"
                                        class="absolute top-2 right-2 w-7 h-7 rounded-full flex items-center justify-center shadow text-xs">
                                        <i :class="wishlistBooks.includes({{ $book->id }}) ? 'fas' : 'far'"
                                            class="fa-heart"></i>
                                    </button>
                                @endauth
                            </a>

                            {{-- Info --}}
                            <div class="p-2.5">
                                <span
                                    class="text-[10px] font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">{{ $book->category->name }}</span>
                                <a href="{{ route('books.show', $book->slug) }}"
                                    class="block mt-1.5 mb-0.5 text-xs font-bold text-gray-800 leading-tight line-clamp-2">{{ $book->title }}</a>
                                <p class="text-[10px] text-gray-400 truncate mb-1.5">{{ $book->author }}</p>

                                {{-- Price --}}
                                <div class="mb-2">
                                    @if ($book->discount > 0)
                                        <p class="text-[10px] text-gray-400 line-through leading-none">Rp
                                            {{ number_format($book->price, 0, ',', '.') }}</p>
                                        <p class="text-sm font-black text-red-600 leading-tight">Rp
                                            {{ number_format($book->discounted_price, 0, ',', '.') }}</p>
                                    @else
                                        <p class="text-sm font-black text-blue-600 leading-tight">Rp
                                            {{ number_format($book->discounted_price, 0, ',', '.') }}</p>
                                    @endif
                                </div>

                                {{-- CTA --}}
                                @auth
                                    @if ($book->stock > 0)
                                        <button @click="addToCart({{ $book->id }})"
                                            class="w-full text-[11px] font-bold py-1.5 rounded-xl text-white transition-all active:scale-95"
                                            style="background:linear-gradient(90deg,#2563eb,#1d4ed8);">
                                            <i class="fas fa-cart-plus mr-1"></i>Keranjang
                                        </button>
                                    @else
                                        <button disabled
                                            class="w-full text-[11px] font-bold py-1.5 rounded-xl bg-gray-200 text-gray-400">Habis</button>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}"
                                        class="block w-full text-[11px] font-bold py-1.5 rounded-xl text-white text-center transition-all active:scale-95"
                                        style="background:linear-gradient(90deg,#2563eb,#f97316);">
                                        Login & Beli
                                    </a>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Mobile pagination --}}
                @if ($books->hasPages())
                    <div class="mt-6">
                        <p class="text-center text-xs text-gray-500 mb-2">Halaman {{ $bookCurrent }} dari
                            {{ $bookLast }}</p>
                        <div style="display:flex; justify-content:center;">
                            <nav aria-label="Pagination"
                                style="display:inline-flex; align-items:center; gap:6px; flex-wrap:wrap; background:#fff; border:1px solid #dbeafe; border-radius:14px; padding:6px; box-shadow:0 6px 20px rgba(37,99,235,0.12);">
                                @if ($books->onFirstPage())
                                    <span
                                        style="width:36px; height:36px; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#cbd5e1; background:#f8fafc; cursor:not-allowed;">
                                        <i class="fas fa-chevron-left" style="font-size:12px;"></i>
                                    </span>
                                @else
                                    <a href="{{ $books->appends($bookPageQuery)->previousPageUrl() }}"
                                        data-pagination-link="true"
                                        style="width:36px; height:36px; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#2563eb; text-decoration:none; background:#eff6ff;">
                                        <i class="fas fa-chevron-left" style="font-size:12px;"></i>
                                    </a>
                                @endif

                                @foreach ($bookPages as $page)
                                    @if ($page === '...')
                                        <span
                                            style="min-width:28px; height:36px; display:flex; align-items:center; justify-content:center; color:#94a3b8; font-weight:700;">...</span>
                                    @elseif ($page == $bookCurrent)
                                        <span
                                            style="min-width:36px; height:36px; padding:0 10px; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#fff; font-weight:700; font-size:13px; background:linear-gradient(90deg,#2563eb,#1d4ed8);">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $books->appends($bookPageQuery)->url($page) }}"
                                            data-pagination-link="true"
                                            style="min-width:36px; height:36px; padding:0 10px; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#334155; font-weight:600; font-size:13px; text-decoration:none; background:#f8fafc;">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                @if ($books->hasMorePages())
                                    <a href="{{ $books->appends($bookPageQuery)->nextPageUrl() }}"
                                        data-pagination-link="true"
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
                @endif
            @else
                <div class="text-center py-16">
                    <i class="fas fa-search text-gray-300 text-5xl mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-600 mb-1">Buku tidak ditemukan</h3>
                    <p class="text-sm text-gray-400">Coba kata kunci atau filter lain</p>
                </div>
            @endif
        </div>

        {{-- ───────── QUICK VIEW MODAL (shared) ───────── --}}
        <div x-show="showQuickView" x-cloak @click.self="showQuickView = false"
            class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div @click.stop
                class="bg-white rounded-t-3xl sm:rounded-2xl shadow-2xl max-w-4xl w-full max-h-[92vh] overflow-y-auto"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0">
                <template x-if="quickViewBook">
                    <div>
                        <div class="flex justify-between items-center p-5 border-b border-gray-200">
                            <h2 class="text-lg font-bold text-gray-900">Detail Buku</h2>
                            <button @click="showQuickView = false"
                                class="text-gray-400 hover:text-gray-600 w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="p-5">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <img :src="quickViewBook.image" :alt="quickViewBook.title"
                                        class="w-full rounded-xl shadow-lg">
                                    @auth
                                        <button @click="toggleWishlist(quickViewBook.id, $event)"
                                            :class="quickViewBook.in_wishlist ? 'bg-red-500 text-white' :
                                                'bg-gray-100 text-gray-700'"
                                            class="w-full mt-3 py-2.5 rounded-xl font-semibold transition-all text-sm">
                                            <i :class="quickViewBook.in_wishlist ? 'fas' : 'far'" class="fa-heart mr-2"></i>
                                            <span
                                                x-text="quickViewBook.in_wishlist ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist'"></span>
                                        </button>
                                        <a x-show="quickViewBook.has_pdf" :href="`/books/${quickViewBook.id}/pdf`"
                                            target="_blank"
                                            class="block w-full mt-2 py-2.5 rounded-xl font-semibold bg-gray-100 text-red-600 hover:bg-gray-200 text-center text-sm">
                                            <i class="fas fa-file-pdf mr-2"></i>Lihat PDF
                                        </a>
                                    @endauth
                                </div>
                                <div>
                                    <span class="text-sm text-blue-600 font-semibold bg-blue-50 px-3 py-1 rounded-full"
                                        x-text="quickViewBook.category"></span>
                                    <h3 class="text-2xl font-bold text-gray-900 mt-3 mb-2" x-text="quickViewBook.title">
                                    </h3>
                                    <p class="text-gray-600 mb-1 text-sm"><i class="fas fa-user mr-2"></i><span
                                            x-text="quickViewBook.author"></span></p>
                                    <p class="text-gray-600 mb-4 text-sm"><i class="fas fa-building mr-2"></i><span
                                            x-text="quickViewBook.publisher"></span></p>
                                    <div class="mb-4">
                                        <template x-if="quickViewBook.discount > 0">
                                            <div>
                                                <div
                                                    class="inline-flex items-center gap-1.5 bg-gradient-to-r from-red-500 to-orange-500 text-white text-xs font-black px-3 py-1 rounded-lg mb-2">
                                                    <i class="fas fa-bolt text-yellow-300"></i>
                                                    <span x-text="'DISKON ' + quickViewBook.discount + '% OFF'"></span>
                                                </div>
                                                <div class="flex items-end gap-2">
                                                    <div class="text-2xl font-black text-red-600">Rp <span
                                                            x-text="quickViewBook.price"></span></div>
                                                    <div class="flex flex-col pb-0.5">
                                                        <span class="text-sm text-gray-400 line-through"
                                                            x-text="'Rp ' + quickViewBook.original_price"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                        <template x-if="!quickViewBook.discount || quickViewBook.discount === 0">
                                            <div
                                                class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-orange-500 bg-clip-text text-transparent">
                                                Rp <span x-text="quickViewBook.price"></span>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="mb-4">
                                        <span class="text-sm font-medium text-gray-700">Stok: </span>
                                        <span class="text-sm font-bold"
                                            :class="quickViewBook.stock > 0 ? 'text-green-600' : 'text-red-600'"
                                            x-text="quickViewBook.stock > 0 ? quickViewBook.stock + ' tersedia' : 'Habis'"></span>
                                    </div>
                                    <div class="mb-5">
                                        <h4 class="font-semibold text-gray-900 mb-1 text-sm">Deskripsi:</h4>
                                        <p class="text-gray-600 text-sm leading-relaxed"
                                            x-text="quickViewBook.description">
                                        </p>
                                    </div>
                                    @auth
                                        <div class="space-y-2">
                                            <button @click="addToCart(quickViewBook.id)" x-show="quickViewBook.stock > 0"
                                                class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-xl transition-all text-sm">
                                                <i class="fas fa-shopping-cart mr-2"></i>Tambah ke Keranjang
                                            </button>
                                            <a :href="`/books/${quickViewBook.slug}`"
                                                class="block w-full bg-white border-2 border-blue-600 text-blue-600 hover:bg-blue-50 font-bold py-3 px-6 rounded-xl text-center transition-all text-sm">
                                                Lihat Detail Lengkap
                                            </a>
                                        </div>
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="block w-full bg-gradient-to-r from-blue-600 to-orange-500 text-white font-bold py-3 px-6 rounded-xl text-center transition-all text-sm">
                                            <i class="fas fa-sign-in-alt mr-2"></i>Login untuk Membeli
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out backwards;
        }

        .animate-slide-in-left {
            animation: slideInLeft 0.5s ease-out;
        }

        /* Hide scrollbar for category pills */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-pagination-link="true"]').forEach((link) => {
                link.addEventListener('click', (event) => {
                    event.preventDefault();
                    const anchor = document.getElementById('books-results-anchor');
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
        });

        function booksInteractive() {
            return {
                showQuickView: false,
                quickViewBook: null,
                wishlistBooks: @json(auth()->check() ? auth()->user()->wishlists()->pluck('book_id')->toArray() : []),

                async quickView(bookId) {
                    try {
                        const response = await fetch(`/books/${bookId}/quick-view`, {
                            headers: {
                                'Accept': 'application/json'
                            }
                        });
                        this.quickViewBook = await response.json();
                        this.showQuickView = true;
                    } catch (error) {
                        console.error('Error loading quick view:', error);
                        window.dispatchEvent(new CustomEvent('toast', {
                            detail: {
                                message: 'Gagal memuat detail buku',
                                type: 'error'
                            }
                        }));
                    }
                },

                async addToCart(bookId) {
                    try {
                        // Trigger flying animation
                        const bookCard = event.target.closest('.group, .relative');
                        const bookImage = bookCard?.querySelector('img') || bookCard?.querySelector(
                            '.aspect-\\[2\\/3\\]');
                        const bookTitle = bookCard?.querySelector('h3')?.textContent || 'Buku';

                        if (bookImage) {
                            window.flyToCart(bookImage, bookTitle);
                        }

                        const response = await fetch(`/cart/add/${bookId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                quantity: 1
                            })
                        });

                        const data = await response.json();
                        if (data.success) {
                            window.dispatchEvent(new CustomEvent('cart-updated'));
                            window.showToast('success', data.message || 'Produk berhasil ditambahkan ke keranjang');
                        }
                    } catch (error) {
                        console.error('Error adding to cart:', error);
                        window.showToast('error', 'Gagal menambahkan ke keranjang');
                    }
                },

                async toggleWishlist(bookId, event) {
                    event.stopPropagation();

                    console.log('💝 Toggling wishlist for book:', bookId);
                    console.log('Current wishlist:', this.wishlistBooks);

                    try {
                        const response = await fetch('/wishlist/toggle', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                book_id: bookId
                            })
                        });

                        if (!response.ok) {
                            const errorText = await response.text();
                            console.error('❌ Response not OK:', response.status, errorText);
                            throw new Error(`HTTP ${response.status}: ${errorText}`);
                        }

                        const data = await response.json();
                        console.log('✅ Wishlist response:', data);

                        if (data.success) {
                            if (data.action === 'added') {
                                this.wishlistBooks.push(bookId);
                                console.log('➕ Added to wishlist');
                            } else {
                                const index = this.wishlistBooks.indexOf(bookId);
                                if (index > -1) {
                                    this.wishlistBooks.splice(index, 1);
                                    console.log('➖ Removed from wishlist');
                                }
                            }

                            // Update quick view if open
                            if (this.quickViewBook && this.quickViewBook.id === bookId) {
                                this.quickViewBook.in_wishlist = data.action === 'added';
                            }

                            // Flying heart animation
                            if (data.action === 'added' && typeof window.flyToWishlist === 'function') {
                                const bookCard = event.target.closest('.group, .relative');
                                const bookTitle = bookCard?.querySelector('h3')?.textContent || 'Buku';
                                window.flyToWishlist(event.target, bookTitle);
                            } else {
                                window.showToast('success', data.message);
                            }
                        } else {
                            console.error('❌ Success false:', data);
                            throw new Error(data.message || 'Unknown error');
                        }
                    } catch (error) {
                        console.error('❌ Error toggling wishlist:', error);
                        window.showToast('error', error.message || 'Gagal memperbarui wishlist');
                    }
                }
            };
        }
    </script>
@endsection
