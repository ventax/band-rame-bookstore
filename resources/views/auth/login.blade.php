<x-guest-layout>
    {{-- Heading --}}
    <div class="mb-7">
        <h2 class="text-2xl font-extrabold text-gray-900 mb-1">Selamat Datang Kembali</h2>
        <p class="text-gray-500 text-sm">Masuk ke akun ATigaBookStore Anda untuk melanjutkan</p>
    </div>

    {{-- Session Status --}}
    @if (session('status'))
        <div
            class="mb-5 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm flex items-center gap-2">
            <i class="fas fa-circle-check text-green-500"></i> {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5" novalidate>
        @csrf

        {{-- Email --}}
        <div>
            <div class="field-wrap">
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    class="@error('email') is-error @elseif(old('email')) is-valid @endif"
                    placeholder=" " required autocomplete="username">
                <label class="field-label" for="email">Alamat Email</label>
                <i class="fas fa-envelope field-icon-l"></i>
                @if (old('email') && !$errors->has('email'))
                    <i class="fas fa-circle-check field-icon-r" style="color:#16a34a;pointer-events:none;"></i>
                @endif
            </div>
            @error('email')
                <p class="err-msg"><i class="fas fa-circle-exclamation text-xs"></i> {{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <div class="field-wrap">
                <input id="password" type="password" name="password"
                    class="@error('password') is-error @endif"
                    placeholder=" " required autocomplete="current-password">
                <label class="field-label" for="password">Password</label>
                <i class="fas fa-lock field-icon-l"></i>
                <button type="button" class="field-icon-r" onclick="togglePwd('password', this)" title="Tampilkan password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @error('password')
                <p class="err-msg"><i class="fas fa-circle-exclamation text-xs"></i> {{ $message }}</p>
            @enderror
            @if (Route::has('password.request')) <div class="flex justify-end mt-1.5">
                    <a href="{{ route('password.request') }}"
                        class="text-xs text-blue-600 hover:text-blue-800 font-semibold transition-colors">Lupa password?</a>
                </div> @endif
        </div>

        {{-- Remember Me --}}
        <label class="flex
                    items-center gap-2.5 cursor-pointer select-none group">
                <div class="relative">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="w-4 h-4 accent-blue-600 cursor-pointer rounded">
                </div>
                <span class="text-sm text-gray-600 group-hover:text-gray-800 transition-colors">Ingat saya selama 30
                    hari</span>
                </label>

                {{-- Submit --}}
                <button type="submit" class="btn-auth mt-1">
                    <i class="fas fa-right-to-bracket"></i>
                    <span class="btn-text">Masuk ke Akun</span>
                </button>

                {{-- Divider --}}
                <div class="auth-divider">
                    <span class="text-xs text-gray-400 whitespace-nowrap px-1">Belum punya akun?</span>
                </div>

                {{-- Register link --}}
                <a href="{{ route('register') }}"
                    class="flex items-center justify-center w-full py-2.5 px-4 border-2 border-blue-600 text-blue-600 rounded-xl text-sm font-semibold hover:bg-blue-600 hover:text-white transition-all duration-200">
                    Daftar Sekarang <i class="fas fa-arrow-right ml-2 text-xs"></i>
                </a>
    </form>
</x-guest-layout>
