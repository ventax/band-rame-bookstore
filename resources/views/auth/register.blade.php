<x-guest-layout>
    {{-- Heading --}}
    <div class="mb-6">
        <h2 class="text-2xl font-extrabold text-gray-900 mb-1">Buat Akun Baru</h2>
        <p class="text-gray-500 text-sm">Bergabung dengan ribuan pembaca di ATigaBookStore</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4" novalidate>
        @csrf

        {{-- Name --}}
        <div>
            <div class="field-wrap">
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                    class="@error('name') is-error @elseif(old('name')) is-valid @endif"
                    placeholder=" " required autocomplete="name" oninput="validateName(this)">
                <label class="field-label" for="name">Nama Lengkap</label>
                <i class="fas fa-user field-icon-l"></i>
                <span class="field-icon-r" id="name-check" style="pointer-events:none;"></span>
            </div>
            @error('name')
                <p class="err-msg"><i class="fas fa-circle-exclamation text-xs"></i> {{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <div class="field-wrap">
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    class="@error('email') is-error @elseif(old('email')) is-valid @endif"
                    placeholder=" " required autocomplete="username" oninput="validateEmail(this)">
                <label class="field-label" for="email">Alamat Email</label>
                <i class="fas fa-envelope field-icon-l"></i>
                <span class="field-icon-r" id="email-check" style="pointer-events:none;"></span>
            </div>
            @error('email')
                <p class="err-msg"><i class="fas fa-circle-exclamation text-xs"></i> {{ $message }}</p>
            @enderror
        </div>

        {{-- Birth Date (17+) --}}
        <div>
            <div class="field-wrap">
                <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date') }}"
                    max="{{ now()->subYears(17)->toDateString() }}"
                    class="@error('birth_date') is-error @elseif(old('birth_date')) is-valid @endif"
                    placeholder=" " required autocomplete="bday">
                <label class="field-label" for="birth_date">Tanggal Lahir</label>
                <i class="fas fa-cake-candles field-icon-l"></i>
            </div>
            <p class="text-xs text-gray-400 mt-1">Minimal usia 17 tahun.</p>
            @error('birth_date')
                <p class="err-msg"><i class="fas fa-circle-exclamation text-xs"></i> {{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <div class="field-wrap">
                <input id="password" type="password" name="password"
                    class="@error('password') is-error @endif"
                    placeholder=" " required autocomplete="new-password" oninput="checkStrength(this); checkMatch();">
                <label class="field-label" for="password">Password</label>
                <i class="fas fa-lock field-icon-l"></i>
                <button type="button" class="field-icon-r" onclick="togglePwd('password', this)" title="Tampilkan">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            {{-- Strength bar --}}
            <div class="strength-bar mt-1.5">
                <div class="seg" id="seg1"></div>
                <div class="seg" id="seg2"></div>
                <div class="seg" id="seg3"></div>
                <div class="seg" id="seg4"></div>
            </div>
            <p class="strength-hint text-gray-400" id="strength-text">Masukkan password</p>
            @error('password')
                <p class="err-msg"><i class="fas fa-circle-exclamation text-xs"></i> {{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <div class="field-wrap">
                <input id="password_confirmation" type="password" name="password_confirmation"
                    class="@error('password_confirmation') is-error @endif"
                    placeholder=" " required autocomplete="new-password" oninput="checkMatch()">
                <label class="field-label" for="password_confirmation">Konfirmasi Password</label>
                <i class="fas fa-lock field-icon-l"></i>
                <button type="button" class="field-icon-r" onclick="togglePwd('password_confirmation', this)" title="Tampilkan">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            <p class="match-hint text-gray-400" id="match-text"></p>
            @error('password_confirmation')
                <p class="err-msg"><i class="fas fa-circle-exclamation text-xs"></i> {{ $message }}</p>
            @enderror
        </div>

        {{-- Terms --}}
        <p class="text-xs
                    text-gray-400 leading-relaxed">
                Dengan mendaftar, Anda menyetujui <span class="text-blue-600 font-medium">Syarat &amp; Ketentuan</span>
                serta <span class="text-blue-600 font-medium">Kebijakan Privasi</span> ATigaBookStore.
                </p>

                {{-- Submit --}}
                <button type="submit" class="btn-auth">
                    <i class="fas fa-user-plus"></i>
                    <span class="btn-text">Buat Akun</span>
                </button>

                {{-- Divider --}}
                <div class="auth-divider">
                    <span class="text-xs text-gray-400 whitespace-nowrap px-1">Sudah punya akun?</span>
                </div>

                {{-- Login link --}}
                <a href="{{ route('login') }}"
                    class="flex items-center justify-center w-full py-2.5 px-4 border-2 border-blue-600 text-blue-600 rounded-xl text-sm font-semibold hover:bg-blue-600 hover:text-white transition-all duration-200">
                    <i class="fas fa-arrow-left mr-2 text-xs"></i> Masuk ke Akun
                </a>
    </form>

    <script>
        /* ── Name validation ── */
        function validateName(inp) {
            const el = document.getElementById('name-check');
            if (inp.value.trim().length >= 2) {
                inp.classList.add('is-valid');
                inp.classList.remove('is-error');
                el.innerHTML = '<i class="fas fa-circle-check" style="color:#16a34a;"></i>';
            } else {
                inp.classList.remove('is-valid');
                el.innerHTML = '';
            }
        }

        /* ── Email validation ── */
        function validateEmail(inp) {
            const el = document.getElementById('email-check');
            const valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(inp.value);
            if (valid) {
                inp.classList.add('is-valid');
                inp.classList.remove('is-error');
                el.innerHTML = '<i class="fas fa-circle-check" style="color:#16a34a;"></i>';
            } else {
                inp.classList.remove('is-valid');
                el.innerHTML = '';
            }
        }

        /* ── Password strength ── */
        function checkStrength(inp) {
            const val = inp.value;
            const segs = ['seg1', 'seg2', 'seg3', 'seg4'].map(id => document.getElementById(id));
            const txt = document.getElementById('strength-text');
            segs.forEach(s => s.className = 'seg');
            if (!val) {
                txt.textContent = 'Masukkan password';
                txt.style.color = '#94a3b8';
                return;
            }

            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const levels = [{
                    cls: 'w',
                    label: 'Lemah',
                    color: '#ef4444'
                },
                {
                    cls: 'f',
                    label: 'Cukup',
                    color: '#f97316'
                },
                {
                    cls: 'g',
                    label: 'Baik',
                    color: '#eab308'
                },
                {
                    cls: 's',
                    label: 'Kuat',
                    color: '#22c55e'
                },
            ];
            const level = levels[score - 1] || levels[0];
            for (let i = 0; i < score; i++) segs[i].classList.add(level.cls);
            txt.textContent = level.label;
            txt.style.color = level.color;
        }

        /* ── Password match ── */
        function checkMatch() {
            const pw = document.getElementById('password').value;
            const cf = document.getElementById('password_confirmation').value;
            const el = document.getElementById('match-text');
            const cfInp = document.getElementById('password_confirmation');
            if (!cf) {
                el.textContent = '';
                cfInp.classList.remove('is-valid', 'is-error');
                return;
            }
            if (pw === cf) {
                el.innerHTML = '<i class="fas fa-circle-check"></i> Password cocok';
                el.style.color = '#16a34a';
                cfInp.classList.add('is-valid');
                cfInp.classList.remove('is-error');
            } else {
                el.innerHTML = '<i class="fas fa-circle-xmark"></i> Password tidak cocok';
                el.style.color = '#dc2626';
                cfInp.classList.add('is-error');
                cfInp.classList.remove('is-valid');
            }
        }

        /* Run on old() values if any */
        (function() {
            const nameInp = document.getElementById('name');
            const emailInp = document.getElementById('email');
            if (nameInp && nameInp.value) validateName(nameInp);
            if (emailInp && emailInp.value) validateEmail(emailInp);
        })();
    </script>
</x-guest-layout>
