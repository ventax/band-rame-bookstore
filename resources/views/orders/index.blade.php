@extends('layouts.app')

@section('title', 'Pesanan Saya - ATigaBookStore')

@section('content')
    <div style="background:#f3f4f6; min-height:100vh;">

        @php
            function orderStatusStyle($status)
            {
                return match ($status) {
                    'pending' => 'background:#fef9c3; color:#854d0e; border:1px solid #fde047;',
                    'processing' => 'background:#dbeafe; color:#1e40af; border:1px solid #93c5fd;',
                    'shipped' => 'background:#ede9fe; color:#5b21b6; border:1px solid #c4b5fd;',
                    'delivered' => 'background:#dcfce7; color:#166534; border:1px solid #86efac;',
                    default => 'background:#fee2e2; color:#991b1b; border:1px solid #fca5a5;',
                };
            }
            function orderStatusLabel($status)
            {
                return match ($status) {
                    'pending' => 'Menunggu',
                    'processing' => 'Diproses',
                    'shipped' => 'Dikirim',
                    'delivered' => 'Selesai',
                    default => ucfirst($status),
                };
            }
            function orderStatusIcon($status)
            {
                return match ($status) {
                    'pending' => 'fas fa-clock',
                    'processing' => 'fas fa-cog',
                    'shipped' => 'fas fa-shipping-fast',
                    'delivered' => 'fas fa-check-circle',
                    default => 'fas fa-times-circle',
                };
            }
        @endphp

        {{-- ===== MOBILE STICKY HEADER ===== --}}
        <div class="md:hidden"
            style="position:sticky; top:56px; z-index:50; background:#ffffff; border-bottom:1px solid #e5e7eb; padding:10px 16px 8px;">
            <div style="display:flex; align-items:center; justify-content:space-between;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <div
                        style="width:32px; height:32px; background:linear-gradient(135deg,#7c3aed,#ec4899); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-box" style="color:#fff; font-size:14px;"></i>
                    </div>
                    <div>
                        <div style="font-weight:700; font-size:15px; color:#111827; line-height:1.2;">Pesanan Saya</div>
                        <div style="font-size:11px; color:#6b7280;">{{ $orders->total() }} pesanan</div>
                    </div>
                </div>
                <a href="{{ route('books.index') }}"
                    style="display:flex; align-items:center; gap:4px; font-size:12px; font-weight:600; color:#7c3aed; text-decoration:none; background:#f3f0ff; padding:6px 12px; border-radius:20px;">
                    <i class="fas fa-plus" style="font-size:10px;"></i> Belanja
                </a>
            </div>
        </div>

        @if ($orders->count() > 0)

            {{-- ===== MOBILE: stacked cards ===== --}}
            <div class="md:hidden" style="padding:12px 12px 100px;">
                <div style="display:flex; flex-direction:column; gap:10px;">
                    @foreach ($orders as $order)
                        <div
                            style="background:#fff; border-radius:16px; box-shadow:0 1px 8px rgba(0,0,0,0.07); overflow:hidden;">
                            {{-- Top bar --}}
                            <div
                                style="display:flex; align-items:center; justify-content:space-between; padding:10px 12px 8px; border-bottom:1px solid #f3f4f6;">
                                <div>
                                    <div style="font-size:12px; font-weight:700; color:#111827;">#{{ $order->order_number }}
                                    </div>
                                    <div style="font-size:10px; color:#9ca3af;">
                                        {{ $order->created_at->format('d M Y, H:i') }}</div>
                                </div>
                                <span
                                    style="font-size:10px; font-weight:700; padding:3px 10px; border-radius:20px; {{ orderStatusStyle($order->status) }}">
                                    <i class="{{ orderStatusIcon($order->status) }}"
                                        style="margin-right:3px;"></i>{{ orderStatusLabel($order->status) }}
                                </span>
                            </div>
                            {{-- Book thumbnails --}}
                            <div
                                style="display:flex; align-items:center; gap:6px; padding:8px 12px; border-bottom:1px solid #f3f4f6; overflow-x:auto;">
                                @foreach ($order->items->take(4) as $item)
                                    <div style="flex-shrink:0; position:relative;">
                                        @if ($item->book->cover_image)
                                            <img src="{{ asset('storage/' . $item->book->cover_image) }}"
                                                alt="{{ $item->book->title }}"
                                                style="width:36px; height:48px; object-fit:cover; border-radius:6px; border:1px solid #e5e7eb;">
                                        @else
                                            <div
                                                style="width:36px; height:48px; background:#f3f0ff; border-radius:6px; display:flex; align-items:center; justify-content:center;">
                                                <i class="fas fa-book" style="font-size:12px; color:#c4b5fd;"></i>
                                            </div>
                                        @endif
                                        @if ($item->quantity > 1)
                                            <div
                                                style="position:absolute; top:-4px; right:-4px; background:#7c3aed; color:#fff; font-size:8px; font-weight:700; border-radius:999px; min-width:14px; height:14px; display:flex; align-items:center; justify-content:center; padding:0 2px;">
                                                {{ $item->quantity }}</div>
                                        @endif
                                    </div>
                                @endforeach
                                @if ($order->items->count() > 4)
                                    <div
                                        style="flex-shrink:0; width:36px; height:48px; background:#f9fafb; border-radius:6px; border:1px dashed #d1d5db; display:flex; align-items:center; justify-content:center; font-size:10px; font-weight:700; color:#9ca3af;">
                                        +{{ $order->items->count() - 4 }}
                                    </div>
                                @endif
                                <div style="flex-shrink:0; margin-left:auto; text-align:right;">
                                    <div style="font-size:10px; color:#9ca3af;">Total</div>
                                    <div style="font-size:14px; font-weight:800; color:#7c3aed;">Rp
                                        {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                                </div>
                            </div>
                            {{-- Action --}}
                            <div style="padding:8px 12px;">
                                <a href="{{ route('orders.show', $order->order_number) }}"
                                    style="display:block; text-align:center; background:linear-gradient(90deg,#7c3aed,#ec4899); color:#fff; font-size:12px; font-weight:700; padding:8px; border-radius:10px; text-decoration:none;">
                                    Lihat Detail <i class="fas fa-arrow-right" style="margin-left:4px;"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ===== DESKTOP: compact table ===== --}}
            <div class="hidden md:block" style="padding:28px 32px 48px;">
                <div class="max-w-7xl mx-auto">

                    {{-- Header --}}
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
                        <div>
                            <h1 style="font-size:24px; font-weight:800; color:#111827; margin-bottom:2px;">Pesanan Saya</h1>
                            <p style="font-size:13px; color:#6b7280;">{{ $orders->total() }} total pesanan</p>
                        </div>
                        <a href="{{ route('books.index') }}"
                            style="display:inline-flex; align-items:center; gap:6px; background:linear-gradient(90deg,#7c3aed,#ec4899); color:#fff; font-size:13px; font-weight:700; padding:9px 20px; border-radius:10px; text-decoration:none;">
                            <i class="fas fa-book"></i> Belanja Lagi
                        </a>
                    </div>

                    {{-- Table --}}
                    <div
                        style="background:#fff; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,0.07); overflow:hidden;">
                        {{-- Table head --}}
                        <div
                            style="display:grid; grid-template-columns:160px 1fr 130px 150px 110px 120px; align-items:center; padding:12px 20px; background:#f9fafb; border-bottom:1px solid #e5e7eb;">
                            <div
                                style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.06em;">
                                No. Pesanan</div>
                            <div
                                style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.06em;">
                                Buku</div>
                            <div
                                style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.06em;">
                                Tanggal</div>
                            <div
                                style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.06em;">
                                Total</div>
                            <div
                                style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.06em;">
                                Status</div>
                            <div></div>
                        </div>

                        {{-- Table rows --}}
                        @foreach ($orders as $index => $order)
                            <div style="display:grid; grid-template-columns:160px 1fr 130px 150px 110px 120px; align-items:center; padding:14px 20px; {{ !$loop->last ? 'border-bottom:1px solid #f3f4f6;' : '' }} transition:background 0.15s;"
                                onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background=''">

                                {{-- Order number --}}
                                <div>
                                    <div style="font-size:13px; font-weight:700; color:#111827;">
                                        #{{ $order->order_number }}</div>
                                    <div style="font-size:11px; color:#9ca3af;">{{ $order->items->sum('quantity') }} item
                                    </div>
                                </div>

                                {{-- Book thumbnails --}}
                                <div style="display:flex; align-items:center; gap:4px;">
                                    @foreach ($order->items->take(5) as $item)
                                        <div style="position:relative;" title="{{ $item->book->title }}">
                                            @if ($item->book->cover_image)
                                                <img src="{{ asset('storage/' . $item->book->cover_image) }}"
                                                    alt="{{ $item->book->title }}"
                                                    style="width:32px; height:42px; object-fit:cover; border-radius:5px; border:1px solid #e5e7eb;">
                                            @else
                                                <div
                                                    style="width:32px; height:42px; background:#f3f0ff; border-radius:5px; display:flex; align-items:center; justify-content:center;">
                                                    <i class="fas fa-book" style="font-size:10px; color:#c4b5fd;"></i>
                                                </div>
                                            @endif
                                            @if ($item->quantity > 1)
                                                <div
                                                    style="position:absolute; top:-3px; right:-3px; background:#7c3aed; color:#fff; font-size:7px; font-weight:700; border-radius:999px; min-width:13px; height:13px; display:flex; align-items:center; justify-content:center; padding:0 2px; border:1.5px solid #fff;">
                                                    {{ $item->quantity }}</div>
                                            @endif
                                        </div>
                                    @endforeach
                                    @if ($order->items->count() > 5)
                                        <div
                                            style="width:32px; height:42px; background:#f9fafb; border-radius:5px; border:1px dashed #d1d5db; display:flex; align-items:center; justify-content:center; font-size:10px; font-weight:700; color:#9ca3af;">
                                            +{{ $order->items->count() - 5 }}
                                        </div>
                                    @endif
                                </div>

                                {{-- Date --}}
                                <div>
                                    <div style="font-size:12px; color:#374151; font-weight:500;">
                                        {{ $order->created_at->format('d M Y') }}</div>
                                    <div style="font-size:11px; color:#9ca3af;">{{ $order->created_at->format('H:i') }}
                                    </div>
                                </div>

                                {{-- Total --}}
                                <div style="font-size:14px; font-weight:800; color:#7c3aed;">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </div>

                                {{-- Status --}}
                                <div>
                                    <span
                                        style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:700; padding:4px 10px; border-radius:20px; {{ orderStatusStyle($order->status) }}">
                                        <i class="{{ orderStatusIcon($order->status) }}" style="font-size:10px;"></i>
                                        {{ orderStatusLabel($order->status) }}
                                    </span>
                                </div>

                                {{-- Action --}}
                                <div style="text-align:right;">
                                    <a href="{{ route('orders.show', $order->order_number) }}"
                                        style="display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:700; color:#7c3aed; background:#f3f0ff; padding:7px 14px; border-radius:8px; text-decoration:none; transition:background 0.15s;"
                                        onmouseover="this.style.background='#ede9fe'"
                                        onmouseout="this.style.background='#f3f0ff'">
                                        Detail <i class="fas fa-arrow-right" style="font-size:10px;"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div style="margin-top:20px;">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        @else
            {{-- MOBILE empty --}}
            <div class="md:hidden" style="padding:56px 24px; text-align:center;">
                <div
                    style="width:80px; height:80px; background:linear-gradient(135deg,#f3f0ff,#fce7f3); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                    <i class="fas fa-box-open" style="font-size:36px; color:#d1d5db;"></i>
                </div>
                <div style="font-size:16px; font-weight:700; color:#374151; margin-bottom:8px;">Belum Ada Pesanan</div>
                <div style="font-size:13px; color:#6b7280; margin-bottom:24px;">Anda belum melakukan pemesanan apapun</div>
                <a href="{{ route('books.index') }}"
                    style="display:inline-flex; align-items:center; gap:8px; background:linear-gradient(90deg,#7c3aed,#ec4899); color:#fff; font-size:14px; font-weight:700; padding:12px 28px; border-radius:20px; text-decoration:none;">
                    <i class="fas fa-book"></i> Mulai Belanja
                </a>
            </div>

            {{-- DESKTOP empty --}}
            <div class="hidden md:block" style="padding:32px;">
                <div class="max-w-7xl mx-auto">
                    <div
                        style="background:#fff; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,0.07); padding:80px 32px; text-align:center;">
                        <i class="fas fa-box-open"
                            style="font-size:56px; color:#d1d5db; display:block; margin-bottom:16px;"></i>
                        <h2 style="font-size:20px; font-weight:700; color:#374151; margin-bottom:8px;">Belum Ada Pesanan
                        </h2>
                        <p style="color:#6b7280; margin-bottom:24px;">Anda belum melakukan pemesanan apapun</p>
                        <a href="{{ route('books.index') }}"
                            style="display:inline-flex; align-items:center; gap:8px; background:linear-gradient(90deg,#7c3aed,#ec4899); color:#fff; font-size:14px; font-weight:700; padding:12px 28px; border-radius:12px; text-decoration:none;">
                            <i class="fas fa-book"></i> Mulai Belanja
                        </a>
                    </div>
                </div>
            </div>

        @endif
    </div>
@endsection
