@extends('admin.layouts.app')

@section('title', 'Kelola Kategori - Admin Panel')
@section('page-title', 'Kelola Kategori')

@section('content')
    {{-- Header: search + add button --}}
    <div class="mb-5" x-data="{
        searchQuery: '{{ request('search') }}',
        searchTimeout: null,
        liveSearch() {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                let url = '{{ route('admin.categories.index') }}';
                window.location.href = this.searchQuery ? url + '?search=' + encodeURIComponent(this.searchQuery) : url;
            }, 500);
        }
    }">
        <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
            <div class="relative flex-1 sm:max-w-xs">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" x-model="searchQuery" @input="liveSearch()" placeholder="Cari kategori..."
                    class="w-full pl-9 pr-9 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white shadow-sm">
                <button x-show="searchQuery" @click="searchQuery = ''; liveSearch()"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600" x-cloak>
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
            <a href="{{ route('admin.categories.create') }}"
                class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm transition-colors flex-shrink-0">
                <i class="fas fa-plus"></i> Tambah Kategori
            </a>
        </div>
    </div>

    {{-- Summary badge --}}
    <p class="text-xs text-gray-500 mb-3 font-medium">
        Menampilkan <span class="font-bold text-gray-700">{{ $categories->total() }}</span> kategori
        @if (request('search'))
            &mdash; hasil pencarian "<em>{{ request('search') }}</em>"
        @endif
    </p>

    {{-- Desktop Table --}}
    <div class="hidden sm:block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-3.5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider">Nama
                        Kategori</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider">Deskripsi
                    </th>
                    <th class="px-6 py-3.5 text-center text-[11px] font-bold text-gray-400 uppercase tracking-wider">Jumlah
                        Buku</th>
                    <th class="px-6 py-3.5 text-right text-[11px] font-bold text-gray-400 uppercase tracking-wider">Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($categories as $i => $category)
                    <tr class="hover:bg-blue-50/40 transition-colors group">
                        <td class="px-6 py-4 text-sm text-gray-400 font-medium w-10">
                            {{ $categories->firstItem() + $i }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-tag text-blue-500 text-xs"></i>
                                </div>
                                <div>
                                    <p
                                        class="text-sm font-semibold text-gray-800 group-hover:text-blue-700 transition-colors">
                                        {{ $category->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $category->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-500">
                                {{ $category->description ? Str::limit($category->description, 60) : '—' }}</p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span
                                class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 text-xs font-bold px-3 py-1 rounded-full">
                                <i class="fas fa-book text-[10px]"></i> {{ $category->books_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                    class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Yakin ingin menghapus kategori \'{{ addslashes($category->name) }}\'?')">
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
                        <td colspan="5" class="px-6 py-16 text-center">
                            <i class="fas fa-tags text-4xl text-gray-200 mb-3 block"></i>
                            <p class="text-gray-400 font-medium">Tidak ada kategori ditemukan</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Mobile Card List --}}
    <div class="sm:hidden space-y-3">
        @forelse($categories as $category)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-tag text-blue-500 text-sm"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-gray-800 truncate">{{ $category->name }}</p>
                            <p class="text-xs text-gray-400">{{ $category->slug }}</p>
                        </div>
                    </div>
                    <span
                        class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 text-xs font-bold px-2.5 py-1 rounded-full flex-shrink-0">
                        <i class="fas fa-book text-[10px]"></i> {{ $category->books_count }} buku
                    </span>
                </div>
                @if ($category->description)
                    <p class="text-xs text-gray-500 mt-2.5 pl-13">{{ Str::limit($category->description, 80) }}</p>
                @endif
                <div class="flex gap-2 mt-3 pt-3 border-t border-gray-50">
                    <a href="{{ route('admin.categories.edit', $category) }}"
                        class="flex-1 flex items-center justify-center gap-1.5 text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 py-2 rounded-xl transition-colors">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="flex-1"
                        onsubmit="return confirm('Yakin ingin menghapus kategori \'{{ addslashes($category->name) }}\'?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-1.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 py-2 rounded-xl transition-colors">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <i class="fas fa-tags text-4xl text-gray-200 mb-3 block"></i>
                <p class="text-gray-400 font-medium">Tidak ada kategori ditemukan</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $categories->appends(['search' => request('search')])->links() }}
    </div>
@endsection
