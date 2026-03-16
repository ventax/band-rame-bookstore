@extends('layouts.app')

@section('title', 'Keranjang Belanja - ATigaBookStore')
@section('mobile_main_padding', 'pb-0')

@section('content')
    <style>
        .cart-check-control {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            user-select: none;
        }

        .cart-check-dot {
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

        .cart-check-dot.square {
            border-radius: 6px;
        }

        .cart-check-control input:checked+.cart-check-dot {
            border-color: #2563eb;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.16);
            transform: translateY(-1px);
        }

        .cart-check-control input:focus-visible+.cart-check-dot {
            outline: 2px solid rgba(37, 99, 235, 0.32);
            outline-offset: 2px;
        }

        .cart-check-control input:not(:checked)+.cart-check-dot i {
            opacity: 0;
            transform: scale(0.8);
        }

        .cart-check-control input:checked+.cart-check-dot i {
            opacity: 1;
            transform: scale(1);
            transition: all 0.18s ease;
        }
    </style>

    <div id="cart-page-content" style="background:#f3f4f6; min-height:100vh; transition:filter 0.2s ease;">

        {{-- ===== MOBILE STICKY HEADER ===== --}}
        <div class="md:hidden"
            style="position:sticky; top:56px; z-index:50; background:#ffffff; border-bottom:1px solid #e5e7eb; padding:10px 16px 8px;">
            <div style="display:flex; align-items:center; justify-content:space-between;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <div
                        style="width:32px; height:32px; background:linear-gradient(135deg,#2563eb,#1d4ed8); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-shopping-cart" style="color:#fff; font-size:14px;"></i>
                    </div>
                    <div>
                        <div style="font-weight:700; font-size:15px; color:#111827; line-height:1.2;">Keranjang Belanja</div>
                        <div style="font-size:11px; color:#6b7280;">{{ $cartItems->sum('quantity') }} item</div>
                    </div>
                </div>
                <a href="{{ route('books.index') }}"
                    style="display:flex; align-items:center; gap:4px; font-size:12px; font-weight:600; color:#2563eb; text-decoration:none; background:#eff6ff; padding:6px 12px; border-radius:20px;">
                    <i class="fas fa-plus" style="font-size:10px;"></i> Belanja Lagi
                </a>
            </div>
        </div>

        {{-- ===== DESKTOP HEADER ===== --}}
        <div class="hidden md:block" style="padding:32px 32px 0;">
            <div class="max-w-7xl mx-auto">
                <h1
                    style="font-size:28px; font-weight:800; color:#111827; margin-bottom:6px; display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-shopping-cart" style="color:#2563eb;"></i> Keranjang Belanja
                </h1>
                <p style="color:#6b7280; font-size:15px;">{{ $cartItems->sum('quantity') }} item dalam keranjang</p>
            </div>
        </div>

        @if ($cartItems->count() > 0)

            {{-- ===== MOBILE LAYOUT ===== --}}
            <div class="md:hidden" style="padding:12px 12px 0;">
                <div style="display:flex; flex-direction:column; gap:10px;">
                    <label
                        style="display:flex; align-items:center; justify-content:space-between; background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:10px 12px;">
                        <span class="cart-check-control">
                            <input type="checkbox" class="cart-select-all sr-only" checked>
                            <span class="cart-check-dot square"><i class="fas fa-check"></i></span>
                            <span style="font-size:12px; font-weight:700; color:#374151;">Pilih semua item</span>
                        </span>
                        <span
                            style="font-size:10px; font-weight:700; color:#2563eb; background:#eff6ff; border:1px solid #bfdbfe; border-radius:9999px; padding:3px 8px;">
                            Checkout fleksibel
                        </span>
                    </label>
                    @foreach ($cartItems as $item)
                        <div style="background:#fff; border-radius:16px; box-shadow:0 1px 8px rgba(0,0,0,0.07); overflow:hidden; display:flex; gap:0;"
                            id="cart-item-{{ $item->id }}" data-stock="{{ $item->book->stock }}"
                            data-price="{{ $item->book->discounted_price }}">

                            <label class="cart-check-control" style="padding:10px 6px 10px 10px; align-items:flex-start;">
                                <input type="checkbox" class="cart-item-checkbox sr-only" data-item-id="{{ $item->id }}"
                                    checked>
                                <span class="cart-check-dot" style="margin-top:2px;"><i class="fas fa-check"></i></span>
                            </label>

                            {{-- Cover --}}
                            <a href="{{ route('books.show', $item->book->slug) }}"
                                style="flex-shrink:0; display:block; position:relative;">
                                @if ($item->book->cover_image)
                                    <img src="{{ asset('storage/' . $item->book->cover_image) }}"
                                        alt="{{ $item->book->title }}"
                                        style="width:80px; height:110px; object-fit:cover; object-position:center top; display:block;">
                                @else
                                    <div
                                        style="width:80px; height:110px; background:linear-gradient(135deg,#dbeafe,#eff6ff); display:flex; align-items:center; justify-content:center;">
                                        <i class="fas fa-book" style="color:#93c5fd; font-size:24px;"></i>
                                    </div>
                                @endif
                                @if ($item->book->discount > 0)
                                    <div
                                        style="position:absolute; top:5px; left:5px; background:linear-gradient(135deg,#ef4444,#f97316); color:#fff; font-size:9px; font-weight:800; padding:2px 5px; border-radius:6px;">
                                        -{{ $item->book->discount }}%
                                    </div>
                                @endif
                            </a>

                            {{-- Info --}}
                            <div
                                style="flex:1; padding:10px 12px 10px 10px; display:flex; flex-direction:column; justify-content:space-between; min-width:0;">
                                <div>
                                    <div
                                        style="font-size:13px; font-weight:700; color:#111827; line-height:1.35; overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; margin-bottom:2px;">
                                        {{ $item->book->title }}
                                    </div>
                                    <div
                                        style="font-size:11px; color:#9ca3af; margin-bottom:6px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                        {{ $item->book->author }}
                                    </div>
                                    {{-- Price --}}
                                    @if ($item->book->discount > 0)
                                        <div style="display:flex; align-items:center; gap:6px; margin-bottom:1px;">
                                            <span style="font-size:14px; font-weight:800; color:#dc2626;">Rp
                                                {{ number_format($item->book->discounted_price, 0, ',', '.') }}</span>
                                            <span style="font-size:10px; color:#9ca3af; text-decoration:line-through;">Rp
                                                {{ number_format($item->book->price, 0, ',', '.') }}</span>
                                        </div>
                                    @else
                                        <div style="font-size:14px; font-weight:800; color:#2563eb; margin-bottom:4px;">
                                            Rp {{ number_format($item->book->discounted_price, 0, ',', '.') }}
                                        </div>
                                    @endif
                                </div>

                                {{-- Bottom row: qty + subtotal + delete --}}
                                <div
                                    style="display:flex; align-items:center; justify-content:space-between; margin-top:6px;">
                                    {{-- Qty stepper --}}
                                    <div style="display:flex; flex-direction:column; gap:2px;">
                                        <div
                                            style="display:flex; align-items:center; border:1.5px solid #e5e7eb; border-radius:10px; overflow:hidden;">
                                            <button type="button" id="btn-minus-{{ $item->id }}"
                                                onclick="updateQuantity({{ $item->id }}, -1)"
                                                style="width:28px; height:28px; background:none; border:none; cursor:pointer; color:#4b5563; display:flex; align-items:center; justify-content:center; font-size:12px;"
                                                {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                <i class="fas fa-minus" style="font-size:10px;"></i>
                                            </button>
                                            <span id="qty-{{ $item->id }}"
                                                style="min-width:28px; height:28px; border-left:1.5px solid #e5e7eb; border-right:1.5px solid #e5e7eb; font-weight:700; font-size:13px; display:flex; align-items:center; justify-content:center; color:#111827;">{{ $item->quantity }}</span>
                                            <button type="button" id="btn-plus-{{ $item->id }}"
                                                onclick="updateQuantity({{ $item->id }}, 1)"
                                                style="width:28px; height:28px; background:none; border:none; cursor:pointer; color:#4b5563; display:flex; align-items:center; justify-content:center;"
                                                {{ $item->quantity >= $item->book->stock ? 'disabled' : '' }}>
                                                <i class="fas fa-plus" style="font-size:10px;"></i>
                                            </button>
                                        </div>
                                        <p id="stock-info-{{ $item->id }}"
                                            style="font-size:9px; color:#f97316; {{ $item->quantity < $item->book->stock ? 'display:none;' : '' }}">
                                            <i class="fas fa-info-circle"></i> Maks {{ $item->book->stock }}
                                        </p>
                                    </div>

                                    {{-- Subtotal + Delete --}}
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <span id="subtotal-{{ $item->id }}"
                                            style="font-weight:800; font-size:13px; color:#111827;">
                                            Rp
                                            {{ number_format($item->quantity * $item->book->discounted_price, 0, ',', '.') }}
                                        </span>
                                        <button type="button"
                                            onclick="openDeleteModal({{ $item->id }}, '{{ addslashes($item->book->title) }}')"
                                            style="width:28px; height:28px; background:#fff0f0; border:none; border-radius:8px; cursor:pointer; color:#ef4444; display:flex; align-items:center; justify-content:center;">
                                            <i class="fas fa-trash-alt" style="font-size:12px;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Spacer for mobile bottom checkout bar --}}
                <div style="height:176px;"></div>
            </div>

            {{-- ===== MOBILE STICKY BOTTOM CHECKOUT BAR ===== --}}
            <div class="md:hidden"
                style="position:fixed; left:0; right:0; bottom:64px; z-index:49; background:rgba(255,255,255,0.97); backdrop-filter:blur(12px); border-top:1px solid #e5e7eb; padding:10px 16px 12px; box-shadow:0 -4px 20px rgba(0,0,0,0.1);">
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
                    <div>
                        <div style="font-size:11px; color:#6b7280; margin-bottom:1px;">Total
                            (<span id="mobile-selected-count">{{ $cartItems->sum('quantity') }}</span> item)</div>
                        <div style="font-size:16px; font-weight:900; color:#2563eb;" id="mobile-cart-total">Rp
                            {{ number_format($total, 0, ',', '.') }}</div>
                    </div>
                    <div style="font-size:11px; color:#9ca3af; text-align:right;">
                        Ongkir dihitung<br>saat checkout
                    </div>
                </div>
                <button type="button" id="checkout-btn-mobile" onclick="proceedToCheckout()"
                    style="display:block; width:100%; text-align:center; background:linear-gradient(90deg,#2563eb,#1d4ed8); color:#fff; font-weight:700; font-size:14px; padding:13px; border-radius:14px; text-decoration:none; box-sizing:border-box;">
                    Lanjut ke Checkout &nbsp;<i class="fas fa-arrow-right"></i>
                </button>
            </div>

            {{-- ===== DESKTOP LAYOUT ===== --}}
            <div class="hidden md:block" style="padding:24px 32px 48px;">
                <div class="max-w-7xl mx-auto">
                    <div class="grid md:grid-cols-3 gap-8">
                        {{-- Items --}}
                        <div class="md:col-span-2 space-y-4">
                            <label
                                style="display:inline-flex; align-items:center; gap:10px; padding:8px 12px; border:1px solid #e5e7eb; border-radius:9999px; background:#fff;">
                                <span class="cart-check-control">
                                    <input type="checkbox" class="cart-select-all sr-only" checked>
                                    <span class="cart-check-dot square"><i class="fas fa-check"></i></span>
                                    <span class="text-sm font-semibold text-gray-700">Pilih semua item</span>
                                </span>
                            </label>
                            @foreach ($cartItems as $item)
                                <div class="bg-white rounded-xl shadow p-6 flex gap-4"
                                    id="cart-item-{{ $item->id }}-d" data-stock="{{ $item->book->stock }}"
                                    data-price="{{ $item->book->discounted_price }}">

                                    <label class="cart-check-control pt-1">
                                        <input type="checkbox" class="cart-item-checkbox sr-only"
                                            data-item-id="{{ $item->id }}" checked>
                                        <span class="cart-check-dot"><i class="fas fa-check"></i></span>
                                    </label>

                                    <div class="w-24 h-32 flex-shrink-0">
                                        @if ($item->book->cover_image)
                                            <img src="{{ asset('storage/' . $item->book->cover_image) }}"
                                                alt="{{ $item->book->title }}"
                                                class="w-full h-full object-cover rounded-lg">
                                        @else
                                            <div
                                                class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center rounded-lg">
                                                <i class="fas fa-book text-blue-300 text-3xl"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex-1">
                                        <h3 class="font-bold text-lg text-gray-900 mb-1">{{ $item->book->title }}</h3>
                                        <p class="text-gray-500 text-sm mb-2">{{ $item->book->author }}</p>
                                        @if ($item->book->discount > 0)
                                            <div class="flex items-center gap-2 mb-1">
                                                <span
                                                    class="inline-flex items-center gap-1 bg-gradient-to-r from-red-500 to-orange-500 text-white text-xs font-black px-2 py-0.5 rounded-lg shadow-sm">
                                                    <i class="fas fa-bolt text-yellow-200" style="font-size:9px"></i>
                                                    -{{ $item->book->discount }}%
                                                </span>
                                                <span class="text-xs text-gray-400 line-through">Rp
                                                    {{ number_format($item->book->price, 0, ',', '.') }}</span>
                                            </div>
                                            <p class="text-red-600 font-black text-lg mb-1">Rp
                                                {{ number_format($item->book->discounted_price, 0, ',', '.') }}</p>
                                            <span
                                                class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full mb-3">
                                                <i class="fas fa-piggy-bank text-xs"></i> Hemat Rp
                                                {{ number_format($item->book->price - $item->book->discounted_price, 0, ',', '.') }}
                                            </span>
                                        @else
                                            <p class="text-blue-600 font-bold text-lg mb-4">Rp
                                                {{ number_format($item->book->discounted_price, 0, ',', '.') }}</p>
                                        @endif

                                        <div class="flex items-center justify-between">
                                            <div class="flex flex-col gap-1">
                                                <div
                                                    class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                                    <button type="button" id="btn-minus-{{ $item->id }}-d"
                                                        onclick="updateQuantity({{ $item->id }}, -1)"
                                                        class="px-3 py-1.5 text-gray-600 hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed transition-colors"
                                                        {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                        <i class="fas fa-minus text-xs"></i>
                                                    </button>
                                                    <span id="qty-{{ $item->id }}-d"
                                                        class="px-4 py-1.5 border-x border-gray-300 font-semibold min-w-[2.5rem] text-center">{{ $item->quantity }}</span>
                                                    <button type="button" id="btn-plus-{{ $item->id }}-d"
                                                        onclick="updateQuantity({{ $item->id }}, 1)"
                                                        class="px-3 py-1.5 text-gray-600 hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed transition-colors"
                                                        {{ $item->quantity >= $item->book->stock ? 'disabled' : '' }}>
                                                        <i class="fas fa-plus text-xs"></i>
                                                    </button>
                                                </div>
                                                <p id="stock-info-{{ $item->id }}-d"
                                                    class="text-xs text-orange-500 {{ $item->quantity < $item->book->stock ? 'hidden' : '' }}">
                                                    <i class="fas fa-info-circle"></i> Stok tersisa:
                                                    {{ $item->book->stock }}
                                                </p>
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <span id="subtotal-{{ $item->id }}-d"
                                                    class="font-bold text-lg text-gray-900">
                                                    Rp
                                                    {{ number_format($item->quantity * $item->book->discounted_price, 0, ',', '.') }}
                                                </span>
                                                <button type="button"
                                                    onclick="openDeleteModal({{ $item->id }}, '{{ addslashes($item->book->title) }}')"
                                                    class="text-red-400 hover:text-red-600 transition-colors p-2 rounded-lg hover:bg-red-50">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Order Summary --}}
                        <div class="md:col-span-1">
                            <div class="bg-white rounded-xl shadow p-6 sticky top-24">
                                <h2 class="text-xl font-bold text-gray-900 mb-5">Ringkasan Pesanan</h2>
                                <div class="space-y-3 mb-6">
                                    <div class="flex justify-between text-gray-600 text-sm">
                                        <span>Subtotal (<span
                                                id="selected-item-count">{{ $cartItems->sum('quantity') }}</span>
                                            item)</span>
                                        <span id="cart-total" class="font-semibold">Rp
                                            {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-gray-600 text-sm">
                                        <span>Ongkir</span>
                                        <span class="text-gray-400 text-xs">Dihitung saat checkout</span>
                                    </div>
                                    <div class="border-t pt-3 flex justify-between font-bold text-lg">
                                        <span>Total</span>
                                        <span class="text-blue-600" id="cart-total-final">Rp
                                            {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <button type="button" id="checkout-btn-desktop" onclick="proceedToCheckout()"
                                    style="display:block; width:100%; text-align:center; background:linear-gradient(90deg,#2563eb,#1d4ed8); color:#fff; font-weight:700; font-size:15px; padding:14px; border-radius:12px; text-decoration:none; box-sizing:border-box; margin-bottom:10px;">
                                    Lanjut ke Checkout <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                                <p id="selection-warning" class="text-xs text-red-500 mb-2 hidden">Pilih minimal satu item
                                    untuk checkout.</p>
                                <a href="{{ route('books.index') }}"
                                    class="block w-full text-center text-gray-600 hover:text-blue-600 text-sm transition-colors">
                                    <i class="fas fa-arrow-left mr-2"></i> Lanjut Belanja
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- ===== MOBILE EMPTY STATE ===== --}}
            <div class="md:hidden" style="padding:56px 24px; text-align:center;">
                <div
                    style="width:80px; height:80px; background:linear-gradient(135deg,#dbeafe,#eff6ff); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                    <i class="fas fa-shopping-cart" style="font-size:36px; color:#d1d5db;"></i>
                </div>
                <div style="font-size:16px; font-weight:700; color:#374151; margin-bottom:8px;">Keranjang Masih Kosong
                </div>
                <div style="font-size:13px; color:#6b7280; margin-bottom:24px;">Belum ada buku dalam keranjang belanja Anda
                </div>
                <a href="{{ route('books.index') }}"
                    style="display:inline-flex; align-items:center; gap:8px; background:linear-gradient(90deg,#2563eb,#1d4ed8); color:#fff; font-size:14px; font-weight:700; padding:12px 28px; border-radius:20px; text-decoration:none;">
                    <i class="fas fa-book"></i> Mulai Belanja
                </a>
            </div>

            {{-- ===== DESKTOP EMPTY STATE ===== --}}
            <div class="hidden md:block" style="padding:32px;">
                <div class="max-w-7xl mx-auto">
                    <div class="bg-white rounded-xl shadow p-16 text-center">
                        <i class="fas fa-shopping-cart text-gray-300 text-6xl mb-4"></i>
                        <h2 class="text-2xl font-semibold text-gray-600 mb-2">Keranjang Belanja Kosong</h2>
                        <p class="text-gray-500 mb-6">Belum ada buku dalam keranjang belanja Anda</p>
                        <a href="{{ route('books.index') }}"
                            style="display:inline-flex; align-items:center; gap:8px; background:linear-gradient(90deg,#2563eb,#1d4ed8); color:#fff; font-size:15px; font-weight:700; padding:12px 32px; border-radius:12px; text-decoration:none;">
                            <i class="fas fa-book"></i> Mulai Belanja
                        </a>
                    </div>
                </div>
            </div>

        @endif
    </div>

    <!-- Delete Confirmation Modal (must be AFTER page content so it paints on top of the blurred layer) -->
    <div x-data="deleteModal()" x-show="open" x-cloak @click.self="open = false" @keydown.escape.window="open = false"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/60">

        <!-- Modal box -->
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xs p-6"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" @click.stop>

            <!-- Icon -->
            <div class="flex justify-center mb-3">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-trash-alt text-red-500 text-lg"></i>
                </div>
            </div>

            <!-- Text -->
            <h3 class="text-base font-bold text-gray-900 text-center mb-1">Hapus dari Keranjang?</h3>
            <p class="text-xs text-gray-500 text-center mb-1">Buku ini akan dihapus dari keranjang belanja Anda.</p>
            <p class="text-xs font-semibold text-gray-700 text-center mb-5 leading-snug" x-text="bookTitle"></p>

            <!-- Buttons -->
            <div class="flex gap-2">
                <button type="button" @click="open = false"
                    class="flex-1 py-2 rounded-xl border border-gray-300 text-sm text-gray-700 font-semibold hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="button" @click="confirm()" :disabled="loading"
                    class="flex-1 py-2 rounded-xl bg-gradient-to-r from-red-500 to-rose-600 text-sm text-white font-semibold hover:from-red-600 hover:to-rose-700 transition-all disabled:opacity-60">
                    <span x-show="!loading"><i class="fas fa-trash-alt mr-1"></i> Ya, Hapus</span>
                    <span x-show="loading"><i class="fas fa-spinner fa-spin mr-1"></i> Menghapus...</span>
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const checkoutAddressUrl = @json(route('checkout.address'));

            function formatCurrency(value) {
                return 'Rp ' + value.toLocaleString('id-ID');
            }

            function getItemQuantity(itemId) {
                const qtyEl = document.getElementById(`qty-${itemId}`) || document.getElementById(`qty-${itemId}-d`);
                return qtyEl ? parseInt(qtyEl.textContent, 10) || 0 : 0;
            }

            function getItemPrice(itemId) {
                const itemEl = document.getElementById(`cart-item-${itemId}`) || document.getElementById(
                    `cart-item-${itemId}-d`);
                return itemEl ? parseFloat(itemEl.dataset.price) || 0 : 0;
            }

            function getUniqueItemSelections() {
                const selectionMap = new Map();

                document.querySelectorAll('.cart-item-checkbox').forEach((checkbox) => {
                    const itemId = String(checkbox.dataset.itemId || '').trim();
                    if (!itemId) return;

                    if (!selectionMap.has(itemId)) {
                        selectionMap.set(itemId, false);
                    }

                    if (checkbox.checked) {
                        selectionMap.set(itemId, true);
                    }
                });

                return selectionMap;
            }

            function syncItemCheckboxes(itemId, checked) {
                document.querySelectorAll(`.cart-item-checkbox[data-item-id="${itemId}"]`).forEach((checkbox) => {
                    checkbox.checked = checked;
                });
            }

            function updateSelectAllState() {
                const selectionMap = getUniqueItemSelections();
                const totalItems = selectionMap.size;
                const selectedItems = Array.from(selectionMap.values()).filter(Boolean).length;
                const allChecked = totalItems > 0 && selectedItems === totalItems;

                document.querySelectorAll('.cart-select-all').forEach((checkbox) => {
                    checkbox.checked = allChecked;
                });
            }

            function recalculateSelectedTotals() {
                const selectionMap = getUniqueItemSelections();
                let selectedQuantity = 0;
                let selectedTotal = 0;

                selectionMap.forEach((isChecked, itemId) => {
                    if (!isChecked) return;
                    const qty = getItemQuantity(itemId);
                    const price = getItemPrice(itemId);
                    selectedQuantity += qty;
                    selectedTotal += (qty * price);
                });

                const formattedTotal = formatCurrency(selectedTotal);
                ['cart-total', 'cart-total-final', 'mobile-cart-total'].forEach((id) => {
                    const el = document.getElementById(id);
                    if (el) el.textContent = formattedTotal;
                });

                ['selected-item-count', 'mobile-selected-count'].forEach((id) => {
                    const el = document.getElementById(id);
                    if (el) el.textContent = selectedQuantity;
                });

                const hasSelection = selectedQuantity > 0;
                ['checkout-btn-mobile', 'checkout-btn-desktop'].forEach((id) => {
                    const button = document.getElementById(id);
                    if (!button) return;
                    button.disabled = !hasSelection;
                    button.style.opacity = hasSelection ? '1' : '0.55';
                    button.style.cursor = hasSelection ? 'pointer' : 'not-allowed';
                });

                const warning = document.getElementById('selection-warning');
                if (warning) {
                    warning.classList.toggle('hidden', hasSelection);
                }

                updateSelectAllState();
            }

            function proceedToCheckout() {
                const selectedItemIds = [];
                getUniqueItemSelections().forEach((isChecked, itemId) => {
                    if (isChecked) {
                        selectedItemIds.push(itemId);
                    }
                });

                if (selectedItemIds.length === 0) {
                    recalculateSelectedTotals();
                    return;
                }

                const params = new URLSearchParams();
                selectedItemIds.forEach((itemId) => params.append('selected_items[]', itemId));
                window.location.href = `${checkoutAddressUrl}?${params.toString()}`;
            }

            function deleteModal() {
                return {
                    open: false,
                    loading: false,
                    itemId: null,
                    bookTitle: '',
                    init() {
                        window.addEventListener('open-delete-modal', (e) => {
                            this.itemId = e.detail.itemId;
                            this.bookTitle = e.detail.title;
                            this.loading = false;
                            this.open = true;
                        });
                        this.$watch('open', val => {
                            const content = document.getElementById('cart-page-content');
                            if (content) content.style.filter = val ? 'blur(4px)' : '';
                        });
                    },
                    confirm() {
                        this.loading = true;
                        removeItem(this.itemId, () => {
                            this.open = false;
                            this.loading = false;
                        });
                    }
                };
            }

            function updateQuantity(itemId, delta) {
                const qtyEl = document.getElementById(`qty-${itemId}`) || document.getElementById(`qty-${itemId}-d`);
                const itemEl = document.getElementById(`cart-item-${itemId}`) || document.getElementById(
                    `cart-item-${itemId}-d`);
                if (!qtyEl || !itemEl) return;
                const stock = parseInt(itemEl.dataset.stock);
                const price = parseFloat(itemEl.dataset.price);
                const current = parseInt(qtyEl.textContent);
                const newQty = current + delta;

                if (newQty < 1 || newQty > stock) return;

                fetch(`/cart/${itemId}`, {
                        method: 'PATCH',
                        credentials: 'same-origin',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            quantity: newQty
                        })
                    })
                    .then(response => {
                        if (response.status === 401 || response.status === 419) {
                            window.location.href = '/login';
                            return null;
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (!data || !data.success) return;

                        // Update quantity display (mobile + desktop)
                        document.querySelectorAll(`#qty-${itemId}, #qty-${itemId}-d`).forEach(el => el.textContent =
                            newQty);

                        // Update minus button (mobile + desktop)
                        document.querySelectorAll(`#btn-minus-${itemId}, #btn-minus-${itemId}-d`).forEach(btn => btn
                            .disabled = newQty <= 1);

                        // Update plus button & stock info (mobile + desktop)
                        document.querySelectorAll(`#btn-plus-${itemId}, #btn-plus-${itemId}-d`).forEach(btn => btn
                            .disabled = newQty >= stock);
                        const stockInfoMobile = document.getElementById(`stock-info-${itemId}`);
                        if (stockInfoMobile) stockInfoMobile.style.display = newQty < stock ? 'none' : '';
                        const stockInfoDesktop = document.getElementById(`stock-info-${itemId}-d`);
                        if (stockInfoDesktop) stockInfoDesktop.classList.toggle('hidden', newQty < stock);

                        // Update subtotal for this item
                        const subtotal = data.subtotal ?? (newQty * price);
                        const subtotalFormatted = 'Rp ' + subtotal.toLocaleString('id-ID');
                        const subtotalMobile = document.getElementById(`subtotal-${itemId}`);
                        if (subtotalMobile) subtotalMobile.textContent = subtotalFormatted;
                        const subtotalDesktop = document.getElementById(`subtotal-${itemId}-d`);
                        if (subtotalDesktop) subtotalDesktop.textContent = subtotalFormatted;

                        recalculateSelectedTotals();

                        // Update cart badge in navbar
                        window.dispatchEvent(new CustomEvent('cart-updated'));
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    });
            }

            function removeItem(itemId, onSuccess) {
                fetch(`/cart/${itemId}`, {
                        method: 'DELETE',
                        credentials: 'same-origin',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.status === 401 || response.status === 419) {
                            window.location.href = '/login';
                            return null;
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (!data || !data.success) return;
                        if (onSuccess) onSuccess();
                        const itemElMobile = document.getElementById(`cart-item-${itemId}`);
                        if (itemElMobile) itemElMobile.remove();
                        const itemElDesktop = document.getElementById(`cart-item-${itemId}-d`);
                        if (itemElDesktop) itemElDesktop.remove();

                        recalculateSelectedTotals();

                        window.dispatchEvent(new CustomEvent('cart-updated'));

                        // If no items left, reload to show empty state
                        if (!document.querySelector('[id^="cart-item-"]')) location.reload();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    });
            }

            function openDeleteModal(itemId, title) {
                window.dispatchEvent(new CustomEvent('open-delete-modal', {
                    detail: {
                        itemId,
                        title
                    }
                }));
            }

            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('.cart-item-checkbox').forEach((checkbox) => {
                    checkbox.addEventListener('change', (event) => {
                        const itemId = event.target.dataset.itemId;
                        syncItemCheckboxes(itemId, event.target.checked);
                        recalculateSelectedTotals();
                    });
                });

                document.querySelectorAll('.cart-select-all').forEach((checkbox) => {
                    checkbox.addEventListener('change', (event) => {
                        const checked = event.target.checked;
                        document.querySelectorAll('.cart-item-checkbox').forEach((itemCheckbox) => {
                            itemCheckbox.checked = checked;
                        });
                        recalculateSelectedTotals();
                    });
                });

                recalculateSelectedTotals();
            });
        </script>
    @endpush
@endsection
