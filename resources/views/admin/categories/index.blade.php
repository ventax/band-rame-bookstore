@extends('admin.layouts.app')

@section('title', 'Kelola Kategori - Admin Panel')
@section('page-title', 'Kelola Kategori')

@section('content')
    <div class="mb-6" x-data="{
        searchQuery: '{{ request('search') }}',
        searchTimeout: null,
        liveSearch() {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                let url = '{{ route('admin.categories.index') }}';
                if (this.searchQuery) {
                    window.location.href = url + '?search=' + encodeURIComponent(this.searchQuery);
                } else {
                    window.location.href = url;
                }
            }, 500);
        }
    }">
        <div class="flex justify-between items-center">
            <!-- Live Search -->
            <div class="relative flex-1 max-w-md">
                <input type="text" x-model="searchQuery" @input="liveSearch()" placeholder="Ketik untuk mencari kategori..."
                    class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                <div x-show="searchQuery" @click="searchQuery = ''; liveSearch()"
                    class="absolute right-3 top-3 text-gray-400 hover:text-gray-600 cursor-pointer" x-cloak>
                    <i class="fas fa-times"></i>
                </div>
            </div>

            <a href="{{ route('admin.categories.create') }}" class="btn-primary">
                <i class="fas fa-plus mr-2"></i> Tambah Kategori
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kategori
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Buku
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($categories as $category)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                            <div class="text-sm text-gray-500">{{ $category->slug }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ Str::limit($category->description, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-900">{{ $category->books_count }} buku</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.categories.edit', $category) }}"
                                class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline"
                                onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-tags text-4xl mb-2"></i>
                            <p>Tidak ada kategori</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $categories->appends(['search' => request('search')])->links() }}
    </div>
@endsection
