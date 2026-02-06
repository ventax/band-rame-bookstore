@extends('admin.layouts.app')

@section('title', 'Edit Kategori - Admin Panel')
@section('page-title', 'Edit Kategori')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Nama Kategori -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori *</label>
                        <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="Contoh: Fiksi, Non-Fiksi, Komik">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="description" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="Deskripsi singkat tentang kategori ini...">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gambar Saat Ini -->
                    @if ($category->image)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                            <div class="flex items-center space-x-4">
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                    class="w-32 h-32 object-cover rounded-lg border-2 border-gray-200">
                                <div class="text-sm text-gray-600">
                                    <p class="font-medium">{{ basename($category->image) }}</p>
                                    <p class="text-xs mt-1">Upload gambar baru untuk menggantinya</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Upload Gambar Baru -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            {{ $category->image ? 'Ganti Gambar' : 'Upload Gambar' }}
                        </label>
                        <input type="file" name="image" accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF. Maksimal 2MB</p>
                        @error('image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Info Buku -->
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-500 text-lg mr-3 mt-0.5"></i>
                            <div class="text-sm text-blue-700">
                                <p class="font-semibold mb-1">Kategori ini memiliki {{ $category->books_count }} buku</p>
                                <p class="text-xs">Mengubah nama kategori tidak akan mempengaruhi buku yang sudah ada</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('admin.categories.index') }}" class="btn-secondary">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save mr-2"></i>Update Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
