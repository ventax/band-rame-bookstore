@extends('admin.layouts.app')

@section('title', 'Kelola Buku - Admin Panel')
@section('page-title', 'Kelola Buku')

@section('content')
    <!-- Info Box -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90 font-medium">Total Buku</p>
                    <p class="text-3xl font-black">{{ $books->total() }}</p>
                </div>
                <div class="bg-white/20 p-4 rounded-xl">
                    <i class="fas fa-book text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-yellow-400 to-orange-500 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90 font-medium">Di Landing Page</p>
                    <p class="text-3xl font-black">{{ \App\Models\Book::where('is_featured', true)->count() }}</p>
                </div>
                <div class="bg-white/20 p-4 rounded-xl">
                    <i class="fas fa-crown text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90 font-medium">Stok Tersedia</p>
                    <p class="text-3xl font-black">{{ \App\Models\Book::sum('stock') }}</p>
                </div>
                <div class="bg-white/20 p-4 rounded-xl">
                    <i class="fas fa-boxes text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Info -->
    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 rounded-r-lg">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-bold text-blue-900">Cara Menampilkan Buku di Landing Page</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <ul class="list-disc list-inside space-y-1">
                        <li><strong>Buku Pilihan Editor:</strong> Centang checkbox "Tampilkan di Halaman Utama" saat
                            membuat/edit buku</li>
                        <li><strong>Buku Terbaru:</strong> Otomatis menampilkan 8 buku terbaru yang baru ditambahkan</li>
                        <li><strong>Katalog Lengkap:</strong> Semua buku otomatis muncul di halaman katalog</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-6" x-data="{
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
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4 flex-1 mr-4">
                <!-- Live Search -->
                <div class="relative flex-1 max-w-md">
                    <input type="text" x-model="searchQuery" @input="liveFilter()"
                        placeholder="Ketik untuk mencari buku..."
                        class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    <div x-show="searchQuery" @click="searchQuery = ''; liveFilter()"
                        class="absolute right-3 top-3 text-gray-400 hover:text-gray-600 cursor-pointer">
                        <i class="fas fa-times"></i>
                    </div>
                </div>

                <!-- Live Category Filter -->
                <select x-model="categoryFilter" @change="liveFilter()"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>

                <!-- Clear Filter Button -->
                <button x-show="searchQuery || categoryFilter" @click="searchQuery = ''; categoryFilter = ''; liveFilter()"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors" x-cloak>
                    <i class="fas fa-times mr-1"></i> Clear
                </button>
            </div>
            <a href="{{ route('admin.books.create') }}" class="btn-primary whitespace-nowrap">
                <i class="fas fa-plus mr-2"></i> Tambah Buku
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buku</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($books as $book)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-14 bg-gray-200 rounded flex-shrink-0 flex items-center justify-center mr-3">
                                    <i class="fas fa-book text-gray-400"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $book->title }}</div>
                                    <div class="text-sm text-gray-500">{{ $book->author }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-900">{{ $book->category->name }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-semibold text-gray-900">Rp
                                {{ number_format($book->price, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="text-sm {{ $book->stock <= 10 ? 'text-red-600 font-semibold' : 'text-gray-900' }}">
                                {{ $book->stock }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($book->is_featured)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-yellow-400 to-orange-400 text-white shadow-sm">
                                    <i class="fas fa-crown mr-1"></i>
                                    Landing Page
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                    <i class="fas fa-minus-circle mr-1"></i>
                                    Tidak Ditampilkan
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.books.edit', $book) }}"
                                class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="inline"
                                onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
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
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-book text-4xl mb-2"></i>
                            <p>Tidak ada buku ditemukan</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $books->links() }}
    </div>
@endsection
