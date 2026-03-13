@extends('admin.layouts.app')

@section('title', 'Edit Kategori - Admin Panel')
@section('page-title', 'Edit Kategori')

@section('content')
    <div class="mb-5">
        <a href="{{ route('admin.categories.index') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-blue-600 transition-colors">
            <i class="fas fa-arrow-left text-xs"></i> Kembali ke Daftar Kategori
        </a>
    </div>

    <div class="max-w-2xl">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-5">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-tags text-blue-600 text-sm"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-gray-800">Informasi Kategori</h2>
                        <p class="text-xs text-gray-400">{{ $category->books_count }} buku dalam kategori ini</p>
                    </div>
                </div>
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Kategori <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all"
                            placeholder="Contoh: Fiksi, Non-Fiksi, Komik">
                        @error('name')
                            <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5"><i
                                    class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                        <textarea name="description" rows="4"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all resize-none"
                            placeholder="Deskripsi singkat tentang kategori ini...">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5"><i
                                    class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Gambar saat ini --}}
                    @if ($category->image)
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Gambar Saat Ini</label>
                            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                    class="w-20 h-20 object-cover rounded-xl border-2 border-gray-200 flex-shrink-0">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-700">{{ basename($category->image) }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Upload gambar baru untuk menggantinya</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            {{ $category->image ? 'Ganti Gambar' : 'Upload Gambar' }}
                            <span class="text-gray-400 font-normal text-xs">(opsional)</span>
                        </label>
                        <input type="file" name="image" accept="image/*"
                            class="block w-full text-sm text-gray-600 border-2 border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:border-blue-500 transition-all file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-400 mt-1.5">Format: JPG, PNG. Maksimal 2MB</p>
                        @error('image')
                            <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5"><i
                                    class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3 bg-blue-50 border border-blue-100 rounded-xl p-4 text-sm text-blue-700">
                        <i class="fas fa-info-circle mt-0.5 flex-shrink-0 text-blue-400"></i>
                        <span>Mengubah nama kategori tidak akan mempengaruhi buku yang sudah ada dalam kategori ini.</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('admin.categories.index') }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-semibold text-gray-600 bg-white hover:bg-gray-50 border-2 border-gray-200 rounded-xl transition-all">
                    <i class="fas fa-times text-xs"></i> Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm hover:shadow-md transition-all">
                    <i class="fas fa-save"></i> Update Kategori
                </button>
            </div>
        </form>
    </div>
@endsection
