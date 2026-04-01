@extends('admin.layouts.app')

@section('title', 'Kelola Buku - Admin Panel')
@section('page-title', 'Kelola Buku')

@section('content')

    {{-- ── Stat Cards ── --}}
    <div class="grid grid-cols-3 gap-4 mb-5">
        <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl shadow-md p-4 sm:p-5 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-purple-200 font-medium">Total Buku</p>
                    <p class="text-2xl sm:text-3xl font-black mt-0.5">{{ $books->total() }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-book text-lg sm:text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl shadow-md p-4 sm:p-5 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-yellow-100 font-medium">Landing Page</p>
                    <p class="text-2xl sm:text-3xl font-black mt-0.5">
                        {{ \App\Models\Book::where('is_featured', true)->count() }}</p>
                </div>
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-crown text-lg sm:text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl shadow-md p-4 sm:p-5 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-emerald-100 font-medium">Total Stok</p>
                    <p class="text-2xl sm:text-3xl font-black mt-0.5">{{ \App\Models\Book::sum('stock') }}</p>
                </div>
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-boxes text-lg sm:text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Info tip (collapsible on mobile) ── --}}
    <div x-data="{ open: false }" class="mb-5">
        <button @click="open = !open"
            class="w-full flex items-center justify-between gap-2 bg-blue-50 border border-blue-200 rounded-xl px-4 py-3 text-left hover:bg-blue-100 transition-colors">
            <div class="flex items-center gap-2 text-blue-800">
                <i class="fas fa-info-circle text-blue-500"></i>
                <span class="text-sm font-semibold">Cara menampilkan buku di Landing Page</span>
            </div>
            <i class="fas fa-chevron-down text-blue-400 text-xs transition-transform" :class="open && 'rotate-180'"></i>
        </button>
        <div x-show="open" x-collapse class="bg-blue-50 border border-t-0 border-blue-200 rounded-b-xl px-4 py-3">
            <ul class="text-sm text-blue-700 space-y-1 list-disc list-inside">
                <li><strong>Buku Pilihan Editor:</strong> Centang "Tampilkan di Halaman Utama" saat membuat/edit buku</li>
                <li><strong>Buku Terbaru:</strong> Otomatis menampilkan 8 buku terbaru</li>
                <li><strong>Katalog Lengkap:</strong> Semua buku muncul di halaman katalog</li>
            </ul>
        </div>
    </div>

    {{-- ── Filter + Add button ── --}}
    <div class="mb-4" x-data="{
        searchQuery: '{{ request('search') }}',
        categoryFilter: '{{ request('category') }}',
        searchTimeout: null,
        liveFilter() {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                let url = '{{ route('admin.books.index') }}';
                let params = [];
                if (this.searchQuery) params.push('search=' + encodeURIComponent(this.searchQuery));
                if (this.categoryFilter) params.push('category=' + this.categoryFilter);
                window.location.href = url + (params.length ? '?' + params.join('&') : '');
            }, 500);
        }
    }">
        <div class="flex flex-col sm:flex-row gap-3">
            {{-- Search --}}
            <div class="relative flex-1 sm:max-w-xs">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" x-model="searchQuery" @input="liveFilter()" placeholder="Cari judul / penulis..."
                    class="w-full pl-9 pr-9 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white shadow-sm">
                <button x-show="searchQuery" @click="searchQuery = ''; liveFilter()"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600" x-cloak>
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
            {{-- Category filter --}}
            <select x-model="categoryFilter" @change="liveFilter()"
                class="w-full sm:w-44 px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white shadow-sm">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}</option>
                @endforeach
            </select>
            {{-- Clear --}}
            <button x-show="searchQuery || categoryFilter" @click="searchQuery = ''; categoryFilter = ''; liveFilter()"
                class="sm:w-auto px-4 py-2.5 text-sm font-semibold bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl transition-colors flex items-center justify-center gap-1.5"
                x-cloak>
                <i class="fas fa-times text-xs"></i> Reset
            </button>
            {{-- Add button --}}
            <a href="{{ route('admin.books.create') }}"
                class="sm:ml-auto inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm transition-colors whitespace-nowrap flex-shrink-0">
                <i class="fas fa-plus"></i> Tambah Buku
            </a>
        </div>
    </div>

    <p class="text-xs text-gray-500 mb-3 font-medium">
        Menampilkan <span class="font-bold text-gray-700">{{ $books->total() }}</span> buku
        @if (request('search'))
            &mdash; hasil "<em>{{ request('search') }}</em>"
        @endif
        @if (request('category'))
            &mdash; di kategori terpilih
        @endif
    </p>

    <form id="bulk-delete-form" action="{{ route('admin.books.bulk-destroy') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
        <div id="bulk-delete-inputs"></div>
    </form>

    <div id="bulk-action-bar" class="hidden mb-3 bg-red-50 border border-red-100 rounded-xl p-3">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <p class="text-sm text-red-700 font-semibold">
                <span id="selected-books-count">0</span> buku dipilih
            </p>
            <div class="flex items-center gap-2">
                <button type="button" id="clear-selection"
                    class="px-3 py-2 text-xs font-semibold rounded-lg text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors">
                    Batal Pilih
                </button>
                <button type="button" id="bulk-delete-trigger"
                    class="px-3 py-2 text-xs font-semibold rounded-lg text-white bg-red-600 hover:bg-red-700 transition-colors">
                    <i class="fas fa-trash mr-1"></i> Hapus Terpilih
                </button>
            </div>
        </div>
    </div>

    {{-- ── Desktop Table ── --}}
    <div class="hidden sm:block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-4 py-3.5 text-center">
                        <input type="checkbox" id="select-all-books"
                            class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    </th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider">Buku</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider">Kategori
                    </th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider">Harga
                    </th>
                    <th class="px-6 py-3.5 text-center text-[11px] font-bold text-gray-400 uppercase tracking-wider">Stok
                    </th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider">Status
                    </th>
                    <th class="px-6 py-3.5 text-right text-[11px] font-bold text-gray-400 uppercase tracking-wider">Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($books as $book)
                    <tr class="hover:bg-blue-50/30 transition-colors group">
                        <td class="px-4 py-3.5 text-center align-top">
                            <input type="checkbox"
                                class="js-book-checkbox w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                value="{{ $book->id }}" aria-label="Pilih buku {{ $book->title }}">
                        </td>
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-14 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden flex items-center justify-center">
                                    @if ($book->cover_image)
                                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-book text-gray-300"></i>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p
                                        class="text-sm font-semibold text-gray-800 truncate max-w-[200px] group-hover:text-blue-700 transition-colors">
                                        {{ $book->title }}</p>
                                    <p class="text-xs text-gray-400 truncate max-w-[200px]">{{ $book->author }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-3.5">
                            <span
                                class="inline-block bg-gray-100 text-gray-600 text-xs font-semibold px-2.5 py-1 rounded-full">{{ $book->category->name }}</span>
                        </td>
                        <td class="px-6 py-3.5">
                            <p class="text-sm font-bold text-gray-800">Rp {{ number_format($book->price, 0, ',', '.') }}
                            </p>
                            @if ($book->discount > 0)
                                <p class="text-xs text-emerald-600 font-semibold">Diskon {{ $book->discount }}%</p>
                            @endif
                        </td>
                        <td class="px-6 py-3.5 text-center">
                            @if ($book->stock == 0)
                                <span
                                    class="inline-block bg-red-100 text-red-700 text-xs font-bold px-2.5 py-1 rounded-full">Habis</span>
                            @elseif($book->stock <= 10)
                                <span
                                    class="inline-block bg-orange-100 text-orange-700 text-xs font-bold px-2.5 py-1 rounded-full">{{ $book->stock }}</span>
                            @else
                                <span
                                    class="inline-block bg-emerald-50 text-emerald-700 text-xs font-bold px-2.5 py-1 rounded-full">{{ $book->stock }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-3.5">
                            @if ($book->is_featured)
                                <span
                                    class="inline-flex items-center gap-1 bg-gradient-to-r from-yellow-400 to-orange-400 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-sm">
                                    <i class="fas fa-crown text-[10px]"></i> Landing Page
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1 bg-gray-100 text-gray-500 text-xs font-medium px-2.5 py-1 rounded-full">
                                    <i class="fas fa-eye-slash text-[10px]"></i> Tersembunyi
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.books.edit', $book) }}"
                                    class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.books.destroy', $book) }}" method="POST"
                                    class="inline js-delete-book-form" data-book-title="{{ $book->title }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <i class="fas fa-book text-4xl text-gray-200 mb-3 block"></i>
                            <p class="text-gray-400 font-medium">Tidak ada buku ditemukan</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ── Mobile Card List ── --}}
    <div class="sm:hidden space-y-3">
        @forelse($books as $book)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                <div class="flex gap-3">
                    {{-- Cover --}}
                    <div
                        class="w-12 h-16 bg-gray-100 rounded-xl flex-shrink-0 overflow-hidden flex items-center justify-center">
                        @if ($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-book text-gray-300"></i>
                        @endif
                    </div>
                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <p class="text-sm font-bold text-gray-800 leading-snug truncate">{{ $book->title }}</p>
                            @if ($book->is_featured)
                                <span
                                    class="flex-shrink-0 inline-flex items-center gap-0.5 bg-gradient-to-r from-yellow-400 to-orange-400 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                                    <i class="fas fa-crown text-[9px]"></i> Featured
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $book->author }}</p>
                        <div class="flex flex-wrap items-center gap-2 mt-2">
                            <span
                                class="bg-gray-100 text-gray-600 text-[10px] font-semibold px-2 py-0.5 rounded-full">{{ $book->category->name }}</span>
                            @if ($book->stock == 0)
                                <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded-full">Stok
                                    Habis</span>
                            @elseif($book->stock <= 10)
                                <span
                                    class="bg-orange-100 text-orange-700 text-[10px] font-bold px-2 py-0.5 rounded-full">Stok:
                                    {{ $book->stock }}</span>
                            @else
                                <span
                                    class="bg-emerald-50 text-emerald-700 text-[10px] font-bold px-2 py-0.5 rounded-full">Stok:
                                    {{ $book->stock }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- Price + actions --}}
                <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-50">
                    <div>
                        <p class="text-sm font-extrabold text-gray-800">Rp {{ number_format($book->price, 0, ',', '.') }}
                        </p>
                        @if ($book->discount > 0)
                            <p class="text-xs text-emerald-600 font-semibold">Diskon {{ $book->discount }}%</p>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.books.edit', $book) }}"
                            class="inline-flex items-center gap-1 text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.books.destroy', $book) }}" method="POST"
                            class="inline js-delete-book-form" data-book-title="{{ $book->title }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center gap-1 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <i class="fas fa-book text-4xl text-gray-200 mb-3 block"></i>
                <p class="text-gray-400 font-medium">Tidak ada buku ditemukan</p>
            </div>
        @endforelse
    </div>

    {{-- ── Pagination ── --}}
    @if ($books->hasPages())
        <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-3">
            {{-- Info text --}}
            <p class="text-xs text-gray-500 font-medium order-2 sm:order-1">
                Menampilkan
                <span class="font-bold text-gray-700">{{ $books->firstItem() }}</span>–<span
                    class="font-bold text-gray-700">{{ $books->lastItem() }}</span>
                dari <span class="font-bold text-gray-700">{{ $books->total() }}</span> buku
            </p>

            {{-- Buttons --}}
            <div class="flex items-center gap-1.5 order-1 sm:order-2">
                {{-- Previous --}}
                @if ($books->onFirstPage())
                    <span
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-gray-300 bg-gray-50 rounded-xl cursor-not-allowed border border-gray-100 select-none">
                        <i class="fas fa-chevron-left text-[10px]"></i>
                        <span class="hidden sm:inline">Sebelumnya</span>
                    </span>
                @else
                    <a href="{{ $books->appends(['search' => request('search'), 'category' => request('category')])->previousPageUrl() }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-gray-600 bg-white hover:bg-blue-50 hover:text-blue-600 rounded-xl border border-gray-200 transition-colors shadow-sm">
                        <i class="fas fa-chevron-left text-[10px]"></i>
                        <span class="hidden sm:inline">Sebelumnya</span>
                    </a>
                @endif

                {{-- Page numbers --}}
                @foreach ($books->getUrlRange(1, $books->lastPage()) as $page => $url)
                    @if ($page == $books->currentPage())
                        <span
                            class="w-9 h-9 flex items-center justify-center text-xs font-bold text-white bg-blue-600 rounded-xl shadow-sm">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $books->appends(['search' => request('search'), 'category' => request('category')])->url($page) }}"
                            class="w-9 h-9 flex items-center justify-center text-xs font-semibold text-gray-600 bg-white hover:bg-blue-50 hover:text-blue-600 rounded-xl border border-gray-200 transition-colors">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($books->hasMorePages())
                    <a href="{{ $books->appends(['search' => request('search'), 'category' => request('category')])->nextPageUrl() }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-gray-600 bg-white hover:bg-blue-50 hover:text-blue-600 rounded-xl border border-gray-200 transition-colors shadow-sm">
                        <span class="hidden sm:inline">Berikutnya</span>
                        <i class="fas fa-chevron-right text-[10px]"></i>
                    </a>
                @else
                    <span
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-gray-300 bg-gray-50 rounded-xl cursor-not-allowed border border-gray-100 select-none">
                        <span class="hidden sm:inline">Berikutnya</span>
                        <i class="fas fa-chevron-right text-[10px]"></i>
                    </span>
                @endif
            </div>
        </div>
    @endif

    {{-- Delete confirmation modal --}}
    <div id="delete-book-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-6">
        <div class="absolute inset-0 bg-slate-900/60"></div>
        <div class="relative w-full max-w-md rounded-2xl bg-white shadow-2xl border border-slate-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 id="delete-book-heading" class="text-base font-bold text-slate-800">Konfirmasi Hapus Buku</h3>
                <button type="button" id="delete-book-close"
                    class="w-8 h-8 inline-flex items-center justify-center rounded-full text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors"
                    aria-label="Tutup modal hapus buku">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="px-5 py-4">
                <p id="delete-book-message" class="text-sm text-slate-600 leading-relaxed"></p>
            </div>
            <div class="px-5 pb-5 flex items-center justify-end gap-2.5">
                <button type="button" id="delete-book-cancel"
                    class="px-4 py-2 text-sm font-semibold rounded-xl text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                    Batal
                </button>
                <button type="button" id="delete-book-confirm"
                    class="px-4 py-2 text-sm font-semibold rounded-xl text-white bg-red-600 hover:bg-red-700 transition-colors">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('delete-book-modal');
            const headingText = document.getElementById('delete-book-heading');
            const messageText = document.getElementById('delete-book-message');
            const closeButton = document.getElementById('delete-book-close');
            const cancelButton = document.getElementById('delete-book-cancel');
            const confirmButton = document.getElementById('delete-book-confirm');
            const singleDeleteForms = document.querySelectorAll('.js-delete-book-form');
            const selectAllBooks = document.getElementById('select-all-books');
            const bookCheckboxes = Array.from(document.querySelectorAll('.js-book-checkbox'));
            const bulkActionBar = document.getElementById('bulk-action-bar');
            const selectedBooksCount = document.getElementById('selected-books-count');
            const clearSelectionButton = document.getElementById('clear-selection');
            const bulkDeleteTrigger = document.getElementById('bulk-delete-trigger');
            const bulkDeleteForm = document.getElementById('bulk-delete-form');
            const bulkDeleteInputs = document.getElementById('bulk-delete-inputs');
            let pendingForm = null;
            let pendingAction = null;

            if (!modal || !headingText || !messageText || !closeButton || !cancelButton || !confirmButton) {
                return;
            }

            const openModal = function(config) {
                pendingForm = config.form || null;
                pendingAction = typeof config.onConfirm === 'function' ? config.onConfirm : null;
                headingText.textContent = config.heading;
                messageText.textContent = config.message;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('overflow-hidden');
            };

            const closeModal = function() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
                pendingForm = null;
                pendingAction = null;
            };

            singleDeleteForms.forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const title = form.dataset.bookTitle || 'ini';
                    openModal({
                        form,
                        heading: 'Konfirmasi Hapus Buku',
                        message: 'Buku "' + title +
                            '" akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.'
                    });
                });
            });

            const updateBulkSelection = function() {
                if (!bookCheckboxes.length || !bulkActionBar || !selectedBooksCount) {
                    return;
                }

                const checkedCount = bookCheckboxes.filter(function(checkbox) {
                    return checkbox.checked;
                }).length;

                selectedBooksCount.textContent = checkedCount;
                bulkActionBar.classList.toggle('hidden', checkedCount === 0);

                if (selectAllBooks) {
                    selectAllBooks.checked = checkedCount > 0 && checkedCount === bookCheckboxes.length;
                    selectAllBooks.indeterminate = checkedCount > 0 && checkedCount < bookCheckboxes.length;
                }
            };

            if (selectAllBooks) {
                selectAllBooks.addEventListener('change', function() {
                    bookCheckboxes.forEach(function(checkbox) {
                        checkbox.checked = selectAllBooks.checked;
                    });
                    updateBulkSelection();
                });
            }

            bookCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', updateBulkSelection);
            });

            if (clearSelectionButton) {
                clearSelectionButton.addEventListener('click', function() {
                    bookCheckboxes.forEach(function(checkbox) {
                        checkbox.checked = false;
                    });
                    updateBulkSelection();
                });
            }

            if (bulkDeleteTrigger && bulkDeleteForm && bulkDeleteInputs) {
                bulkDeleteTrigger.addEventListener('click', function() {
                    const selectedBookIds = bookCheckboxes.filter(function(checkbox) {
                        return checkbox.checked;
                    }).map(function(checkbox) {
                        return checkbox.value;
                    });

                    if (!selectedBookIds.length) {
                        return;
                    }

                    openModal({
                        heading: 'Konfirmasi Hapus Buku Terpilih',
                        message: selectedBookIds.length +
                            ' buku akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.',
                        onConfirm: function() {
                            bulkDeleteInputs.innerHTML = '';

                            selectedBookIds.forEach(function(bookId) {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = 'book_ids[]';
                                input.value = bookId;
                                bulkDeleteInputs.appendChild(input);
                            });

                            bulkDeleteForm.submit();
                        }
                    });
                });
            }

            updateBulkSelection();

            closeButton.addEventListener('click', closeModal);
            cancelButton.addEventListener('click', closeModal);

            modal.addEventListener('click', function(event) {
                if (event.target === modal || event.target.classList.contains('bg-slate-900/60')) {
                    closeModal();
                }
            });

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });

            confirmButton.addEventListener('click', function() {
                if (pendingAction) {
                    const action = pendingAction;
                    closeModal();
                    action();
                    return;
                }

                if (!pendingForm) {
                    return;
                }

                const formToSubmit = pendingForm;
                closeModal();
                formToSubmit.submit();
            });
        });
    </script>
@endpush
