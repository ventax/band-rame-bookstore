@extends('admin.layouts.app')

@section('title', 'Pengaturan Logo - Admin Panel')
@section('page-title', 'Pengaturan Logo')

@section('content')
    <div class="max-w-3xl mx-auto">

        {{-- Current Logo Card --}}
        <div class="bg-white rounded-2xl shadow-md overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center space-x-3">
                <div class="w-9 h-9 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-image text-indigo-600"></i>
                </div>
                <h2 class="text-lg font-bold text-gray-800">Logo Saat Ini</h2>
            </div>

            <div class="p-6 flex flex-col items-center">
                @if ($logoPath)
                    <img src="{{ $logoPath }}" alt="Logo Website" id="currentLogoImg"
                        class="max-h-32 object-contain mb-4 rounded-xl border border-gray-200 p-2 shadow-sm">
                    <p class="text-sm text-gray-500 mb-4">Logo kustom sedang aktif di semua halaman website.</p>

                    {{-- Delete Form --}}
                    <form method="POST" action="{{ route('admin.settings.logo.delete') }}"
                        onsubmit="return confirm('Hapus logo kustom? Website akan kembali menggunakan logo default.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 font-semibold rounded-xl transition text-sm">
                            <i class="fas fa-trash-alt mr-2"></i> Hapus Logo
                        </button>
                    </form>
                @else
                    {{-- Default Logo Preview --}}
                    <div class="bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 p-4 rounded-2xl shadow-fun mb-4">
                        <i class="fas fa-book-reader text-4xl text-white"></i>
                    </div>
                    <p class="text-sm text-gray-500">Belum ada logo kustom. Website menggunakan logo default (ikon).</p>
                @endif
            </div>
        </div>

        {{-- Upload Form Card --}}
        <div class="bg-white rounded-2xl shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center space-x-3">
                <div class="w-9 h-9 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-upload text-green-600"></i>
                </div>
                <h2 class="text-lg font-bold text-gray-800">Upload Logo Baru</h2>
            </div>

            <div class="p-6">
                <form method="POST" action="{{ route('admin.settings.logo.upload') }}" enctype="multipart/form-data"
                    id="logoUploadForm">
                    @csrf

                    {{-- Drop Zone --}}
                    <div id="dropZone"
                        class="border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center cursor-pointer hover:border-indigo-400 hover:bg-indigo-50 transition-all mb-4"
                        onclick="document.getElementById('logoInput').click()">
                        <div id="dropZoneContent">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                            <p class="text-gray-600 font-semibold mb-1">Klik atau seret file gambar ke sini</p>
                            <p class="text-sm text-gray-400">PNG, JPG, JPEG, SVG, WEBP &bull; Maksimal 2 MB</p>
                        </div>
                        <div id="previewContainer" class="hidden flex-col items-center space-y-2">
                            <img id="previewImg" src="#" alt="Preview"
                                class="max-h-32 object-contain rounded-xl border border-gray-200 p-1 shadow-sm">
                            <p id="previewName" class="text-sm text-gray-600 font-medium"></p>
                            <p class="text-xs text-indigo-500">Klik untuk ganti file</p>
                        </div>
                    </div>

                    <input type="file" name="logo" id="logoInput" class="hidden" accept="image/*">

                    @error('logo')
                        <div
                            class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i> {{ $message }}
                        </div>
                    @enderror

                    <div class="bg-blue-50 rounded-xl px-4 py-3 mb-5 text-sm text-blue-700 flex items-start space-x-2">
                        <i class="fas fa-info-circle mt-0.5 flex-shrink-0"></i>
                        <span>Logo yang diupload akan tampil di navbar website dan sidebar admin panel. Gunakan gambar
                            dengan latar transparan (PNG) untuk hasil terbaik. Rasio yang disarankan: <strong>1:1</strong>
                            atau <strong>landscape</strong>.</span>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" id="submitBtn" disabled
                            class="inline-flex items-center px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 disabled:opacity-40 disabled:cursor-not-allowed text-white font-bold rounded-xl transition text-sm shadow-md">
                            <i class="fas fa-save mr-2"></i> Simpan Logo
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        const input = document.getElementById('logoInput');
        const submitBtn = document.getElementById('submitBtn');
        const dropZoneContent = document.getElementById('dropZoneContent');
        const previewContainer = document.getElementById('previewContainer');
        const previewImg = document.getElementById('previewImg');
        const previewName = document.getElementById('previewName');

        input.addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewName.textContent = file.name;
                dropZoneContent.classList.add('hidden');
                previewContainer.classList.remove('hidden');
                previewContainer.classList.add('flex');
                submitBtn.disabled = false;
            };
            reader.readAsDataURL(file);
        });

        // Drag & drop support
        const dropZone = document.getElementById('dropZone');
        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('border-indigo-500', 'bg-indigo-50');
        });
        dropZone.addEventListener('dragleave', function() {
            this.classList.remove('border-indigo-500', 'bg-indigo-50');
        });
        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-indigo-500', 'bg-indigo-50');
            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                // Transfer file to input
                const dt = new DataTransfer();
                dt.items.add(file);
                input.files = dt.files;
                input.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endpush
