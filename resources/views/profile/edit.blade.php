@extends('layouts.app')

@section('title', 'Profil Saya - ' . config('app.name'))

@section('content')

    {{-- ═══════════════ STYLES ═══════════════ --}}
    <style>
        /* ── Palette vars ── */
        :root {
            --p-blue: #2563eb;
            --p-blue2: #1d4ed8;
            --p-orange: #f97316;
            --p-ora-lt: #fb923c;
        }

        /* ── Page bg ── */
        .prof-page {
            background: linear-gradient(150deg, #eff6ff 0%, #f8fafc 55%, #fff7ed 100%);
            min-height: 100vh;
            padding: 2.5rem 0 4rem;
        }

        /* ── Avatar ring ── */
        .avatar-ring {
            background: linear-gradient(135deg, var(--p-blue), var(--p-orange));
            padding: 3px;
            border-radius: 9999px;
            display: inline-block;
        }

        .avatar-inner {
            width: 80px;
            height: 80px;
            border-radius: 9999px;
            background: linear-gradient(135deg, var(--p-blue), #3b82f6, var(--p-orange));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 2rem;
            color: #fff;
            border: 3px solid #fff;
        }

        /* ── Stat chip ── */
        .stat-chip {
            background: rgba(255, 255, 255, .7);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(37, 99, 235, .12);
            border-radius: 14px;
            padding: .6rem 1.1rem;
            text-align: center;
        }

        .stat-val {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 1.25rem;
            color: var(--p-blue);
            line-height: 1;
        }

        .stat-lbl {
            font-size: .7rem;
            color: #64748b;
            font-weight: 600;
            margin-top: 2px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        /* ── Tab buttons ── */
        .tab-wrap {
            background: #fff;
            border-radius: 18px;
            padding: .4rem;
            box-shadow: 0 2px 12px rgba(37, 99, 235, .08);
            border: 1px solid rgba(37, 99, 235, .08);
            display: flex;
            flex-wrap: wrap;
            gap: .4rem;
        }

        .tab-btn {
            flex: 1;
            min-width: max-content;
            padding: .65rem 1.25rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: .85rem;
            border: none;
            cursor: pointer;
            transition: all .2s;
            background: transparent;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .tab-btn:hover:not(.tab-active) {
            background: #f0f6ff;
            color: var(--p-blue);
        }

        .tab-active {
            background: linear-gradient(135deg, var(--p-blue), var(--p-blue2));
            color: #fff !important;
            box-shadow: 0 4px 14px rgba(37, 99, 235, .3);
        }

        .tab-danger.tab-active {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            box-shadow: 0 4px 14px rgba(220, 38, 38, .3);
        }

        /* ── Content card ── */
        .prof-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 24px rgba(37, 99, 235, .07);
            border: 1px solid rgba(37, 99, 235, .07);
            padding: 2rem;
        }

        /* ── Section title ── */
        .sec-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 1.15rem;
            color: #1e3a8a;
            margin-bottom: 1.5rem;
            padding-bottom: .75rem;
            border-bottom: 2px solid #eff6ff;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sec-title i {
            color: var(--p-blue);
            font-size: .95rem;
        }

        /* ── Form label ── */
        .f-label {
            display: block;
            font-size: .78rem;
            font-weight: 700;
            color: #475569;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .f-required {
            color: var(--p-orange);
        }

        /* ── Inputs ── */
        .f-input,
        .f-select,
        .f-textarea {
            width: 100%;
            padding: .72rem 1rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 11px;
            font-size: .9rem;
            font-family: 'Nunito', sans-serif;
            color: #1e293b;
            background: #f8fafc;
            transition: border-color .2s, box-shadow .2s, background .2s;
            outline: none;
        }

        .f-input:focus,
        .f-select:focus,
        .f-textarea:focus {
            border-color: var(--p-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
            background: #fff;
        }

        .f-input.has-err {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, .1);
        }

        .f-err {
            font-size: .76rem;
            color: #ef4444;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ── Primary btn ── */
        .btn-primary {
            background: linear-gradient(135deg, var(--p-blue) 0%, var(--p-blue2) 100%);
            color: #fff;
            border: none;
            border-radius: 11px;
            padding: .72rem 1.75rem;
            font-size: .9rem;
            font-weight: 800;
            font-family: 'Nunito', sans-serif;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: box-shadow .2s, filter .2s, transform .1s;
            box-shadow: 0 4px 14px rgba(37, 99, 235, .3);
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover {
            box-shadow: 0 6px 20px rgba(37, 99, 235, .4);
            filter: brightness(1.06);
        }

        .btn-primary:active {
            transform: scale(.98);
        }

        /* orange accent shine */
        .btn-primary::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(249, 115, 22, .2), transparent);
            transition: left .45s ease;
        }

        .btn-primary:hover::after {
            left: 160%;
        }

        /* ── Outline btn ── */
        .btn-outline {
            background: #fff;
            color: var(--p-blue);
            border: 1.5px solid var(--p-blue);
            border-radius: 11px;
            padding: .68rem 1.25rem;
            font-size: .85rem;
            font-weight: 700;
            font-family: 'Nunito', sans-serif;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all .2s;
        }

        .btn-outline:hover {
            background: #eff6ff;
        }

        .btn-outline-orange {
            border-color: var(--p-orange);
            color: var(--p-orange);
        }

        .btn-outline-orange:hover {
            background: #fff7ed;
        }

        .btn-outline-red {
            border-color: #ef4444;
            color: #ef4444;
        }

        .btn-outline-red:hover {
            background: #fef2f2;
        }

        /* ── Danger btn ── */
        .btn-danger {
            background: #dc2626;
            color: #fff;
            border: none;
            border-radius: 11px;
            padding: .72rem 1.75rem;
            font-size: .9rem;
            font-weight: 800;
            font-family: 'Nunito', sans-serif;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .2s;
            box-shadow: 0 4px 14px rgba(220, 38, 38, .2);
        }

        .btn-danger:hover {
            background: #b91c1c;
            box-shadow: 0 6px 18px rgba(220, 38, 38, .3);
        }

        /* ── Address card ── */
        .addr-card {
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
            transition: border-color .2s, box-shadow .2s;
            position: relative;
        }

        .addr-card:hover {
            border-color: #bfdbfe;
            box-shadow: 0 4px 16px rgba(37, 99, 235, .08);
        }

        .addr-card.is-default {
            border-color: #93c5fd;
            background: linear-gradient(135deg, #eff6ff, #fff);
        }

        /* ── Default badge ── */
        .default-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: linear-gradient(135deg, var(--p-blue), var(--p-blue2));
            color: #fff;
            font-size: .68rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 100px;
            letter-spacing: .3px;
        }

        /* ── Modal ── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, .55);
            backdrop-filter: blur(4px);
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .modal-box {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, .2);
            max-width: 680px;
            width: 100%;
            padding: 2rem;
            max-height: 90vh;
            overflow-y: auto;
            animation: modalIn .25s cubic-bezier(.22, .68, 0, 1.2) both;
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: scale(.95) translateY(12px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #eff6ff;
        }

        .modal-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 1.1rem;
            color: #1e3a8a;
        }

        .modal-close {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: none;
            background: #f1f5f9;
            color: #64748b;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .9rem;
            transition: all .2s;
        }

        .modal-close:hover {
            background: #fee2e2;
            color: #ef4444;
        }

        /* ── Alert toast ── */
        .toast {
            border-radius: 12px;
            padding: .9rem 1.1rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: .88rem;
            font-weight: 600;
        }

        .toast.ok {
            background: #f0fdf4;
            border: 1.5px solid #86efac;
            color: #166534;
        }

        .toast.err {
            background: #fef2f2;
            border: 1.5px solid #fca5a5;
            color: #991b1b;
        }

        .toast i {
            margin-top: 1px;
            flex-shrink: 0;
        }

        /* ── Password strength ── */
        .str-bars {
            display: flex;
            gap: 4px;
            margin-top: 8px;
        }

        .str-bar {
            height: 4px;
            flex: 1;
            border-radius: 2px;
            background: #e2e8f0;
            transition: background .3s;
        }

        .str-bar.weak {
            background: #ef4444;
        }

        .str-bar.fair {
            background: #f97316;
        }

        .str-bar.good {
            background: #eab308;
        }

        .str-bar.strong {
            background: #22c55e;
        }

        /* ── Empty state ── */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            background: #eff6ff;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
        }

        .empty-icon i {
            font-size: 2rem;
            color: #93c5fd;
        }
    </style>

    <div class="prof-page">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">

            {{-- ═══════ PROFILE HEADER CARD ═══════ --}}
            <div class="prof-card mb-6"
                style="background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 60%, #2563eb 100%); color: #fff;">
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">

                    {{-- Avatar --}}
                    <div class="avatar-ring flex-shrink-0" style="border: none;">
                        @if ($user->avatar)
                            <div class="avatar-inner" style="padding:0;overflow:hidden;">
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Foto Profil"
                                    style="width:100%;height:100%;object-fit:cover;border-radius:9999px;">
                            </div>
                        @else
                            <div class="avatar-inner">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 text-center sm:text-left">
                        <h1
                            style="font-family:'Poppins',sans-serif;font-weight:800;font-size:1.6rem;line-height:1.2;color:#fff;">
                            {{ $user->name }}
                        </h1>
                        <p style="color:rgba(255,255,255,.75);font-size:.88rem;margin-top:3px;">{{ $user->email }}</p>
                        <div style="display:flex;flex-wrap:wrap;gap:6px;margin-top:.75rem;justify-content:center;"
                            class="sm:justify-start">
                            <span
                                style="background:rgba(249,115,22,.2);border:1px solid rgba(249,115,22,.4);color:#fed7aa;border-radius:100px;padding:2px 12px;font-size:.72rem;font-weight:700;letter-spacing:.5px;display:inline-flex;align-items:center;gap:4px;">
                                <i class="fas fa-user-check" style="font-size:.65rem;"></i> Member
                            </span>
                            <span
                                style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);color:rgba(255,255,255,.8);border-radius:100px;padding:2px 12px;font-size:.72rem;font-weight:600;display:inline-flex;align-items:center;gap:4px;">
                                <i class="fas fa-calendar" style="font-size:.65rem;"></i>
                                Bergabung {{ $user->created_at->translatedFormat('M Y') }}
                            </span>
                            @if ($user->gender)
                                <span
                                    style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);color:rgba(255,255,255,.8);border-radius:100px;padding:2px 12px;font-size:.72rem;font-weight:600;display:inline-flex;align-items:center;gap:4px;">
                                    <i class="fas fa-{{ $user->gender === 'male' ? 'mars' : 'venus' }}"
                                        style="font-size:.65rem;"></i>
                                    {{ $user->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Stats --}}
                    <div class="flex gap-3 flex-shrink-0">
                        <div class="stat-chip">
                            <div class="stat-val" style="color:#60a5fa;">{{ $addresses->count() }}</div>
                            <div class="stat-lbl" style="color:rgba(255,255,255,.6);">Alamat</div>
                        </div>
                        <div class="stat-chip">
                            <div class="stat-val" style="color:#fb923c;">
                                {{ (int) $user->created_at->diffInDays(now()) }}
                            </div>
                            <div class="stat-lbl" style="color:rgba(255,255,255,.6);">Hari</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══════ FLASH MESSAGES ═══════ --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" class="toast ok mb-5">
                    <i class="fas fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" class="toast err mb-5">
                    <i class="fas fa-circle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- ═══════ BANNER LENGKAPI PROFIL ═══════ --}}
            @if (!$user->phone || !$user->birth_date || !$user->gender)
                <div
                    style="background:linear-gradient(135deg,#fff7ed,#fffbeb);border:1.5px solid #fed7aa;border-radius:16px;padding:1rem 1.25rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:12px;">
                    <div
                        style="width:42px;height:42px;border-radius:12px;background:linear-gradient(135deg,var(--p-orange),var(--p-ora-lt));display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-id-card" style="color:#fff;font-size:1rem;"></i>
                    </div>
                    <div style="flex:1;">
                        <p style="font-weight:800;color:#92400e;font-size:.9rem;font-family:'Poppins',sans-serif;">Lengkapi
                            data profil Anda</p>
                        <p style="font-size:.8rem;color:#b45309;margin-top:2px;">
                            Isi
                            @php
                                $missing = collect([
                                    'Nomor Telepon' => !$user->phone,
                                    'Tanggal Lahir' => !$user->birth_date,
                                    'Jenis Kelamin' => !$user->gender,
                                ])
                                    ->filter()
                                    ->keys();
                            @endphp
                            {{ $missing->join(', ', ', dan ') }}
                            untuk melengkapi akun Anda.
                        </p>
                    </div>
                    <div
                        style="display:flex;align-items:center;gap:4px;background:linear-gradient(135deg,var(--p-orange),var(--p-ora-lt));border-radius:100px;padding:3px 7px;">
                        @php
                            $total = 5;
                            $filled = collect([
                                $user->name,
                                $user->email,
                                $user->phone,
                                $user->birth_date,
                                $user->gender,
                            ])
                                ->filter()
                                ->count();
                        @endphp
                        <span
                            style="font-size:.72rem;font-weight:800;color:#fff;">{{ round(($filled / $total) * 100) }}%</span>
                    </div>
                </div>
            @endif

            {{-- ═══════ TABS + CONTENT ═══════ --}}
            <div x-data="{ activeTab: '{{ $errors->any() && $errors->has('current_password') ? 'password' : session('tab', 'profile') }}', showAddressModal: false, editAddressId: null, showDeleteAccountModal: false }">

                {{-- Tab Buttons --}}
                <div class="tab-wrap mb-5">
                    <button @click="activeTab='profile'" :class="activeTab === 'profile' ? 'tab-active' : ''"
                        class="tab-btn">
                        <i class="fas fa-user"></i> Informasi Profil
                    </button>
                    <button @click="activeTab='addresses'" :class="activeTab === 'addresses' ? 'tab-active' : ''"
                        class="tab-btn">
                        <i class="fas fa-map-marker-alt"></i>
                        Alamat
                        <span
                            style="background:rgba(37,99,235,.12);color:var(--p-blue);border-radius:100px;font-size:.7rem;padding:1px 7px;font-weight:800;">{{ $addresses->count() }}</span>
                    </button>
                    <button @click="activeTab='password'" :class="activeTab === 'password' ? 'tab-active' : ''"
                        class="tab-btn">
                        <i class="fas fa-lock"></i> Ubah Password
                    </button>
                    <button @click="activeTab='delete'" :class="activeTab === 'delete' ? 'tab-active tab-danger' : ''"
                        class="tab-btn tab-danger" style="color:#dc2626;">
                        <i class="fas fa-trash-alt"></i> Hapus Akun
                    </button>
                </div>

                {{-- ─── TAB: PROFIL ─── --}}
                <div x-show="activeTab==='profile'" x-transition class="prof-card">
                    <p class="sec-title"><i class="fas fa-user"></i>Informasi Profil</p>

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf @method('PATCH')

                        {{-- Foto Profil --}}
                        <div x-data="{ preview: '{{ $user->avatar ? asset('storage/' . $user->avatar) : '' }}' }" class="mb-6 pb-6" style="border-bottom:2px solid #eff6ff;">
                            <label class="f-label">Foto Profil <span
                                    style="color:#94a3b8;font-weight:500;">(opsional)</span></label>
                            <div style="display:flex;align-items:center;gap:1.25rem;margin-top:.5rem;">
                                {{-- Preview --}}
                                <div
                                    style="width:72px;height:72px;border-radius:50%;overflow:hidden;flex-shrink:0;background:linear-gradient(135deg,var(--p-blue),var(--p-orange));display:flex;align-items:center;justify-content:center;border:3px solid #bfdbfe;">
                                    <template x-if="preview">
                                        <img :src="preview" style="width:100%;height:100%;object-fit:cover;">
                                    </template>
                                    <template x-if="!preview">
                                        <span
                                            style="font-family:'Poppins',sans-serif;font-weight:800;font-size:1.6rem;color:#fff;">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </template>
                                </div>
                                {{-- Upload area --}}
                                <div style="flex:1;">
                                    <label for="avatar_edit"
                                        style="display:inline-flex;align-items:center;gap:6px;background:var(--p-blue);color:#fff;border-radius:10px;padding:.55rem 1.1rem;font-size:.82rem;font-weight:700;cursor:pointer;transition:all .2s;">
                                        <i class="fas fa-camera"></i> Ganti Foto
                                    </label>
                                    <input type="file" name="avatar" id="avatar_edit" accept="image/*"
                                        class="hidden" @change="preview = URL.createObjectURL($event.target.files[0])">
                                    <p style="font-size:.73rem;color:#94a3b8;margin-top:6px;">JPG, PNG, WEBP · Maks. 2MB
                                    </p>
                                    @error('avatar')
                                        <div class="f-err"><i class="fas fa-triangle-exclamation"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            {{-- Nama --}}
                            <div>
                                <label class="f-label" for="name">Nama Lengkap <span
                                        class="f-required">*</span></label>
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', $user->name) }}" required placeholder="Nama lengkap Anda"
                                    class="f-input {{ $errors->has('name') ? 'has-err' : '' }}">
                                @error('name')
                                    <div class="f-err"><i class="fas fa-triangle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="f-label" for="email">Email <span class="f-required">*</span></label>
                                <input type="email" name="email" id="email"
                                    value="{{ old('email', $user->email) }}" required
                                    class="f-input {{ $errors->has('email') ? 'has-err' : '' }}">
                                @error('email')
                                    <div class="f-err"><i class="fas fa-triangle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Telepon --}}
                            <div>
                                <label class="f-label" for="phone">Nomor Telepon</label>
                                <input type="text" name="phone" id="phone"
                                    value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx"
                                    class="f-input {{ $errors->has('phone') ? 'has-err' : '' }}">
                                @error('phone')
                                    <div class="f-err"><i class="fas fa-triangle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div>
                                <label class="f-label" for="birth_date">Tanggal Lahir</label>
                                <input type="date" name="birth_date" id="birth_date"
                                    value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}"
                                    class="f-input {{ $errors->has('birth_date') ? 'has-err' : '' }}">
                                @error('birth_date')
                                    <div class="f-err"><i class="fas fa-triangle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div>
                                <label class="f-label" for="gender">Jenis Kelamin</label>
                                <select name="gender" id="gender" class="f-select">
                                    <option value="">— Pilih jenis kelamin —</option>
                                    <option value="male"
                                        {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female"
                                        {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                            </div>
                        </div>

                        {{-- Info unverified email --}}
                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                            <div
                                class="mt-4 p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-sm flex items-center gap-2">
                                <i class="fas fa-exclamation-triangle text-amber-500"></i>
                                Email Anda belum diverifikasi.
                                <form method="POST" action="{{ route('verification.send') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="underline font-semibold hover:text-amber-900">Kirim
                                        ulang verifikasi</button>
                                </form>
                            </div>
                        @endif

                        <div class="mt-7 flex justify-end gap-3">
                            <button type="reset" class="btn-outline">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-floppy-disk"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- ─── TAB: ALAMAT ─── --}}
                <div x-show="activeTab==='addresses'" x-transition class="space-y-5">
                    {{-- Header --}}
                    <div class="prof-card" style="padding:1.25rem 1.75rem;">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="sec-title" style="margin-bottom:0;border:none;padding:0;">
                                    <i class="fas fa-map-marker-alt"></i>Alamat Pengiriman
                                </p>
                                <p style="font-size:.82rem;color:#64748b;margin-top:3px;">Kelola alamat pengiriman untuk
                                    checkout yang lebih cepat</p>
                            </div>
                            <button @click="showAddressModal = true" class="btn-primary flex-shrink-0">
                                <i class="fas fa-plus"></i> Tambah Alamat
                            </button>
                        </div>
                    </div>

                    @if ($addresses->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($addresses as $address)
                                <div class="addr-card {{ $address->is_default ? 'is-default' : '' }}">
                                    {{-- Badge utama --}}
                                    @if ($address->is_default)
                                        <div class="default-badge mb-3">
                                            <i class="fas fa-star" style="font-size:.6rem;"></i> Alamat Utama
                                        </div>
                                    @endif

                                    {{-- Label --}}
                                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:.75rem;">
                                        <div
                                            style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#eff6ff,#dbeafe);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                            <i class="fas fa-{{ strtolower($address->label) === 'kantor' ? 'building' : (strtolower($address->label) === 'kos' ? 'house-chimney' : 'home') }}"
                                                style="color:var(--p-blue);font-size:.9rem;"></i>
                                        </div>
                                        <span
                                            style="font-family:'Poppins',sans-serif;font-weight:800;font-size:.95rem;color:#1e3a8a;">{{ $address->label }}</span>
                                    </div>

                                    {{-- Detail --}}
                                    <div style="font-size:.85rem;color:#475569;line-height:1.75;">
                                        <p style="font-weight:700;color:#334155;">{{ $address->recipient_name }}</p>
                                        <p><i class="fas fa-phone" style="width:14px;color:var(--p-blue);"></i>
                                            {{ $address->phone }}</p>
                                        <p class="mt-1"><i class="fas fa-location-dot"
                                                style="width:14px;color:var(--p-orange);"></i>
                                            {{ $address->address }},
                                            {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}
                                        </p>
                                        @if ($address->notes)
                                            <p class="mt-1" style="color:#94a3b8;font-style:italic;font-size:.8rem;">
                                                <i class="fas fa-note-sticky" style="width:14px;"></i>
                                                {{ $address->notes }}
                                            </p>
                                        @endif
                                    </div>

                                    {{-- Actions --}}
                                    <div
                                        style="display:flex;flex-wrap:wrap;gap:6px;margin-top:1rem;padding-top:.75rem;border-top:1px solid #f1f5f9;">
                                        @if (!$address->is_default)
                                            <form method="POST"
                                                action="{{ route('profile.addresses.set-default', $address) }}">
                                                @csrf
                                                <button type="submit" class="btn-outline btn-outline-orange"
                                                    style="font-size:.78rem;padding:.45rem .9rem;">
                                                    <i class="fas fa-star"></i> Jadikan Utama
                                                </button>
                                            </form>
                                        @endif
                                        <button @click="editAddressId = {{ $address->id }}" class="btn-outline"
                                            style="font-size:.78rem;padding:.45rem .9rem;">
                                            <i class="fas fa-pen"></i> Edit
                                        </button>
                                        @if (!$address->is_default)
                                            <form method="POST"
                                                action="{{ route('profile.addresses.destroy', $address) }}"
                                                onsubmit="return confirm('Hapus alamat {{ $address->label }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn-outline btn-outline-red"
                                                    style="font-size:.78rem;padding:.45rem .9rem;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                    {{-- Edit Modal --}}
                                    <div x-show="editAddressId === {{ $address->id }}"
                                        @click.self="editAddressId = null" class="modal-overlay" style="display:none;">
                                        <div class="modal-box">
                                            <div class="modal-header">
                                                <span class="modal-title"><i class="fas fa-pen"
                                                        style="color:var(--p-blue);margin-right:6px;"></i>Edit
                                                    Alamat</span>
                                                <button @click="editAddressId = null" class="modal-close"><i
                                                        class="fas fa-times"></i></button>
                                            </div>
                                            <form method="POST"
                                                action="{{ route('profile.addresses.update', $address) }}">
                                                @csrf @method('PATCH')
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="f-label">Label <span
                                                                class="f-required">*</span></label>
                                                        <input type="text" name="label"
                                                            value="{{ $address->label }}" required class="f-input"
                                                            placeholder="Rumah, Kantor...">
                                                    </div>
                                                    <div>
                                                        <label class="f-label">Nama Penerima <span
                                                                class="f-required">*</span></label>
                                                        <input type="text" name="recipient_name"
                                                            value="{{ $address->recipient_name }}" required
                                                            class="f-input">
                                                    </div>
                                                    <div class="md:col-span-2">
                                                        <label class="f-label">Telepon <span
                                                                class="f-required">*</span></label>
                                                        <input type="text" name="phone"
                                                            value="{{ $address->phone }}" required class="f-input">
                                                    </div>
                                                    <div class="md:col-span-2">
                                                        <label class="f-label">Alamat Lengkap <span
                                                                class="f-required">*</span></label>
                                                        <textarea name="address" rows="3" required class="f-textarea" style="resize:none;">{{ $address->address }}</textarea>
                                                    </div>
                                                    <div>
                                                        <label class="f-label">Kota <span
                                                                class="f-required">*</span></label>
                                                        <input type="text" name="city"
                                                            value="{{ $address->city }}" required class="f-input">
                                                    </div>
                                                    <div>
                                                        <label class="f-label">Provinsi <span
                                                                class="f-required">*</span></label>
                                                        <input type="text" name="province"
                                                            value="{{ $address->province }}" required class="f-input">
                                                    </div>
                                                    <div>
                                                        <label class="f-label">Kode Pos <span
                                                                class="f-required">*</span></label>
                                                        <input type="text" name="postal_code"
                                                            value="{{ $address->postal_code }}" required class="f-input">
                                                    </div>
                                                    <div>
                                                        <label class="f-label">Catatan</label>
                                                        <input type="text" name="notes"
                                                            value="{{ $address->notes }}" class="f-input"
                                                            placeholder="Cth: Dekat indomaret">
                                                    </div>
                                                </div>
                                                <div
                                                    style="margin-top:1.5rem;display:flex;justify-content:flex-end;gap:.75rem;">
                                                    <button type="button" @click="editAddressId = null"
                                                        class="btn-outline">Batal</button>
                                                    <button type="submit" class="btn-primary"><i
                                                            class="fas fa-floppy-disk"></i> Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="prof-card">
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fas fa-map-location-dot"></i></div>
                                <p style="font-family:'Poppins',sans-serif;font-weight:700;color:#1e3a8a;font-size:1rem;">
                                    Belum ada alamat</p>
                                <p style="font-size:.85rem;color:#64748b;margin-top:4px;">Tambahkan alamat pengiriman untuk
                                    mempercepat proses checkout</p>
                                <button @click="showAddressModal = true" class="btn-primary" style="margin-top:1.25rem;">
                                    <i class="fas fa-plus"></i> Tambah Alamat Pertama
                                </button>
                            </div>
                        </div>
                    @endif

                    {{-- Add Address Modal --}}
                    <div x-show="showAddressModal" @click.self="showAddressModal = false" class="modal-overlay"
                        style="display:none;">
                        <div class="modal-box">
                            <div class="modal-header">
                                <span class="modal-title"><i class="fas fa-location-plus"
                                        style="color:var(--p-blue);margin-right:6px;"></i>Tambah Alamat Baru</span>
                                <button @click="showAddressModal = false" class="modal-close"><i
                                        class="fas fa-times"></i></button>
                            </div>
                            <form method="POST" action="{{ route('profile.addresses.store') }}">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="f-label">Label <span class="f-required">*</span></label>
                                        <input type="text" name="label" required class="f-input"
                                            placeholder="Rumah, Kantor, Kos...">
                                    </div>
                                    <div>
                                        <label class="f-label">Nama Penerima <span class="f-required">*</span></label>
                                        <input type="text" name="recipient_name" required class="f-input"
                                            placeholder="Nama lengkap penerima">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="f-label">Telepon <span class="f-required">*</span></label>
                                        <input type="text" name="phone" required class="f-input"
                                            placeholder="08xxxxxxxxxx">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="f-label">Alamat Lengkap <span class="f-required">*</span></label>
                                        <textarea name="address" rows="3" required class="f-textarea" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan"
                                            style="resize:none;"></textarea>
                                    </div>
                                    <div>
                                        <label class="f-label">Kota <span class="f-required">*</span></label>
                                        <input type="text" name="city" required class="f-input">
                                    </div>
                                    <div>
                                        <label class="f-label">Provinsi <span class="f-required">*</span></label>
                                        <input type="text" name="province" required class="f-input">
                                    </div>
                                    <div>
                                        <label class="f-label">Kode Pos <span class="f-required">*</span></label>
                                        <input type="text" name="postal_code" required class="f-input"
                                            placeholder="12345">
                                    </div>
                                    <div>
                                        <label class="f-label">Catatan</label>
                                        <input type="text" name="notes" class="f-input"
                                            placeholder="Cth: Dekat indomaret">
                                    </div>
                                </div>
                                <div style="margin-top:1.5rem;display:flex;justify-content:flex-end;gap:.75rem;">
                                    <button type="button" @click="showAddressModal = false"
                                        class="btn-outline">Batal</button>
                                    <button type="submit" class="btn-primary"><i class="fas fa-floppy-disk"></i> Simpan
                                        Alamat</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- ─── TAB: PASSWORD ─── --}}
                <div x-show="activeTab==='password'" x-transition class="prof-card" style="max-width:520px;">
                    <p class="sec-title"><i class="fas fa-lock"></i>Ubah Password</p>

                    <form method="POST" action="{{ route('profile.password.update') }}" id="pwdForm">
                        @csrf @method('PATCH')

                        <div class="space-y-5">
                            <div>
                                <label class="f-label" for="current_password">Password Saat Ini <span
                                        class="f-required">*</span></label>
                                <div style="position:relative;">
                                    <input type="password" name="current_password" id="current_password" required
                                        class="f-input {{ $errors->has('current_password') ? 'has-err' : '' }}"
                                        placeholder="Masukkan password lama">
                                    <button type="button" onclick="togglePwdField('current_password','tgl1')"
                                        style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94a3b8;">
                                        <i class="fas fa-eye" id="tgl1"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <div class="f-err"><i class="fas fa-triangle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="f-label" for="new_password">Password Baru <span
                                        class="f-required">*</span></label>
                                <div style="position:relative;">
                                    <input type="password" name="password" id="new_password" required
                                        class="f-input {{ $errors->has('password') ? 'has-err' : '' }}"
                                        placeholder="Min. 8 karakter" oninput="checkStrength(this.value)">
                                    <button type="button" onclick="togglePwdField('new_password','tgl2')"
                                        style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94a3b8;">
                                        <i class="fas fa-eye" id="tgl2"></i>
                                    </button>
                                </div>
                                {{-- Strength meter --}}
                                <div class="str-bars" id="strengthBars">
                                    <div class="str-bar" id="sb1"></div>
                                    <div class="str-bar" id="sb2"></div>
                                    <div class="str-bar" id="sb3"></div>
                                    <div class="str-bar" id="sb4"></div>
                                </div>
                                <p id="strengthLabel"
                                    style="font-size:.72rem;color:#94a3b8;margin-top:4px;font-weight:600;"></p>
                                @error('password')
                                    <div class="f-err"><i class="fas fa-triangle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="f-label" for="password_confirmation">Konfirmasi Password <span
                                        class="f-required">*</span></label>
                                <div style="position:relative;">
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        required class="f-input" placeholder="Ulangi password baru"
                                        oninput="checkMatch()">
                                    <button type="button" onclick="togglePwdField('password_confirmation','tgl3')"
                                        style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94a3b8;">
                                        <i class="fas fa-eye" id="tgl3"></i>
                                    </button>
                                </div>
                                <p id="matchLabel" style="font-size:.72rem;margin-top:4px;font-weight:600;"></p>
                            </div>
                        </div>

                        <div style="margin-top:1.75rem;display:flex;justify-content:flex-end;gap:.75rem;">
                            <button type="reset" class="btn-outline">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-key"></i> Ubah Password
                            </button>
                        </div>
                    </form>
                </div>

                {{-- ─── TAB: DELETE ─── --}}
                <div x-show="activeTab==='delete'" x-transition class="prof-card" style="max-width:520px;">
                    <p class="sec-title" style="color:#991b1b;"><i class="fas fa-triangle-exclamation"
                            style="color:#ef4444;"></i>Hapus Akun</p>

                    <div
                        style="background:#fef2f2;border:1.5px solid #fca5a5;border-radius:12px;padding:1rem 1.25rem;margin-bottom:1.5rem;display:flex;gap:10px;">
                        <i class="fas fa-shield-exclamation" style="color:#ef4444;margin-top:2px;flex-shrink:0;"></i>
                        <div>
                            <p style="font-weight:700;color:#991b1b;font-size:.88rem;">Peringatan — tindakan tidak dapat
                                dibatalkan!</p>
                            <p style="color:#b91c1c;font-size:.82rem;margin-top:3px;line-height:1.5;">Semua data akun,
                                riwayat pesanan, alamat, dan wishlist Anda akan dihapus secara permanen.</p>
                        </div>
                    </div>

                    <form id="delete-account-form" method="POST" action="{{ route('profile.destroy') }}">
                        @csrf @method('DELETE')
                        <div>
                            <label class="f-label" for="password_delete">Konfirmasi Password <span
                                    class="f-required">*</span></label>
                            <input type="password" name="password" id="password_delete" required
                                placeholder="Masukkan password Anda"
                                class="f-input {{ $errors->has('password') ? 'has-err' : '' }}">
                            @error('password')
                                <div class="f-err"><i class="fas fa-triangle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>
                        <div style="margin-top:1.5rem;">
                            <button type="button" @click="showDeleteAccountModal = true" class="btn-danger">
                                <i class="fas fa-trash-alt"></i> Hapus Akun Saya
                            </button>
                        </div>
                    </form>

                    <div x-show="showDeleteAccountModal" x-cloak @keydown.escape.window="showDeleteAccountModal = false"
                        @click.self="showDeleteAccountModal = false" class="modal-overlay"
                        style="display:none; z-index:90;">
                        <div class="modal-box" style="max-width:460px; padding:1.4rem; border-radius:16px;">
                            <div style="display:flex; align-items:flex-start; gap:10px; margin-bottom:12px;">
                                <div
                                    style="width:36px; height:36px; border-radius:10px; background:#fee2e2; color:#dc2626; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                    <i class="fas fa-triangle-exclamation"></i>
                                </div>
                                <div>
                                    <p style="font-size:1rem; font-weight:800; color:#991b1b; margin:0;">Hapus akun
                                        permanen?</p>
                                    <p style="font-size:.85rem; color:#7f1d1d; margin:4px 0 0; line-height:1.45;">
                                        Semua data akun Anda akan dihapus permanen dan tidak bisa dikembalikan.
                                    </p>
                                </div>
                            </div>

                            <div
                                style="display:flex; align-items:center; gap:8px; background:#fef2f2; border:1px solid #fecaca; border-radius:10px; padding:8px 10px; margin-bottom:14px;">
                                <i class="fas fa-key" style="color:#ef4444; font-size:12px;"></i>
                                <span style="font-size:.76rem; color:#991b1b; font-weight:700;">Pastikan password sudah
                                    diisi sebelum konfirmasi.</span>
                            </div>

                            <div style="display:flex; justify-content:flex-end; gap:8px;">
                                <button type="button" @click="showDeleteAccountModal = false" class="btn-outline">
                                    Batal
                                </button>
                                <button type="submit" form="delete-account-form" class="btn-danger">
                                    <i class="fas fa-trash-alt"></i> Ya, Hapus Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        /* Toggle password visibility */
        function togglePwdField(fieldId, iconId) {
            const f = document.getElementById(fieldId);
            const i = document.getElementById(iconId);
            if (f.type === 'password') {
                f.type = 'text';
                i.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                f.type = 'password';
                i.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        /* Password strength */
        function checkStrength(val) {
            const bars = ['sb1', 'sb2', 'sb3', 'sb4'];
            const label = document.getElementById('strengthLabel');
            const levels = [{
                    test: v => v.length >= 1,
                    cls: 'weak',
                    txt: 'Sangat lemah',
                    col: '#ef4444'
                },
                {
                    test: v => v.length >= 6,
                    cls: 'fair',
                    txt: 'Lemah',
                    col: '#f97316'
                },
                {
                    test: v => v.length >= 8 && /[0-9]/.test(v),
                    cls: 'good',
                    txt: 'Cukup kuat',
                    col: '#eab308'
                },
                {
                    test: v => v.length >= 10 && /[^a-zA-Z0-9]/.test(v),
                    cls: 'strong',
                    txt: 'Kuat',
                    col: '#22c55e'
                },
            ];
            let score = 0;
            for (const l of levels)
                if (l.test(val)) score++;
            bars.forEach((id, i) => {
                const el = document.getElementById(id);
                el.className = 'str-bar';
                if (i < score) el.classList.add(levels[score - 1].cls);
            });
            label.textContent = val.length ? levels[score - 1]?.txt ?? '' : '';
            label.style.color = val.length ? levels[score - 1]?.col ?? '#94a3b8' : '#94a3b8';
        }

        /* Password match */
        function checkMatch() {
            const p1 = document.getElementById('new_password').value;
            const p2 = document.getElementById('password_confirmation').value;
            const lbl = document.getElementById('matchLabel');
            if (!p2) {
                lbl.textContent = '';
                return;
            }
            if (p1 === p2) {
                lbl.textContent = '✓ Password cocok';
                lbl.style.color = '#22c55e';
            } else {
                lbl.textContent = '✗ Password tidak cocok';
                lbl.style.color = '#ef4444';
            }
        }
    </script>

@endsection
