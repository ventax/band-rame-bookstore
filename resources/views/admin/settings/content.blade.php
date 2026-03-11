@extends('admin.layouts.app')

@section('title', 'Konten Website - Admin Panel')
@section('page-title', 'Manajemen Konten Website')

@section('content')
    @php
        $groups = [
            'hero' => ['icon' => 'fas fa-star', 'color' => 'blue', 'label' => 'Hero / Banner Utama'],
            'features' => ['icon' => 'fas fa-th-large', 'color' => 'violet', 'label' => 'Fitur Unggulan'],
            'cta' => ['icon' => 'fas fa-bullhorn', 'color' => 'orange', 'label' => 'CTA (Ajakan)'],
            'store' => ['icon' => 'fas fa-store', 'color' => 'green', 'label' => 'Info Toko'],
            'social' => ['icon' => 'fas fa-share-alt', 'color' => 'pink', 'label' => 'Sosial Media & Footer'],
        ];

        $colorMap = [
            'blue' => [
                'bg' => 'bg-blue-100',
                'text' => 'text-blue-600',
                'border' => 'border-blue-500',
                'active' => 'bg-blue-600 text-white',
                'hover' => 'hover:bg-blue-50',
            ],
            'violet' => [
                'bg' => 'bg-violet-100',
                'text' => 'text-violet-600',
                'border' => 'border-violet-500',
                'active' => 'bg-violet-600 text-white',
                'hover' => 'hover:bg-violet-50',
            ],
            'orange' => [
                'bg' => 'bg-orange-100',
                'text' => 'text-orange-600',
                'border' => 'border-orange-500',
                'active' => 'bg-orange-600 text-white',
                'hover' => 'hover:bg-orange-50',
            ],
            'green' => [
                'bg' => 'bg-green-100',
                'text' => 'text-green-600',
                'border' => 'border-green-500',
                'active' => 'bg-green-600 text-white',
                'hover' => 'hover:bg-green-50',
            ],
            'pink' => [
                'bg' => 'bg-pink-100',
                'text' => 'text-pink-600',
                'border' => 'border-pink-500',
                'active' => 'bg-pink-600 text-white',
                'hover' => 'hover:bg-pink-50',
            ],
        ];
    @endphp

    {{-- Flash messages --}}
    @if (session('success'))
        <div
            class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 rounded-2xl px-4 py-3.5 text-sm font-medium shadow-sm mb-5">
            <i class="fas fa-circle-check text-green-500 text-base flex-shrink-0"></i>
            {{ session('success') }}
        </div>
    @endif

    @php
        $activeMeta = $groups[$activeGroup];
        $activeColor = $colorMap[$activeMeta['color']];
    @endphp

    {{-- ── Mobile: horizontal scrollable tab pills ── --}}
    <div class="sm:hidden -mx-4 px-4 mb-4 overflow-x-auto">
        <div class="flex gap-2 w-max pb-1">
            @foreach ($groups as $groupKey => $meta)
                @php $c = $colorMap[$meta['color']]; @endphp
                <a href="{{ route('admin.settings.content', $groupKey) }}"
                    class="flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all border
                    {{ $activeGroup === $groupKey
                        ? $c['active'] . ' border-transparent shadow-md'
                        : 'bg-white text-gray-600 border-gray-200 hover:border-gray-300' }}">
                    <i class="{{ $meta['icon'] }} {{ $activeGroup === $groupKey ? 'text-white' : $c['text'] }}"></i>
                    {{ $meta['label'] }}
                </a>
            @endforeach
            <a href="{{ route('admin.settings.logo') }}"
                class="flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap bg-white text-gray-600 border border-gray-200 hover:border-gray-300 transition-all">
                <i class="fas fa-image text-gray-500"></i> Logo & Favicon
            </a>
        </div>
    </div>

    {{-- ── Main layout (sidebar + form) ── --}}
    <div class="flex flex-col sm:flex-row gap-5">

        {{-- ─── Desktop Sidebar ─────────────────────── --}}
        <div class="hidden sm:flex sm:flex-col sm:w-56 lg:w-60 flex-shrink-0 gap-1.5">
            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest px-2 mb-1">Pilih Bagian</p>
            @foreach ($groups as $groupKey => $meta)
                @php $c = $colorMap[$meta['color']]; @endphp
                <a href="{{ route('admin.settings.content', $groupKey) }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition-all border-2
                    {{ $activeGroup === $groupKey
                        ? $c['active'] . ' border-transparent shadow-md'
                        : 'bg-white text-gray-700 border-gray-100 ' . $c['hover'] . ' hover:border-gray-200' }}">
                    <div
                        class="w-7 h-7 flex items-center justify-center rounded-lg flex-shrink-0
                        {{ $activeGroup === $groupKey ? 'bg-white/20' : $c['bg'] }}">
                        <i
                            class="{{ $meta['icon'] }} text-sm {{ $activeGroup === $groupKey ? 'text-white' : $c['text'] }}"></i>
                    </div>
                    <span class="flex-1 leading-snug">{{ $meta['label'] }}</span>
                    @if ($activeGroup === $groupKey)
                        <i class="fas fa-chevron-right text-xs opacity-70"></i>
                    @endif
                </a>
            @endforeach

            <div class="mt-2 pt-3 border-t border-gray-200">
                <a href="{{ route('admin.settings.logo') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm bg-white text-gray-700 border-2 border-gray-100 hover:bg-gray-50 hover:border-gray-200 transition-all">
                    <div class="w-7 h-7 flex items-center justify-center rounded-lg bg-gray-100 flex-shrink-0">
                        <i class="fas fa-image text-sm text-gray-500"></i>
                    </div>
                    <span class="flex-1">Logo & Favicon</span>
                    <i class="fas fa-external-link-alt text-xs text-gray-400"></i>
                </a>
            </div>
        </div>

        {{-- ─── Form Konten ──────────────────────────── --}}
        <div class="flex-1 min-w-0">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                {{-- Card Header --}}
                <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div
                        class="w-10 h-10 {{ $activeColor['bg'] }} rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="{{ $activeMeta['icon'] }} {{ $activeColor['text'] }} text-base"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-base font-bold text-gray-800 leading-tight">{{ $activeMeta['label'] }}</h2>
                        <p class="text-xs text-gray-400 mt-0.5 hidden sm:block">Perubahan langsung tampil di website setelah
                            disimpan</p>
                    </div>
                    <a href="{{ url('/') }}" target="_blank"
                        class="flex-shrink-0 inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-all">
                        <i class="fas fa-external-link-alt"></i>
                        <span class="hidden sm:inline">Lihat Website</span>
                    </a>
                </div>

                {{-- Form --}}
                <form method="POST" action="{{ route('admin.settings.content.update', $activeGroup) }}"
                    class="p-5 space-y-4">
                    @csrf

                    @foreach ($settings as $setting)
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                {{ $setting->label }}
                                <span
                                    class="ml-1.5 text-[10px] text-gray-400 font-normal font-mono bg-gray-100 px-1.5 py-0.5 rounded">{{ $setting->key }}</span>
                            </label>

                            @if ($setting->type === 'textarea')
                                <textarea name="{{ $setting->key }}" rows="3"
                                    class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all resize-none">{{ old($setting->key, $setting->value) }}</textarea>
                            @else
                                <input type="{{ $setting->type }}" name="{{ $setting->key }}"
                                    value="{{ old($setting->key, $setting->value) }}"
                                    class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all">
                            @endif
                        </div>
                    @endforeach

                    {{-- Context tips --}}
                    @if ($activeGroup === 'hero')
                        <div class="flex gap-3 bg-blue-50 border border-blue-100 rounded-xl p-4 text-sm text-blue-700">
                            <i class="fas fa-info-circle mt-0.5 flex-shrink-0"></i>
                            <span><strong>Tip:</strong> Judul terdiri dari 3 baris. Baris ke-2 ditampilkan dengan warna
                                gradient.</span>
                        </div>
                    @elseif ($activeGroup === 'social')
                        <div
                            class="flex gap-3 bg-orange-50 border border-orange-100 rounded-xl p-4 text-sm text-orange-700">
                            <i class="fas fa-info-circle mt-0.5 flex-shrink-0"></i>
                            <span>Isi URL lengkap termasuk <code class="bg-orange-100 px-1 rounded">https://</code>, atau
                                isi <code class="bg-orange-100 px-1 rounded">#</code> jika belum ada.</span>
                        </div>
                    @endif

                    {{-- Footer actions --}}
                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <p class="text-xs text-gray-400 hidden sm:block">
                            <i class="fas fa-clock mr-1"></i> Terakhir diubah: {{ now()->format('d M Y') }}
                        </p>
                        <button type="submit"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-bold rounded-xl transition-all shadow-sm hover:shadow-md">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
