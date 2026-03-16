@extends('layouts.app')

@section('title', 'Lengkapi Profil - ' . config('app.name'))

@section('content')
    <style>
        :root {
            --blue: #2563eb;
            --blue2: #1d4ed8;
            --orange: #f97316;
            --ora-lt: #fb923c;
        }

        .setup-page {
            min-height: 100vh;
            background: linear-gradient(150deg, #eff6ff 0%, #f8fafc 50%, #fff7ed 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .setup-wrap {
            width: 100%;
            max-width: 600px;
        }

        /* ── Top brand strip ── */
        .setup-brand {
            text-align: center;
            margin-bottom: 1.75rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .setup-brand-logo {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--blue), var(--orange));
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(37, 99, 235, .2);
        }

        .setup-brand-name {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 1.3rem;
            background: linear-gradient(135deg, var(--blue), var(--orange));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* ── Progress steps ── */
        .steps-bar {
            display: flex;
            align-items: center;
            gap: 0;
            margin-bottom: 1.75rem;
        }

        .step-item {
            flex: 1;
            display: flex;
            align-items: center;
        }

        .step-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: .8rem;
            flex-shrink: 0;
            position: relative;
            z-index: 1;
            transition: all .3s;
        }

        .step-circle.done {
            background: linear-gradient(135deg, var(--blue), var(--blue2));
            color: #fff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, .3);
        }

        .step-circle.active {
            background: linear-gradient(135deg, var(--orange), var(--ora-lt));
            color: #fff;
            box-shadow: 0 4px 12px rgba(249, 115, 22, .3);
        }

        .step-circle.todo {
            background: #e2e8f0;
            color: #94a3b8;
        }

        .step-line {
            flex: 1;
            height: 3px;
            background: #e2e8f0;
            margin: 0 -2px;
        }

        .step-line.done {
            background: linear-gradient(90deg, var(--blue), var(--blue2));
        }

        .step-label {
            font-size: .68rem;
            font-weight: 700;
            margin-top: 4px;
            color: #94a3b8;
            text-align: center;
        }

        .step-label.active {
            color: var(--orange);
        }

        .step-label.done {
            color: var(--blue);
        }

        .step-col {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* ── Card ── */
        .setup-card {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(37, 99, 235, .1), 0 4px 20px rgba(0, 0, 0, .06);
            border: 1px solid rgba(37, 99, 235, .08);
            overflow: hidden;
        }

        .setup-card-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 60%, #2563eb 100%);
            padding: 1.75rem 2rem;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .header-avatar {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            flex-shrink: 0;
            background: linear-gradient(135deg, #3b82f6, var(--orange));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 1.4rem;
            color: #fff;
            border: 3px solid rgba(255, 255, 255, .3);
        }

        .header-text h2 {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 1.15rem;
            color: #fff;
            line-height: 1.2;
        }

        .header-text p {
            font-size: .82rem;
            color: rgba(255, 255, 255, .7);
            margin-top: 3px;
        }

        .setup-card-body {
            padding: 2rem;
        }

        /* ── Progress bar ── */
        .progress-bar-wrap {
            margin-bottom: 1.75rem;
        }

        .progress-bar-bg {
            height: 6px;
            background: #e2e8f0;
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--blue), var(--orange));
            border-radius: 3px;
            transition: width .5s ease;
        }

        .progress-bar-label {
            display: flex;
            justify-content: space-between;
            margin-top: 6px;
            font-size: .72rem;
            font-weight: 700;
        }

        /* ── Form ── */
        .f-group {
            margin-bottom: 1.25rem;
        }

        .f-label {
            display: block;
            font-size: .75rem;
            font-weight: 700;
            color: #475569;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .f-required {
            color: var(--orange);
        }

        .f-input,
        .f-select {
            width: 100%;
            padding: .8rem 1rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            font-size: .92rem;
            font-family: 'Nunito', sans-serif;
            color: #1e293b;
            background: #f8fafc;
            outline: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }

        .f-input:focus,
        .f-select:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
            background: #fff;
        }

        .f-input.readonly {
            background: #f1f5f9;
            color: #64748b;
            cursor: not-allowed;
        }

        .f-hint {
            font-size: .73rem;
            color: #94a3b8;
            margin-top: 4px;
        }

        .f-err {
            font-size: .76rem;
            color: #ef4444;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ── Gender cards ── */
        .gender-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .75rem;
        }

        .gender-card {
            position: relative;
        }

        .gender-card input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .gender-card label {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: .85rem 1rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            cursor: pointer;
            transition: all .2s;
            background: #f8fafc;
        }

        .gender-card input:checked+label {
            border-color: var(--blue);
            background: #eff6ff;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
        }

        .gender-card label .g-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .gender-card label .g-icon.male {
            background: #dbeafe;
            color: #2563eb;
        }

        .gender-card label .g-icon.female {
            background: #fce7f3;
            color: #db2777;
        }

        .gender-card label .g-text strong {
            display: block;
            font-size: .88rem;
            font-weight: 700;
            color: #1e293b;
        }

        .gender-card label .g-text span {
            font-size: .72rem;
            color: #94a3b8;
        }

        .gender-card input:checked+label .g-text strong {
            color: var(--blue);
        }

        /* ── Buttons ── */
        .btn-primary {
            background: linear-gradient(135deg, var(--blue), var(--blue2));
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: .85rem 2rem;
            font-size: .95rem;
            font-weight: 800;
            font-family: 'Nunito', sans-serif;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(37, 99, 235, .3);
            transition: all .2s;
            position: relative;
            overflow: hidden;
            width: 100%;
            justify-content: center;
        }

        .btn-primary:hover {
            box-shadow: 0 6px 20px rgba(37, 99, 235, .4);
            filter: brightness(1.06);
        }

        .btn-primary::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(249, 115, 22, .25), transparent);
            transition: left .5s ease;
        }

        .btn-primary:hover::after {
            left: 160%;
        }

        .skip-link {
            display: block;
            text-align: center;
            margin-top: 1rem;
            font-size: .82rem;
            color: #94a3b8;
            font-weight: 600;
            text-decoration: none;
            transition: color .2s;
        }

        .skip-link:hover {
            color: #64748b;
        }

        /* ── Info box ── */
        .info-box {
            background: #f0f9ff;
            border: 1.5px solid #bae6fd;
            border-radius: 12px;
            padding: .85rem 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            gap: 10px;
            font-size: .82rem;
            color: #0369a1;
        }

        .info-box i {
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* ── Completion dots ── */
        .completion-row {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        .c-dot {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 100px;
            font-size: .72rem;
            font-weight: 700;
        }

        .c-dot.filled {
            background: #dcfce7;
            color: #166534;
        }

        .c-dot.empty {
            background: #fef3c7;
            color: #92400e;
        }

        /* ── Responsive ── */
        @media (max-width: 1024px) {
            .setup-wrap {
                max-width: 680px;
            }
        }

        @media (max-width: 768px) {
            .setup-page {
                align-items: flex-start;
                padding: 1rem 0.75rem 5.75rem;
            }

            .setup-brand {
                margin-bottom: 1rem;
            }

            .setup-brand-logo {
                width: 48px;
                height: 48px;
                border-radius: 14px;
            }

            .setup-brand-name {
                font-size: 1.08rem;
            }

            .setup-card {
                border-radius: 18px;
            }

            .setup-card-header {
                padding: 1.1rem 1rem;
                gap: 10px;
            }

            .header-avatar {
                width: 44px;
                height: 44px;
                font-size: 1.1rem;
            }

            .header-text h2 {
                font-size: 1rem;
            }

            .header-text p {
                font-size: 0.74rem;
                line-height: 1.35;
            }

            .setup-card-body {
                padding: 1rem;
            }

            .progress-bar-wrap {
                margin-bottom: 1rem;
            }

            .info-box {
                margin-bottom: 1rem;
                padding: 0.72rem 0.82rem;
                font-size: 0.76rem;
            }

            .f-group {
                margin-bottom: 0.92rem;
            }

            .f-input,
            .f-select {
                font-size: 0.88rem;
                padding: 0.72rem 0.9rem;
                border-radius: 10px;
            }

            .gender-grid {
                gap: 0.58rem;
            }

            .gender-card label {
                padding: 0.68rem 0.72rem;
                gap: 8px;
                min-height: 72px;
            }

            .gender-card label .g-icon {
                width: 30px;
                height: 30px;
                border-radius: 8px;
                font-size: 0.86rem;
                flex-shrink: 0;
            }

            .gender-card label .g-text strong {
                font-size: 0.83rem;
                line-height: 1.2;
            }

            .gender-card label .g-text span {
                font-size: 0.68rem;
            }

            .btn-primary {
                padding: 0.78rem 1rem;
                font-size: 0.9rem;
            }

            .skip-link {
                margin-top: 0.78rem;
            }
        }

        @media (max-width: 420px) {
            .setup-page {
                padding: 0.85rem 0.55rem 5.75rem;
            }

            .setup-card-body {
                padding: 0.84rem;
            }

            .step-circle {
                width: 30px;
                height: 30px;
                font-size: 0.72rem;
            }

            .step-line {
                margin-top: 15px !important;
            }

            .step-label {
                font-size: 0.62rem;
            }

            .gender-grid {
                grid-template-columns: 1fr;
            }

            .gender-card label {
                min-height: 56px;
            }

            .completion-row {
                gap: 4px;
            }

            .c-dot {
                font-size: 0.65rem;
                padding: 3px 8px;
            }
        }
    </style>

    <div class="setup-page">
        <div class="setup-wrap">

            {{-- Brand --}}
            <div class="setup-brand">
                <div class="setup-brand-logo">
                    <i class="fas fa-book-open" style="color:#fff;font-size:1.4rem;"></i>
                </div>
                <span class="setup-brand-name">{{ config('app.name') }}</span>
            </div>

            {{-- Steps indicator --}}
            <div style="display:flex;align-items:flex-start;gap:0;margin-bottom:1.75rem;">
                <div style="flex:1;display:flex;flex-direction:column;align-items:center;">
                    <div class="step-circle done"><i class="fas fa-check" style="font-size:.75rem;"></i></div>
                    <span class="step-label done">Daftar</span>
                </div>
                <div class="step-line done" style="margin-top:18px;"></div>
                <div style="flex:1;display:flex;flex-direction:column;align-items:center;">
                    <div class="step-circle active">2</div>
                    <span class="step-label active">Profil</span>
                </div>
                <div class="step-line" style="margin-top:18px;"></div>
                <div style="flex:1;display:flex;flex-direction:column;align-items:center;">
                    <div class="step-circle todo">3</div>
                    <span class="step-label">Selesai</span>
                </div>
            </div>

            {{-- Main Card --}}
            <div class="setup-card">
                {{-- Header --}}
                <div class="setup-card-header">
                    <div class="header-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    <div class="header-text">
                        <h2>Halo, {{ explode(' ', $user->name)[0] }}! 👋</h2>
                        <p>Satu langkah lagi — lengkapi data diri Anda</p>
                    </div>
                </div>

                <div class="setup-card-body">

                    {{-- Progress --}}
                    @php
                        $fields = collect([
                            'Nama' => !empty($user->name),
                            'Email' => !empty($user->email),
                            'Foto' => !empty($user->avatar),
                            'Telepon' => !empty($user->phone),
                            'Tgl Lahir' => !empty($user->birth_date),
                            'Kelamin' => !empty($user->gender),
                        ]);
                        $filled = $fields->filter()->count();
                        $pct = round(($filled / $fields->count()) * 100);
                    @endphp
                    <div class="progress-bar-wrap">
                        <div class="progress-bar-bg">
                            <div class="progress-bar-fill" style="width:{{ $pct }}%;"></div>
                        </div>
                        <div class="progress-bar-label">
                            <span style="color:#64748b;">Kelengkapan profil</span>
                            <span style="color:var(--blue);">{{ $pct }}%</span>
                        </div>
                        <div class="completion-row">
                            @foreach ($fields as $label => $done)
                                <span class="c-dot {{ $done ? 'filled' : 'empty' }}">
                                    <i class="fas fa-{{ $done ? 'circle-check' : 'circle' }}" style="font-size:.65rem;"></i>
                                    {{ $label }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="info-box">
                        <i class="fas fa-circle-info"></i>
                        <span>Data ini digunakan untuk mempercepat proses checkout dan memberikan pengalaman belanja yang
                            lebih personal. Anda dapat mengubahnya kapan saja.</span>
                    </div>

                    {{-- Form --}}
                    <form method="POST" action="{{ route('profile.setup.store') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- Foto Profil --}}
                        <div x-data="{ preview: '' }" class="f-group"
                            style="text-align:center;padding:1.25rem;background:#f8fafc;border:2px dashed #bfdbfe;border-radius:16px;cursor:pointer;"
                            onclick="document.getElementById('avatar_inp').click()">
                            <div style="position:relative;display:inline-block;">
                                <div
                                    style="width:88px;height:88px;border-radius:50%;overflow:hidden;background:linear-gradient(135deg,var(--blue),var(--orange));display:flex;align-items:center;justify-content:center;margin:0 auto;border:3px solid #fff;box-shadow:0 4px 16px rgba(37,99,235,.2);">
                                    <template x-if="preview">
                                        <img :src="preview" style="width:100%;height:100%;object-fit:cover;">
                                    </template>
                                    <template x-if="!preview">
                                        <span
                                            style="font-family:'Poppins',sans-serif;font-weight:800;font-size:2rem;color:#fff;">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </template>
                                </div>
                                <div
                                    style="position:absolute;bottom:0;right:0;width:26px;height:26px;background:var(--orange);border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid #fff;">
                                    <i class="fas fa-camera" style="font-size:.6rem;color:#fff;"></i>
                                </div>
                            </div>
                            <p style="font-size:.8rem;color:var(--blue);font-weight:700;margin-top:.75rem;">Klik untuk pilih
                                foto profil</p>
                            <p style="font-size:.71rem;color:#94a3b8;margin-top:2px;">JPG, PNG, WEBP · Maks. 2MB · Opsional
                            </p>
                            <input type="file" name="avatar" id="avatar_inp" accept="image/*" class="hidden"
                                @change.stop="preview = URL.createObjectURL($event.target.files[0])">
                            @error('avatar')
                                <div class="f-err" style="justify-content:center;"><i class="fas fa-triangle-exclamation"></i>
                                    {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Read-only: Nama & Email --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                            <div class="f-group" style="margin-bottom:0;">
                                <label class="f-label">Nama</label>
                                <input type="text" class="f-input readonly" value="{{ $user->name }}" readonly>
                            </div>
                            <div class="f-group" style="margin-bottom:0;">
                                <label class="f-label">Email</label>
                                <input type="email" class="f-input readonly" value="{{ $user->email }}" readonly>
                            </div>
                        </div>

                        <p
                            style="font-size:.73rem;color:#94a3b8;margin-bottom:1.25rem;display:flex;align-items:center;gap:4px;">
                            <i class="fas fa-lock" style="font-size:.65rem;"></i>
                            Nama & email diisi saat pendaftaran. Ubah di halaman Profil.
                        </p>

                        {{-- Telepon --}}
                        <div class="f-group">
                            <label class="f-label" for="phone">Nomor Telepon / WhatsApp</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                                class="f-input" placeholder="08xxxxxxxxxx">
                            <p class="f-hint"><i class="fas fa-whatsapp"></i> Untuk notifikasi pesanan via WhatsApp</p>
                            @error('phone')
                                <div class="f-err"><i class="fas fa-triangle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="f-group">
                            <label class="f-label" for="birth_date">Tanggal Lahir</label>
                            @if ($user->birth_date)
                                <input type="text" id="birth_date" class="f-input readonly"
                                    value="{{ $user->birth_date->translatedFormat('d F Y') }}" readonly>
                                <p class="f-hint"><i class="fas fa-circle-check" style="color:#22c55e;"></i>
                                    Tanggal lahir sudah terisi saat pendaftaran.</p>
                            @else
                                <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}"
                                    max="{{ now()->subYears(17)->toDateString() }}" class="f-input">
                                <p class="f-hint"><i class="fas fa-gift"></i> Minimal usia 17 tahun.</p>
                            @endif
                            @error('birth_date')
                                <div class="f-err"><i class="fas fa-triangle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div class="f-group">
                            <label class="f-label">Jenis Kelamin</label>
                            <div class="gender-grid">
                                <div class="gender-card">
                                    <input type="radio" name="gender" id="g_male" value="male"
                                        {{ old('gender', $user->gender) === 'male' ? 'checked' : '' }}>
                                    <label for="g_male">
                                        <div class="g-icon male"><i class="fas fa-mars"></i></div>
                                        <div class="g-text">
                                            <strong>Laki-laki</strong>
                                            <span>Male</span>
                                        </div>
                                    </label>
                                </div>
                                <div class="gender-card">
                                    <input type="radio" name="gender" id="g_female" value="female"
                                        {{ old('gender', $user->gender) === 'female' ? 'checked' : '' }}>
                                    <label for="g_female">
                                        <div class="g-icon female"><i class="fas fa-venus"></i></div>
                                        <div class="g-text">
                                            <strong>Perempuan</strong>
                                            <span>Female</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            @error('gender')
                                <div class="f-err mt-2"><i class="fas fa-triangle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-floppy-disk"></i> Simpan & Mulai Belanja
                        </button>

                        <a href="{{ route('dashboard') }}" class="skip-link">
                            <i class="fas fa-forward" style="font-size:.7rem;"></i> Lewati, isi nanti
                        </a>
                    </form>
                </div>
            </div>

            {{-- Footer note --}}
            <p style="text-align:center;font-size:.75rem;color:#94a3b8;margin-top:1.25rem;">
                <i class="fas fa-shield-check" style="color:#22c55e;"></i>
                Data Anda aman dan tidak dibagikan kepada pihak ketiga.
            </p>
        </div>
    </div>
@endsection
