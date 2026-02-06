@extends('layouts.app')

@section('title', 'Edit Profil - BandRame')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                    Profil Saya
                </h1>
                <p class="mt-2 text-gray-600">Kelola informasi profil dan alamat pengiriman Anda</p>
            </div>

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                    class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <p class="text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                    class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        <p class="text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Tabs -->
            <div x-data="{ activeTab: 'profile', showAddressModal: false, editAddressId: null }" class="space-y-6">
                <!-- Tab Buttons -->
                <div class="bg-white rounded-2xl shadow-xl p-2">
                    <div class="flex flex-wrap gap-2">
                        <button @click="activeTab = 'profile'"
                            :class="activeTab === 'profile' ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white' :
                                'text-gray-600 hover:bg-gray-100'"
                            class="flex-1 sm:flex-none px-6 py-3 rounded-xl font-medium transition-all duration-300">
                            <i class="fas fa-user mr-2"></i>Informasi Profil
                        </button>
                        <button @click="activeTab = 'addresses'"
                            :class="activeTab === 'addresses' ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white' :
                                'text-gray-600 hover:bg-gray-100'"
                            class="flex-1 sm:flex-none px-6 py-3 rounded-xl font-medium transition-all duration-300">
                            <i class="fas fa-map-marker-alt mr-2"></i>Alamat ({{ $addresses->count() }})
                        </button>
                        <button @click="activeTab = 'password'"
                            :class="activeTab === 'password' ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white' :
                                'text-gray-600 hover:bg-gray-100'"
                            class="flex-1 sm:flex-none px-6 py-3 rounded-xl font-medium transition-all duration-300">
                            <i class="fas fa-lock mr-2"></i>Ubah Password
                        </button>
                        <button @click="activeTab = 'delete'"
                            :class="activeTab === 'delete' ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white' :
                                'text-gray-600 hover:bg-gray-100'"
                            class="flex-1 sm:flex-none px-6 py-3 rounded-xl font-medium transition-all duration-300">
                            <i class="fas fa-trash-alt mr-2"></i>Hapus Akun
                        </button>
                    </div>
                </div>

                <!-- Profile Tab -->
                <div x-show="activeTab === 'profile'" x-transition class="bg-white rounded-2xl shadow-xl p-6 sm:p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Informasi Profil</h2>
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap
                                    <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                    required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email <span
                                        class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                    required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor
                                    Telepon</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                                    placeholder="08xxxxxxxxxx"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal
                                    Lahir</label>
                                <input type="date" name="birth_date" id="birth_date"
                                    value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                @error('birth_date')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Jenis
                                    Kelamin</label>
                                <select name="gender" id="gender"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="female"
                                        {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-8 flex justify-end">
                            <button type="submit"
                                class="px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-medium rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                                <i class="fas fa-save mr-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Addresses Tab -->
                <div x-show="activeTab === 'addresses'" x-transition class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-xl p-6">
                        <div class="flex justify-between items-center">
                            <h2 class="text-2xl font-bold text-gray-800">Alamat Pengiriman</h2>
                            <button @click="showAddressModal = true"
                                class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-medium rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                                <i class="fas fa-plus mr-2"></i>Tambah Alamat
                            </button>
                        </div>
                    </div>

                    @if ($addresses->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach ($addresses as $address)
                                <div
                                    class="bg-white rounded-2xl shadow-xl p-6 relative hover:shadow-2xl transition-shadow">
                                    @if ($address->is_default)
                                        <span
                                            class="absolute top-4 right-4 px-3 py-1 bg-gradient-to-r from-purple-600 to-pink-600 text-white text-xs font-semibold rounded-full">
                                            <i class="fas fa-star mr-1"></i>Utama
                                        </span>
                                    @endif
                                    <div class="mb-4">
                                        <h3 class="text-lg font-bold text-gray-800">{{ $address->label }}</h3>
                                        <p class="text-gray-600 font-medium mt-2">{{ $address->recipient_name }}</p>
                                        <p class="text-gray-600"><i
                                                class="fas fa-phone mr-2 text-purple-600"></i>{{ $address->phone }}</p>
                                    </div>
                                    <div class="mb-4 text-gray-600 text-sm">
                                        <p><i
                                                class="fas fa-map-marker-alt mr-2 text-purple-600"></i>{{ $address->address }}
                                        </p>
                                        <p class="ml-6">{{ $address->city }}, {{ $address->province }}
                                            {{ $address->postal_code }}</p>
                                        @if ($address->notes)
                                            <p class="mt-2 ml-6 italic text-gray-500"><i
                                                    class="fas fa-sticky-note mr-2"></i>{{ $address->notes }}</p>
                                        @endif
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        @if (!$address->is_default)
                                            <form method="POST"
                                                action="{{ route('profile.addresses.set-default', $address) }}"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="px-4 py-2 text-sm text-purple-600 border-2 border-purple-600 rounded-lg hover:bg-purple-50 transition-colors font-medium">
                                                    <i class="fas fa-star mr-1"></i>Jadikan Utama
                                                </button>
                                            </form>
                                        @endif
                                        <button @click="editAddressId = {{ $address->id }}"
                                            class="px-4 py-2 text-sm text-blue-600 border-2 border-blue-600 rounded-lg hover:bg-blue-50 transition-colors font-medium">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </button>
                                        @if (!$address->is_default)
                                            <form method="POST"
                                                action="{{ route('profile.addresses.destroy', $address) }}"
                                                class="inline" onsubmit="return confirm('Hapus alamat?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-4 py-2 text-sm text-red-600 border-2 border-red-600 rounded-lg hover:bg-red-50 transition-colors font-medium">
                                                    <i class="fas fa-trash mr-1"></i>Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                    <!-- Edit Modal per Address -->
                                    <div x-show="editAddressId === {{ $address->id }}"
                                        @click.self="editAddressId = null"
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4"
                                        style="display: none;">
                                        <div
                                            class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-8 max-h-[90vh] overflow-y-auto">
                                            <div class="flex justify-between items-center mb-6">
                                                <h3 class="text-2xl font-bold">Edit Alamat</h3>
                                                <button @click="editAddressId = null"
                                                    class="text-gray-400 hover:text-gray-600"><i
                                                        class="fas fa-times text-2xl"></i></button>
                                            </div>
                                            <form method="POST"
                                                action="{{ route('profile.addresses.update', $address) }}">
                                                @csrf
                                                @method('PATCH')
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div><label class="block text-sm font-medium mb-2">Label <span
                                                                class="text-red-500">*</span></label>
                                                        <input type="text" name="label"
                                                            value="{{ $address->label }}" required
                                                            class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-purple-500">
                                                    </div>
                                                    <div><label class="block text-sm font-medium mb-2">Nama Penerima <span
                                                                class="text-red-500">*</span></label>
                                                        <input type="text" name="recipient_name"
                                                            value="{{ $address->recipient_name }}" required
                                                            class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-purple-500">
                                                    </div>
                                                    <div class="md:col-span-2"><label
                                                            class="block text-sm font-medium mb-2">Telepon <span
                                                                class="text-red-500">*</span></label>
                                                        <input type="text" name="phone"
                                                            value="{{ $address->phone }}" required
                                                            class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-purple-500">
                                                    </div>
                                                    <div class="md:col-span-2"><label
                                                            class="block text-sm font-medium mb-2">Alamat <span
                                                                class="text-red-500">*</span></label>
                                                        <textarea name="address" rows="3" required
                                                            class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-purple-500">{{ $address->address }}</textarea>
                                                    </div>
                                                    <div><label class="block text-sm font-medium mb-2">Kota <span
                                                                class="text-red-500">*</span></label>
                                                        <input type="text" name="city"
                                                            value="{{ $address->city }}" required
                                                            class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-purple-500">
                                                    </div>
                                                    <div><label class="block text-sm font-medium mb-2">Provinsi <span
                                                                class="text-red-500">*</span></label>
                                                        <input type="text" name="province"
                                                            value="{{ $address->province }}" required
                                                            class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-purple-500">
                                                    </div>
                                                    <div><label class="block text-sm font-medium mb-2">Kode Pos <span
                                                                class="text-red-500">*</span></label>
                                                        <input type="text" name="postal_code"
                                                            value="{{ $address->postal_code }}" required
                                                            class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-purple-500">
                                                    </div>
                                                    <div class="md:col-span-2"><label
                                                            class="block text-sm font-medium mb-2">Catatan</label>
                                                        <textarea name="notes" rows="2"
                                                            class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-purple-500">{{ $address->notes }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="mt-6 flex justify-end gap-3">
                                                    <button type="button" @click="editAddressId = null"
                                                        class="px-6 py-3 border rounded-xl hover:bg-gray-50">Batal</button>
                                                    <button type="submit"
                                                        class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl hover:shadow-lg"><i
                                                            class="fas fa-save mr-2"></i>Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
                            <i class="fas fa-map-marker-alt text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-600 text-lg font-medium">Belum ada alamat tersimpan</p>
                            <p class="text-gray-500 mt-2">Tambahkan alamat pengiriman untuk mempermudah checkout</p>
                            <button @click="showAddressModal = true"
                                class="mt-6 px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-medium rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                                <i class="fas fa-plus mr-2"></i>Tambah Alamat Pertama
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Add Address Modal -->
                <div x-show="showAddressModal" @click.self="showAddressModal = false"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4"
                    style="display: none;">
                    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-8 max-h-[90vh] overflow-y-auto">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-2xl font-bold">Tambah Alamat Baru</h3>
                            <button @click="showAddressModal = false" class="text-gray-400 hover:text-gray-600"><i
                                    class="fas fa-times text-2xl"></i></button>
                        </div>
                        <form method="POST" action="{{ route('profile.addresses.store') }}">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div><label class="block text-sm font-medium mb-2">Label <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="label" required placeholder="Rumah, Kantor"
                                        class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-purple-500">
                                </div>
                                <div><label class="block text-sm font-medium mb-2">Nama Penerima <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="recipient_name" required
                                        class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-purple-500">
                                </div>
                                <div class="md:col-span-2"><label class="block text-sm font-medium mb-2">Telepon <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="phone" required placeholder="08xxxxxxxxxx"
                                        class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-purple-500">
                                </div>
                                <div class="md:col-span-2"><label class="block text-sm font-medium mb-2">Alamat <span
                                            class="text-red-500">*</span></label>
                                    <textarea name="address" rows="3" required placeholder="Jalan, RT/RW, Kelurahan, Kecamatan"
                                        class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-purple-500"></textarea>
                                </div>
                                <div><label class="block text-sm font-medium mb-2">Kota <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="city" required
                                        class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-purple-500">
                                </div>
                                <div><label class="block text-sm font-medium mb-2">Provinsi <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="province" required
                                        class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-purple-500">
                                </div>
                                <div><label class="block text-sm font-medium mb-2">Kode Pos <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="postal_code" required placeholder="12345"
                                        class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-purple-500">
                                </div>
                                <div class="md:col-span-2"><label class="block text-sm font-medium mb-2">Catatan</label>
                                    <textarea name="notes" rows="2" placeholder="Cth: Dekat indomaret"
                                        class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-purple-500"></textarea>
                                </div>
                            </div>
                            <div class="mt-6 flex justify-end gap-3">
                                <button type="button" @click="showAddressModal = false"
                                    class="px-6 py-3 border rounded-xl hover:bg-gray-50">Batal</button>
                                <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl hover:shadow-lg"><i
                                        class="fas fa-save mr-2"></i>Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Password Tab -->
                <div x-show="activeTab === 'password'" x-transition class="bg-white rounded-2xl shadow-xl p-6 sm:p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Ubah Password</h2>
                    <form method="POST" action="{{ route('profile.password.update') }}">
                        @csrf
                        @method('PATCH')
                        <div class="space-y-6 max-w-md">
                            <div>
                                <label for="current_password"
                                    class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini <span
                                        class="text-red-500">*</span></label>
                                <input type="password" name="current_password" id="current_password" required
                                    class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-purple-500">
                                @error('current_password')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru
                                    <span class="text-red-500">*</span></label>
                                <input type="password" name="password" id="password" required
                                    class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-purple-500">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Minimal 8 karakter</p>
                            </div>
                            <div>
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password <span
                                        class="text-red-500">*</span></label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-purple-500">
                            </div>
                        </div>
                        <div class="mt-8 flex justify-end">
                            <button type="submit"
                                class="px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-medium rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                                <i class="fas fa-key mr-2"></i>Ubah Password
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Delete Account Tab -->
                <div x-show="activeTab === 'delete'" x-transition class="bg-white rounded-2xl shadow-xl p-6 sm:p-8">
                    <h2 class="text-2xl font-bold text-red-600 mb-4">Hapus Akun</h2>
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                        <div class="flex">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-3 mt-1"></i>
                            <div>
                                <h3 class="font-semibold text-red-800">Peringatan!</h3>
                                <p class="text-red-700 mt-1">Tindakan ini tidak dapat dibatalkan. Semua data Anda akan
                                    dihapus permanen.</p>
                            </div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('profile.destroy') }}" class="max-w-md">
                        @csrf
                        @method('DELETE')
                        <div class="mb-6">
                            <label for="password_delete" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi
                                Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password" id="password_delete" required
                                placeholder="Masukkan password"
                                class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-red-500">
                            @error('password')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus akun?')"
                            class="px-8 py-3 bg-red-600 text-white font-medium rounded-xl hover:bg-red-700">
                            <i class="fas fa-trash-alt mr-2"></i>Hapus Akun Saya
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
