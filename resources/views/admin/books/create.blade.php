@extends('admin.layouts.app')

@section('title', 'Tambah Buku - Admin Panel')
@section('page-title', 'Tambah Buku')

@section('content')
    {{-- Back link --}}
    <div class="mb-5">
        <a href="{{ route('admin.books.index') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-blue-600 transition-colors">
            <i class="fas fa-arrow-left text-xs"></i> Kembali ke Daftar Buku
        </a>
    </div>

    <div class="max-w-4xl">
        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- ── Informasi Buku ── --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-5">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-book text-blue-600 text-sm"></i>
                    </div>
                    <h2 class="text-base font-bold text-gray-800">Informasi Buku</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul Buku <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" required
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all"
                            placeholder="Masukkan judul buku">
                        @error('title')
                            <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5"><i
                                    class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Penulis <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="author" value="{{ old('author') }}" required
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all"
                            placeholder="Nama penulis">
                        @error('author')
                            <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5"><i
                                    class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kategori <span
                                class="text-red-500">*</span></label>
                        <select name="category_id" required
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all bg-white">
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5"><i
                                    class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Penerbit</label>
                        <input type="text" name="publisher" value="{{ old('publisher') }}"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all"
                            placeholder="Nama penerbit">
                        @error('publisher')
                            <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5"><i
                                    class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">ISBN</label>
                        <input type="text" name="isbn" value="{{ old('isbn') }}"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all"
                            placeholder="978-xxx-xxx-xxxx">
                        @error('isbn')
                            <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5"><i
                                    class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Bahasa <span
                                class="text-red-500">*</span></label>
                        <select name="language" required
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all bg-white">
                            <option value="Indonesian"
                                {{ old('language', 'Indonesian') == 'Indonesian' ? 'selected' : '' }}>Indonesia</option>
                            <option value="English" {{ old('language') == 'English' ? 'selected' : '' }}>English</option>
                        </select>
                        @error('language')
                            <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5"><i
                                    class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jumlah Halaman</label>
                        <input type="number" name="pages" value="{{ old('pages') }}" min="1"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all"
                            placeholder="Contoh: 250">
                        @error('pages')
                            <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5"><i
                                    class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tahun Terbit</label>
                        <input type="number" name="published_year" value="{{ old('published_year') }}" min="1900"
                            max="{{ date('Y') }}"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all"
                            placeholder="{{ date('Y') }}">
                        @error('published_year')
                            <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5"><i
                                    class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi <span
                                class="text-red-500">*</span></label>
                        <textarea name="description" rows="4" required
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all resize-none"
                            placeholder="Tulis sinopsis atau deskripsi buku...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5"><i
                                    class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ── Harga & Stok ── --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-5">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-9 h-9 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-tag text-emerald-600 text-sm"></i>
                    </div>
                    <h2 class="text-base font-bold text-gray-800">Harga & Stok</h2>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Harga (Rp) <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="price" value="{{ old('price') }}" required min="0"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all"
                            placeholder="50000">
                        @error('price')
                            <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5"><i
                                    class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Diskon (%)</label>
                        <input type="number" name="discount" value="{{ old('discount', 0) }}" min="0"
                            max="100"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all"
                            placeholder="0">
                        <p class="text-xs text-gray-400 mt-1.5">0 = tidak ada diskon</p>
                        @error('discount')
                            <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5"><i
                                    class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Stok <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="stock" value="{{ old('stock') }}" required min="0"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all"
                            placeholder="0">
                        @error('stock')
                            <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5"><i
                                    class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ── Media ── --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-5">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-9 h-9 bg-violet-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-image text-violet-600 text-sm"></i>
                    </div>
                    <h2 class="text-base font-bold text-gray-800">Media</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Cover Buku</label>
                        <input type="file" name="cover_image" accept="image/*"
                            class="block w-full text-sm text-gray-600 border-2 border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:border-blue-500 transition-all file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100">
                        <p class="text-xs text-gray-400 mt-1.5">JPG, PNG. Rekomendasi rasio 2:3</p>
                        @error('cover_image')
                            <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5"><i
                                    class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Galeri Gambar <span
                                class="text-gray-400 font-normal text-xs">(opsional, bisa lebih dari satu)</span></label>
                        <input type="file" name="gallery_images[]" accept="image/*" multiple
                            class="block w-full text-sm text-gray-600 border-2 border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:border-blue-500 transition-all file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-400 mt-1.5">Maks. 8 gambar, tiap file maks. 2MB</p>
                        @error('gallery_images')
                            <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5"><i
                                    class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                        @error('gallery_images.*')
                            <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5"><i
                                    class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">File PDF <span
                                class="text-gray-400 font-normal text-xs">(Sample/Preview, opsional)</span></label>
                        <input type="file" name="pdf_file" accept="application/pdf"
                            class="block w-full text-sm text-gray-600 border-2 border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:border-blue-500 transition-all file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                        <p class="text-xs text-gray-400 mt-1.5">Maks. 5MB</p>
                        @error('pdf_file')
                            <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5"><i
                                    class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ── Featured ── --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                <label
                    class="flex items-start gap-4 p-5 cursor-pointer hover:bg-amber-50/60 transition-colors rounded-2xl">
                    <div class="flex-shrink-0 mt-0.5">
                        <input type="checkbox" name="is_featured" value="1"
                            {{ old('is_featured') ? 'checked' : '' }}
                            class="w-5 h-5 rounded border-2 border-gray-300 text-amber-500 focus:ring-amber-400 cursor-pointer">
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <div class="w-7 h-7 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-crown text-amber-500 text-xs"></i>
                            </div>
                            <span class="text-sm font-bold text-gray-800">Tampilkan di Landing Page</span>
                        </div>
                        <p class="text-xs text-gray-500">Centang untuk menampilkan buku ini di section "Buku Pilihan
                            Editor" pada halaman utama website</p>
                    </div>
                </label>
            </div>

            {{-- ── Actions ── --}}
            <div class="flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('admin.books.index') }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-semibold text-gray-600 bg-white hover:bg-gray-50 border-2 border-gray-200 rounded-xl transition-all">
                    <i class="fas fa-times text-xs"></i> Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm hover:shadow-md transition-all">
                    <i class="fas fa-save"></i> Simpan Buku
                </button>
            </div>
        </form>
    </div>
@endsection
