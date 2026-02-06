<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- DEBUG -->
            <div class="bg-yellow-100 border border-yellow-400 p-4 rounded mb-4">
                <p class="font-bold">✓ Halaman Profile Berhasil Dimuat!</p>
                <p>User: {{ $user->name }}</p>
                <p>Email: {{ $user->email }}</p>
                <p>Jumlah Alamat: {{ $addresses->count() }}</p>
            </div>

            <!-- Page Header -->
            <div class="mb-8">
                <h1
                    class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                    Profil Saya
                </h1>
                <p class="mt-2 text-gray-600">Kelola informasi profil dan alamat pengiriman Anda</p>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <p class="text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        <p class="text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Profile Information -->
            <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Informasi Profil</h2>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                required
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                            @error('name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                required
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                            @error('email')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Telepon
                            </label>
                            <input type="text" name="phone" id="phone"
                                value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Birth Date -->
                        <div>
                            <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Lahir
                            </label>
                            <input type="date" name="birth_date" id="birth_date"
                                value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                            @error('birth_date')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Kelamin
                            </label>
                            <select name="gender" id="gender"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="female"
                                    {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                            @error('gender')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-medium rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Addresses Section -->
            <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 mb-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Alamat Pengiriman ({{ $addresses->count() }})</h2>
                    <a href="{{ route('profile.edit') }}#add-address"
                        class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-medium rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Alamat
                    </a>
                </div>

                @if ($addresses->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($addresses as $address)
                            <div
                                class="border-2 border-gray-200 rounded-xl p-4 relative hover:border-purple-300 transition-all">
                                @if ($address->is_default)
                                    <span
                                        class="absolute top-2 right-2 px-3 py-1 bg-gradient-to-r from-purple-600 to-pink-600 text-white text-xs font-semibold rounded-full">
                                        Utama
                                    </span>
                                @endif

                                <div class="mb-3">
                                    <h3 class="text-lg font-bold text-gray-800">{{ $address->label }}</h3>
                                    <p class="text-gray-600 font-medium mt-1">{{ $address->recipient_name }}</p>
                                    <p class="text-gray-600">{{ $address->phone }}</p>
                                </div>

                                <div class="mb-3 text-gray-600 text-sm">
                                    <p>{{ $address->address }}</p>
                                    <p>{{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}</p>
                                    @if ($address->notes)
                                        <p class="mt-1 italic">Catatan: {{ $address->notes }}</p>
                                    @endif
                                </div>

                                <div class="flex flex-wrap gap-2">
                                    @if (!$address->is_default)
                                        <form method="POST"
                                            action="{{ route('profile.addresses.set-default', $address) }}"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-1.5 text-xs text-purple-600 border border-purple-600 rounded-lg hover:bg-purple-50 transition-colors">
                                                <i class="fas fa-star mr-1"></i>
                                                Jadikan Utama
                                            </button>
                                        </form>
                                    @endif

                                    <button onclick="alert('Fitur edit dalam pengembangan')"
                                        class="px-3 py-1.5 text-xs text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 transition-colors">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </button>

                                    @if (!$address->is_default)
                                        <form method="POST"
                                            action="{{ route('profile.addresses.destroy', $address) }}" class="inline"
                                            onsubmit="return confirm('Hapus alamat {{ $address->label }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1.5 text-xs text-red-600 border border-red-600 rounded-lg hover:bg-red-50 transition-colors">
                                                <i class="fas fa-trash mr-1"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-map-marker-alt text-6xl text-gray-300 mb-4"></i>
                        <p class="text-gray-600 text-lg">Belum ada alamat tersimpan</p>
                        <p class="text-gray-500 mt-2">Tambahkan alamat pengiriman untuk mempermudah proses checkout</p>
                    </div>
                @endif
            </div>

            <!-- Change Password -->
            <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Ubah Password</h2>
                <form method="POST" action="{{ route('profile.password.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-6 max-w-md">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password Saat Ini <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="current_password" id="current_password" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password Baru <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password" id="password" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                            @error('password')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Minimal 8 karakter</p>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Konfirmasi Password Baru <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-medium rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                            <i class="fas fa-key mr-2"></i>
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- Delete Account -->
            <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8">
                <h2 class="text-2xl font-bold text-red-600 mb-4">Hapus Akun</h2>
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                    <div class="flex">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-3 mt-1"></i>
                        <div>
                            <h3 class="font-semibold text-red-800">Peringatan!</h3>
                            <p class="text-red-700 mt-1">
                                Tindakan ini tidak dapat dibatalkan. Semua data Anda termasuk riwayat pesanan, alamat,
                                dan informasi lainnya akan dihapus permanen.
                            </p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('profile.destroy') }}" class="max-w-md">
                    @csrf
                    @method('DELETE')

                    <div class="mb-6">
                        <label for="password_delete" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password" id="password_delete" required
                            placeholder="Masukkan password Anda untuk konfirmasi"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all">
                        @error('password')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        onclick="return confirm('Apakah Anda benar-benar yakin ingin menghapus akun?')"
                        class="px-8 py-3 bg-red-600 text-white font-medium rounded-xl hover:bg-red-700 transition-all duration-300">
                        <i class="fas fa-trash-alt mr-2"></i>
                        Hapus Akun Saya
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
