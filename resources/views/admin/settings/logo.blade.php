@extends('admin.layouts.app')

@section('title', 'Pengaturan Website - Admin Panel')
@section('page-title', 'Pengaturan Website')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">

        {{-- Flash messages --}}
        @if (session('success'))
            <div
                class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 rounded-2xl px-5 py-4 text-sm font-medium shadow-sm">
                <i class="fas fa-circle-check text-green-500 text-base flex-shrink-0"></i>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div
                class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 rounded-2xl px-5 py-4 text-sm font-medium shadow-sm">
                <i class="fas fa-circle-exclamation text-red-500 text-base flex-shrink-0"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- ═══════════════════════════════
         1. NAMA WEBSITE
    ═══════════════════════════════ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-globe text-blue-600 text-sm"></i>
                </div>
                <div>
                    <h2 class="text-base font-bold text-gray-800">Nama Website</h2>
                    <p class="text-xs text-gray-400">Tampil di tab browser dan seluruh halaman</p>
                </div>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('admin.settings.site-name.update') }}">
                    @csrf
                    <div class="flex gap-3">
                        <div class="flex-1">
                            <input type="text" name="site_name" value="{{ old('site_name', $siteName) }}"
                                class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm font-semibold text-gray-800 focus:outline-none focus:border-blue-500 transition-colors"
                                placeholder="Nama website Anda" maxlength="60">
                            @error('site_name')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                    <i class="fas fa-circle-exclamation"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <button type="submit"
                            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition-all whitespace-nowrap flex items-center gap-2">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        Nama ini akan mengubah <code class="bg-gray-100 px-1.5 py-0.5 rounded font-mono">APP_NAME</code> di
                        file <code class="bg-gray-100 px-1.5 py-0.5 rounded font-mono">.env</code> secara otomatis.
                    </p>
                </form>
            </div>
        </div>

        {{-- ═══════════════════════════════
         2. LOGO
    ═══════════════════════════════ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-9 h-9 bg-violet-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-image text-violet-600 text-sm"></i>
                </div>
                <div>
                    <h2 class="text-base font-bold text-gray-800">Logo Website</h2>
                    <p class="text-xs text-gray-400">Tampil di header dan footer semua halaman</p>
                </div>
                @if ($logoPath)
                    <span
                        class="ml-auto text-xs bg-green-100 text-green-700 font-semibold px-2.5 py-1 rounded-full flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Aktif
                    </span>
                @else
                    <span
                        class="ml-auto text-xs bg-gray-100 text-gray-500 font-semibold px-2.5 py-1 rounded-full">Default</span>
                @endif
            </div>

            <div class="p-6">
                {{-- Preview row --}}
                <div class="flex items-center gap-5 mb-5 p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="flex-shrink-0">
                        @if ($logoPath)
                            <img src="{{ $logoPath }}" alt="Logo" id="logoCurrentImg"
                                class="h-16 w-auto object-contain rounded-lg border border-gray-200 bg-white p-1.5 shadow-sm">
                        @else
                            <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center shadow-sm">
                                <i class="fas fa-book-open text-white text-2xl"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        @if ($logoPath)
                            <p class="text-sm font-semibold text-gray-700 mb-0.5">Logo kustom aktif</p>
                            <p class="text-xs text-gray-400">Logo ini tampil di navbar dan footer website</p>
                            <form method="POST" action="{{ route('admin.settings.logo.delete') }}" class="mt-2"
                                onsubmit="return confirm('Hapus logo ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="text-xs text-red-500 hover:text-red-700 font-semibold flex items-center gap-1 transition-colors">
                                    <i class="fas fa-trash-alt"></i> Hapus Logo
                                </button>
                            </form>
                        @else
                            <p class="text-sm font-semibold text-gray-700 mb-0.5">Menggunakan ikon default</p>
                            <p class="text-xs text-gray-400">Upload logo kustom untuk mengganti ikon default</p>
                        @endif
                    </div>
                </div>

                {{-- Upload form --}}
                <form method="POST" action="{{ route('admin.settings.logo.upload') }}" enctype="multipart/form-data"
                    id="logoForm">
                    @csrf
                    <div id="logoDropZone"
                        class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50/50 transition-all"
                        onclick="document.getElementById('logoInput').click()">
                        <div id="logoDropContent">
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-300 mb-2"></i>
                            <p class="text-sm font-semibold text-gray-500">Klik atau seret file gambar ke sini</p>
                            <p class="text-xs text-gray-400 mt-1">PNG, JPG, SVG, WEBP &bull; Maks 2 MB &bull; Disarankan
                                transparan (PNG)</p>
                        </div>
                        <div id="logoPreviewWrap" class="hidden flex-col items-center gap-2">
                            <img id="logoPreviewImg" src="#" alt="Preview"
                                class="h-20 object-contain rounded-lg border border-gray-200 p-1 shadow-sm bg-white">
                            <p id="logoPreviewName" class="text-xs font-semibold text-gray-600"></p>
                            <span class="text-xs text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full font-semibold"><i
                                    class="fas fa-redo mr-1"></i>Klik untuk ganti</span>
                        </div>
                    </div>
                    <input type="file" name="logo" id="logoInput" class="hidden" accept="image/*">
                    @error('logo')
                        <p class="err-p"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                    <div class="flex justify-end mt-4">
                        <button type="submit" id="logoSubmitBtn" disabled
                            class="px-5 py-2.5 text-sm font-bold rounded-xl transition-all flex items-center gap-2 bg-gray-100 text-gray-400 cursor-not-allowed"
                            id="logoSubmitBtn">
                            <i class="fas fa-save"></i> Simpan Logo
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ═══════════════════════════════
         3. FAVICON
    ═══════════════════════════════ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-9 h-9 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-star text-orange-500 text-sm"></i>
                </div>
                <div>
                    <h2 class="text-base font-bold text-gray-800">Favicon</h2>
                    <p class="text-xs text-gray-400">Ikon kecil yang tampil di tab browser</p>
                </div>
                @if ($faviconPath)
                    <span
                        class="ml-auto text-xs bg-green-100 text-green-700 font-semibold px-2.5 py-1 rounded-full flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Aktif
                    </span>
                @else
                    <span
                        class="ml-auto text-xs bg-gray-100 text-gray-500 font-semibold px-2.5 py-1 rounded-full">Default</span>
                @endif
            </div>

            <div class="p-6">
                {{-- Preview row --}}
                <div class="flex items-center gap-5 mb-5 p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="flex-shrink-0 relative">
                        {{-- Simulated browser tab --}}
                        <div
                            class="bg-gray-200 rounded-t-lg px-3 py-1.5 flex items-center gap-2 w-36 border border-gray-300 border-b-0">
                            @if ($faviconPath)
                                <img src="{{ $faviconPath }}" class="w-4 h-4 object-contain rounded-sm" alt="favicon">
                            @else
                                <img src="{{ asset('favicon.ico') }}" class="w-4 h-4 object-contain rounded-sm"
                                    alt="favicon">
                            @endif
                            <span class="text-xs text-gray-600 truncate font-medium">{{ $siteName }}</span>
                        </div>
                        <div class="bg-white border border-gray-300 rounded-b-lg rounded-tr-lg h-5 w-full"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        @if ($faviconPath)
                            <p class="text-sm font-semibold text-gray-700 mb-0.5">Favicon kustom aktif</p>
                            <p class="text-xs text-gray-400">Tampil di tab browser di seluruh halaman</p>
                            <form method="POST" action="{{ route('admin.settings.favicon.delete') }}" class="mt-2"
                                onsubmit="return confirm('Hapus favicon ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="text-xs text-red-500 hover:text-red-700 font-semibold flex items-center gap-1 transition-colors">
                                    <i class="fas fa-trash-alt"></i> Hapus Favicon
                                </button>
                            </form>
                        @else
                            <p class="text-sm font-semibold text-gray-700 mb-0.5">Menggunakan favicon default</p>
                            <p class="text-xs text-gray-400">Upload favicon kustom (gunakan PNG 32×32 atau 64×64)</p>
                        @endif
                    </div>
                </div>

                {{-- Upload form --}}
                <form method="POST" action="{{ route('admin.settings.favicon.upload') }}" enctype="multipart/form-data"
                    id="faviconForm">
                    @csrf
                    <div id="faviconDropZone"
                        class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center cursor-pointer hover:border-orange-400 hover:bg-orange-50/50 transition-all"
                        onclick="document.getElementById('faviconInput').click()">
                        <div id="faviconDropContent">
                            <i class="fas fa-star text-3xl text-gray-300 mb-2"></i>
                            <p class="text-sm font-semibold text-gray-500">Klik atau seret file gambar ke sini</p>
                            <p class="text-xs text-gray-400 mt-1">PNG, ICO, WEBP &bull; Maks 1 MB &bull; Disarankan 64×64
                                px</p>
                        </div>
                        <div id="faviconPreviewWrap" class="hidden flex-col items-center gap-2">
                            <img id="faviconPreviewImg" src="#" alt="Preview"
                                class="h-16 w-16 object-contain rounded-lg border border-gray-200 p-1 shadow-sm bg-white">
                            <p id="faviconPreviewName" class="text-xs font-semibold text-gray-600"></p>
                            <span class="text-xs text-orange-600 bg-orange-50 px-2.5 py-1 rounded-full font-semibold"><i
                                    class="fas fa-redo mr-1"></i>Klik untuk ganti</span>
                        </div>
                    </div>
                    <input type="file" name="favicon" id="faviconInput" class="hidden" accept="image/*">
                    @error('favicon')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                            <i class="fas fa-circle-exclamation"></i> {{ $message }}
                        </p>
                    @enderror
                    <div class="flex justify-end mt-4">
                        <button type="submit" id="faviconSubmitBtn" disabled
                            class="px-5 py-2.5 text-sm font-bold rounded-xl transition-all flex items-center gap-2 bg-gray-100 text-gray-400 cursor-not-allowed">
                            <i class="fas fa-save"></i> Simpan Favicon
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        /* ── Generic setup for a dropzone ── */
        function initDropzone({
            dropZoneId,
            dropContentId,
            previewWrapId,
            previewImgId,
            previewNameId,
            inputId,
            submitBtnId,
            activeColor
        }) {
            const dropZone = document.getElementById(dropZoneId);
            const dropContent = document.getElementById(dropContentId);
            const prevWrap = document.getElementById(previewWrapId);
            const prevImg = document.getElementById(previewImgId);
            const prevName = document.getElementById(previewNameId);
            const input = document.getElementById(inputId);
            const submitBtn = document.getElementById(submitBtnId);

            function applyFile(file) {
                if (!file || !file.type.startsWith('image/')) return;
                const reader = new FileReader();
                reader.onload = e => {
                    prevImg.src = e.target.result;
                    prevName.textContent = file.name;
                    dropContent.classList.add('hidden');
                    prevWrap.classList.remove('hidden');
                    prevWrap.classList.add('flex');
                    submitBtn.disabled = false;
                    submitBtn.className =
                        `px-5 py-2.5 text-sm font-bold rounded-xl transition-all flex items-center gap-2 ${activeColor} text-white cursor-pointer hover:-translate-y-0.5 shadow-md`;
                };
                reader.readAsDataURL(file);
            }

            input.addEventListener('change', () => {
                if (input.files[0]) applyFile(input.files[0]);
            });

            dropZone.addEventListener('dragover', e => {
                e.preventDefault();
                dropZone.classList.add('ring-2');
            });
            dropZone.addEventListener('dragleave', () => dropZone.classList.remove('ring-2'));
            dropZone.addEventListener('drop', e => {
                e.preventDefault();
                dropZone.classList.remove('ring-2');
                const file = e.dataTransfer.files[0];
                if (file) {
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    input.files = dt.files;
                    applyFile(file);
                }
            });
        }

        initDropzone({
            dropZoneId: 'logoDropZone',
            dropContentId: 'logoDropContent',
            previewWrapId: 'logoPreviewWrap',
            previewImgId: 'logoPreviewImg',
            previewNameId: 'logoPreviewName',
            inputId: 'logoInput',
            submitBtnId: 'logoSubmitBtn',
            activeColor: 'bg-blue-600 hover:bg-blue-700',
        });

        initDropzone({
            dropZoneId: 'faviconDropZone',
            dropContentId: 'faviconDropContent',
            previewWrapId: 'faviconPreviewWrap',
            previewImgId: 'faviconPreviewImg',
            previewNameId: 'faviconPreviewName',
            inputId: 'faviconInput',
            submitBtnId: 'faviconSubmitBtn',
            activeColor: 'bg-orange-500 hover:bg-orange-600',
        });
    </script>
@endpush
