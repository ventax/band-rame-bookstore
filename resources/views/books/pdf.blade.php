@extends('layouts.app')

@section('title', 'Preview PDF - ' . $book->title)

@section('content')
    @php
        $pdfUrl = route('books.pdf.file', $book->id);
        $pdfEmbedUrl = $pdfUrl . '#toolbar=0&navpanes=0&view=FitH';
    @endphp

    <div class="min-h-screen py-8 bg-gradient-to-b from-blue-50 via-slate-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-2xl shadow-md ring-1 ring-blue-100 p-6 mb-6">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-slate-900 mb-2">{{ $book->title }}</h1>
                        <p class="text-slate-600">
                            <i class="fas fa-user mr-2"></i>{{ $book->author }}
                            <span class="mx-2">•</span>
                            <i class="fas fa-building mr-2"></i>{{ $book->publisher }}
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ $pdfUrl }}" download="{{ $book->title }}.pdf"
                            class="inline-flex items-center px-6 py-3 bg-blue-700 hover:bg-blue-800 text-white font-bold rounded-xl transition-colors shadow-sm ring-1 ring-blue-500/40 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-300 focus-visible:ring-offset-2"
                            style="background-color:#1d4ed8;color:#ffffff;border:1px solid #1e40af;">
                            <i class="fas fa-download mr-2"></i>Download PDF
                        </a>
                        <a href="{{ route('books.show', $book->slug) }}"
                            class="inline-flex items-center px-6 py-3 bg-slate-700 hover:bg-slate-800 text-white font-bold rounded-xl transition-colors shadow-sm ring-1 ring-slate-500/40 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-300 focus-visible:ring-offset-2"
                            style="background-color:#334155;color:#ffffff;border:1px solid #1e293b;">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Detail Buku
                        </a>
                    </div>
                </div>
            </div>

            <!-- PDF Viewer -->
            <div class="bg-white rounded-2xl shadow-md ring-1 ring-blue-100 p-4 sm:p-6">
                <div class="mb-4 flex items-center justify-between gap-3 flex-wrap">
                    <h2 class="text-lg sm:text-xl font-semibold text-slate-900">Preview Buku</h2>
                    <a href="{{ $pdfUrl }}" target="_blank" rel="noopener"
                        class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-semibold transition-colors shadow-sm ring-1 ring-blue-300/80">
                        <i class="fas fa-up-right-from-square mr-2"></i>Buka Tab Baru
                    </a>
                </div>

                <div class="sm:hidden">
                    <div class="rounded-xl border border-blue-200 bg-gradient-to-b from-blue-50 to-white p-4 text-center">
                        <div
                            class="mx-auto mb-3 h-12 w-12 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center">
                            <i class="fas fa-file-pdf text-xl"></i>
                        </div>
                        <p class="text-slate-700 text-sm leading-relaxed">
                            Untuk mobile, preview PDF berat dan sering terpotong. Buka di tab baru untuk pengalaman lebih
                            stabil.
                        </p>
                        <div class="mt-4 grid grid-cols-1 gap-3">
                            <a href="{{ $pdfUrl }}" target="_blank" rel="noopener"
                                class="inline-flex items-center justify-center px-4 py-3 rounded-lg bg-blue-700 hover:bg-blue-800 text-white font-semibold transition-colors shadow-sm ring-1 ring-blue-500/40 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-300 focus-visible:ring-offset-2"
                                style="background-color:#1d4ed8;color:#ffffff;border:1px solid #1e40af;">
                                <i class="fas fa-eye mr-2"></i>Lihat PDF Penuh
                            </a>
                            <a href="#preview-mobile"
                                class="inline-flex items-center justify-center px-4 py-3 rounded-lg bg-white border border-blue-300 text-blue-800 hover:bg-blue-50 font-semibold transition-colors shadow-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-300 focus-visible:ring-offset-2"
                                style="background-color:#ffffff;color:#1e40af;border:1px solid #93c5fd;">
                                <i class="fas fa-mobile-screen mr-2"></i>Toggle Preview Ringan
                            </a>
                        </div>
                    </div>

                    <details id="preview-mobile" class="mt-4 group">
                        <summary
                            class="cursor-pointer list-none inline-flex items-center rounded-lg bg-blue-700 hover:bg-blue-800 text-white font-semibold px-4 py-2 transition-colors shadow-sm ring-1 ring-blue-500/40 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-300 focus-visible:ring-offset-2"
                            style="background-color:#1d4ed8;color:#ffffff;border:1px solid #1e40af;">
                            <i class="fas fa-eye mr-2"></i>Tampilkan Preview Ringan
                        </summary>
                        <div class="mt-3">
                            <iframe src="{{ $pdfEmbedUrl }}" class="w-full rounded-xl border border-blue-200"
                                style="height: 72vh;" frameborder="0" loading="lazy"
                                title="Preview PDF {{ $book->title }}">
                                <p class="text-center text-slate-500 p-6">
                                    Browser Anda tidak mendukung tampilan PDF.
                                    <a href="{{ $pdfUrl }}" download class="text-blue-600 hover:underline">
                                        Klik di sini untuk download
                                    </a>
                                </p>
                            </iframe>
                        </div>
                    </details>
                </div>

                <div class="hidden sm:block">
                    <iframe src="{{ $pdfEmbedUrl }}" class="w-full rounded-xl border border-blue-200"
                        style="height: min(82vh, 980px);" frameborder="0" loading="lazy"
                        title="Preview PDF {{ $book->title }}">
                        <p class="text-center text-slate-500 p-8">
                            Browser Anda tidak mendukung tampilan PDF.
                            <a href="{{ $pdfUrl }}" download class="text-blue-600 hover:underline">
                                Klik di sini untuk download
                            </a>
                        </p>
                    </iframe>
                </div>
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border-l-4 border-blue-400 p-6 mt-6 rounded-r-xl">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-bold text-blue-900 mb-2">Informasi Preview PDF</h3>
                        <ul class="list-disc list-inside text-blue-700 space-y-1">
                            <li>Ini adalah preview/sample dari buku <strong>{{ $book->title }}</strong></li>
                            <li>Anda dapat mendownload file PDF ini menggunakan tombol download di atas</li>
                            <li>Jika preview lambat di mobile, gunakan tombol Buka Tab Baru</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            @auth
                <div
                    class="bg-gradient-to-r from-blue-700 to-cyan-600 rounded-2xl shadow-lg shadow-blue-200 p-8 mt-6 text-white text-center">
                    <h2 class="text-2xl font-bold mb-4">Tertarik dengan Buku Ini?</h2>
                    <p class="mb-6 text-blue-100">Dapatkan buku lengkapnya sekarang!</p>
                    <div class="flex justify-center gap-4">
                        <form action="{{ route('cart.add', $book->id) }}" method="POST" class="inline-block">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            @if ($book->stock > 0)
                                <button type="submit"
                                    class="inline-flex items-center px-8 py-4 bg-white text-blue-800 font-bold rounded-lg hover:bg-blue-50 transition-colors shadow-sm ring-1 ring-white/70 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-200 focus-visible:ring-offset-2 focus-visible:ring-offset-blue-700"
                                    style="background-color:#ffffff;color:#1e3a8a;border:1px solid #bfdbfe;">
                                    <i class="fas fa-shopping-cart mr-2"></i>Tambah ke Keranjang
                                </button>
                            @else
                                <button type="button" disabled
                                    class="inline-flex items-center px-8 py-4 bg-slate-400 text-white font-bold rounded-lg cursor-not-allowed opacity-70 ring-1 ring-slate-300/60"
                                    style="background-color:#94a3b8;color:#ffffff;border:1px solid #64748b;">
                                    <i class="fas fa-times-circle mr-2"></i>Stok Habis
                                </button>
                            @endif
                        </form>
                        <a href="{{ route('books.show', $book->slug) }}"
                            class="inline-flex items-center px-8 py-4 bg-sky-900 hover:bg-sky-950 text-white font-bold rounded-lg transition-colors shadow-sm ring-1 ring-white/30 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-200 focus-visible:ring-offset-2 focus-visible:ring-offset-blue-700"
                            style="background-color:#0c4a6e;color:#ffffff;border:1px solid #075985;">
                            <i class="fas fa-book mr-2"></i>Lihat Detail Lengkap
                        </a>
                    </div>
                </div>
            @else
                <div
                    class="bg-gradient-to-r from-blue-700 to-cyan-600 rounded-2xl shadow-lg shadow-blue-200 p-8 mt-6 text-white text-center">
                    <h2 class="text-2xl font-bold mb-4">Tertarik dengan Buku Ini?</h2>
                    <p class="mb-6 text-blue-100">Login untuk membeli buku ini!</p>
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center px-8 py-4 bg-white text-blue-800 font-bold rounded-lg hover:bg-blue-50 transition-colors shadow-sm ring-1 ring-white/70 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-200 focus-visible:ring-offset-2 focus-visible:ring-offset-blue-700"
                        style="background-color:#ffffff;color:#1e3a8a;border:1px solid #bfdbfe;">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login Sekarang
                    </a>
                </div>
            @endauth
        </div>
    </div>
@endsection
