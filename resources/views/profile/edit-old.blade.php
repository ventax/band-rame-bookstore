<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- DEBUG: Test if page loads -->
            <div class="bg-yellow-100 border border-yellow-400 p-4 rounded mb-4">
                <p class="font-bold">DEBUG: Halaman Profile Loaded!</p>
                <p>User: {{ $user->name ?? 'No user' }}</p>
                <p>Addresses Count: {{ $addresses->count() ?? 0 }}</p>
            </div>

            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
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
                </div>
            @endif

            <!-- Simple Static Content Test -->
            <div class="bg-white rounded-2xl shadow-xl p-8 mb-6">
                <h2 class="text-2xl font-bold mb-4">Test Static Content</h2>
                <p>Jika Anda melihat ini, berarti halaman sudah ter-render!</p>
                <p class="mt-2">User Name: <strong>{{ $user->name }}</strong></p>
                <p class="mt-2">User Email: <strong>{{ $user->email }}</strong></p>
            </div>

            <!-- Tabs Navigation - SIMPLIFIED WITHOUT ALPINE -->
            <div class="space-y-6">
                <!-- Tab Buttons - Static for now -->
                <div class="bg-white rounded-2xl shadow-xl p-2">
                    <div class="flex flex-wrap gap-2">
                        <a href="#profile" class="flex-1 sm:flex-none px-6 py-3 rounded-xl font-medium bg-gradient-to-r from-purple-600 to-pink-600 text-white">
                            <i class="fas fa-user mr-2"></i>
                            Informasi Profil
                        </a>
                        <a href="#addresses" class="flex-1 sm:flex-none px-6 py-3 rounded-xl font-medium text-gray-600 hover:bg-gray-100">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            Alamat
                        </a>
                        <a href="#password" class="flex-1 sm:flex-none px-6 py-3 rounded-xl font-medium text-gray-600 hover:bg-gray-100">
                            <i class="fas fa-lock mr-2"></i>
                            Ubah Password
                        </a>
                        <a href="#delete" class="flex-1 sm:flex-none px-6 py-3 rounded-xl font-medium text-gray-600 hover:bg-gray-100">
                            <i class="fas fa-trash-alt mr-2"></i>
                            Hapus Akun
                        </a>
                    </div>
                </div>
                                'text-gray-600 hover:bg-gray-100'"
                            class="flex-1 sm:flex-none px-6 py-3 rounded-xl font-medium transition-all duration-300">
                            <i class="fas fa-user mr-2"></i>
                            Informasi Profil
                        </button>
                        <button @click="activeTab = 'addresses'"
                            :class="activeTab === 'addresses' ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white' :
                                'text-gray-600 hover:bg-gray-100'"
                            class="flex-1 sm:flex-none px-6 py-3 rounded-xl font-medium transition-all duration-300">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            Alamat
                        </button>
                        <button @click="activeTab = 'password'"
                            :class="activeTab === 'password' ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white' :
                                'text-gray-600 hover:bg-gray-100'"
                            class="flex-1 sm:flex-none px-6 py-3 rounded-xl font-medium transition-all duration-300">
                            <i class="fas fa-lock mr-2"></i>
                            Ubah Password
                        </button>
                        <button @click="activeTab = 'delete'"
                            :class="activeTab === 'delete' ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white' :
                                'text-gray-600 hover:bg-gray-100'"
                            class="flex-1 sm:flex-none px-6 py-3 rounded-xl font-medium transition-all duration-300">
                            <i class="fas fa-trash-alt mr-2"></i>
                            Hapus Akun
                        </button>
                    </div>
                </div>

                <!-- Profile Information Tab -->
                <div x-show="activeTab === 'profile'" x-transition class="bg-white rounded-2xl shadow-xl p-6 sm:p-8">
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
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', $user->name) }}" required
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
                                <input type="email" name="email" id="email"
                                    value="{{ old('email', $user->email) }}" required
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
                                    <option value="male"
                                        {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Laki-laki
                                    </option>
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

                <!-- Addresses Tab -->
                <div x-show="activeTab === 'addresses'" x-transition class="space-y-6">
                    <!-- Add New Address Button -->
                    <div class="bg-white rounded-2xl shadow-xl p-6">
                        <div class="flex justify-between items-center">
                            <h2 class="text-2xl font-bold text-gray-800">Alamat Pengiriman</h2>
                            <button @click="$dispatch('open-modal', 'add-address')"
                                class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-medium rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                                <i class="fas fa-plus mr-2"></i>
                                Tambah Alamat
                            </button>
                        </div>
                    </div>

                    <!-- Address List -->
                    @if ($addresses->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach ($addresses as $address)
                                <div class="bg-white rounded-2xl shadow-xl p-6 relative">
                                    @if ($address->is_default)
                                        <span
                                            class="absolute top-4 right-4 px-3 py-1 bg-gradient-to-r from-purple-600 to-pink-600 text-white text-xs font-semibold rounded-full">
                                            Utama
                                        </span>
                                    @endif

                                    <div class="mb-4">
                                        <h3 class="text-lg font-bold text-gray-800">{{ $address->label }}</h3>
                                        <p class="text-gray-600 font-medium mt-2">{{ $address->recipient_name }}</p>
                                        <p class="text-gray-600">{{ $address->phone }}</p>
                                    </div>

                                    <div class="mb-4 text-gray-600">
                                        <p>{{ $address->address }}</p>
                                        <p>{{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}
                                        </p>
                                        @if ($address->notes)
                                            <p class="mt-2 text-sm italic">Catatan: {{ $address->notes }}</p>
                                        @endif
                                    </div>

                                    <div class="flex flex-wrap gap-2">
                                        @if (!$address->is_default)
                                            <form method="POST"
                                                action="{{ route('profile.addresses.set-default', $address) }}">
                                                @csrf
                                                <button type="submit"
                                                    class="px-4 py-2 text-sm text-purple-600 border border-purple-600 rounded-lg hover:bg-purple-50 transition-colors">
                                                    <i class="fas fa-star mr-1"></i>
                                                    Jadikan Utama
                                                </button>
                                            </form>
                                        @endif

                                        <button @click="$dispatch('open-modal', 'edit-address-{{ $address->id }}')"
                                            class="px-4 py-2 text-sm text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 transition-colors">
                                            <i class="fas fa-edit mr-1"></i>
                                            Edit
                                        </button>

                                        @if (!$address->is_default)
                                            <button
                                                @click="$dispatch('open-modal', 'delete-address-{{ $address->id }}')"
                                                class="px-4 py-2 text-sm text-red-600 border border-red-600 rounded-lg hover:bg-red-50 transition-colors">
                                                <i class="fas fa-trash mr-1"></i>
                                                Hapus
                                            </button>
                                        @endif
                                    </div>

                                    <!-- Edit Address Modal -->
                                    <div x-data="{ show: false }"
                                        @open-modal.window="if ($event.detail === 'edit-address-{{ $address->id }}') show = true"
                                        @close-modal.window="show = false" @keydown.escape.window="show = false"
                                        x-show="show" class="fixed inset-0 z-50 overflow-y-auto"
                                        style="display: none;">
                                        <div class="flex items-center justify-center min-h-screen px-4">
                                            <div @click="show = false" class="fixed inset-0 bg-black opacity-50">
                                            </div>
                                            <div
                                                class="relative bg-white rounded-2xl shadow-xl max-w-2xl w-full p-6 sm:p-8">
                                                <h3 class="text-2xl font-bold text-gray-800 mb-6">Edit Alamat</h3>
                                                <form method="POST"
                                                    action="{{ route('profile.addresses.update', $address) }}">
                                                    @csrf
                                                    @method('PATCH')

                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 mb-2">Label
                                                                Alamat <span class="text-red-500">*</span></label>
                                                            <input type="text" name="label"
                                                                value="{{ $address->label }}" required
                                                                placeholder="Rumah, Kantor, dll"
                                                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                                        </div>

                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 mb-2">Nama
                                                                Penerima <span class="text-red-500">*</span></label>
                                                            <input type="text" name="recipient_name"
                                                                value="{{ $address->recipient_name }}" required
                                                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                                        </div>

                                                        <div class="md:col-span-2">
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 mb-2">Nomor
                                                                Telepon <span class="text-red-500">*</span></label>
                                                            <input type="text" name="phone"
                                                                value="{{ $address->phone }}" required
                                                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                                        </div>

                                                        <div class="md:col-span-2">
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 mb-2">Alamat
                                                                Lengkap <span class="text-red-500">*</span></label>
                                                            <textarea name="address" rows="3" required
                                                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ $address->address }}</textarea>
                                                        </div>

                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 mb-2">Kota/Kabupaten
                                                                <span class="text-red-500">*</span></label>
                                                            <input type="text" name="city"
                                                                value="{{ $address->city }}" required
                                                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                                        </div>

                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 mb-2">Provinsi
                                                                <span class="text-red-500">*</span></label>
                                                            <input type="text" name="province"
                                                                value="{{ $address->province }}" required
                                                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                                        </div>

                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 mb-2">Kode
                                                                Pos <span class="text-red-500">*</span></label>
                                                            <input type="text" name="postal_code"
                                                                value="{{ $address->postal_code }}" required
                                                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                                        </div>

                                                        <div class="md:col-span-2">
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 mb-2">Catatan
                                                                (Opsional)</label>
                                                            <textarea name="notes" rows="2" placeholder="Cth: Dekat indomaret, rumah pagar hijau"
                                                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ $address->notes }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="mt-6 flex justify-end gap-3">
                                                        <button type="button" @click="show = false"
                                                            class="px-6 py-3 text-gray-600 border border-gray-300 rounded-xl hover:bg-gray-50">
                                                            Batal
                                                        </button>
                                                        <button type="submit"
                                                            class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl hover:shadow-lg">
                                                            <i class="fas fa-save mr-2"></i>
                                                            Simpan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Address Modal -->
                                    @if (!$address->is_default)
                                        <div x-data="{ show: false }"
                                            @open-modal.window="if ($event.detail === 'delete-address-{{ $address->id }}') show = true"
                                            @close-modal.window="show = false" @keydown.escape.window="show = false"
                                            x-show="show" class="fixed inset-0 z-50 overflow-y-auto"
                                            style="display: none;">
                                            <div class="flex items-center justify-center min-h-screen px-4">
                                                <div @click="show = false" class="fixed inset-0 bg-black opacity-50">
                                                </div>
                                                <div
                                                    class="relative bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
                                                    <h3 class="text-xl font-bold text-gray-800 mb-4">Hapus Alamat</h3>
                                                    <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus
                                                        alamat <strong>{{ $address->label }}</strong>?</p>
                                                    <form method="POST"
                                                        action="{{ route('profile.addresses.destroy', $address) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="flex justify-end gap-3">
                                                            <button type="button" @click="show = false"
                                                                class="px-6 py-3 text-gray-600 border border-gray-300 rounded-xl hover:bg-gray-50">
                                                                Batal
                                                            </button>
                                                            <button type="submit"
                                                                class="px-6 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700">
                                                                <i class="fas fa-trash mr-2"></i>
                                                                Hapus
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
                            <i class="fas fa-map-marker-alt text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-600 text-lg">Belum ada alamat tersimpan</p>
                            <p class="text-gray-500 mt-2">Tambahkan alamat pengiriman untuk mempermudah proses checkout
                            </p>
                        </div>
                    @endif

                    <!-- Add Address Modal -->
                    <div x-data="{ show: false }" @open-modal.window="if ($event.detail === 'add-address') show = true"
                        @close-modal.window="show = false" @keydown.escape.window="show = false" x-show="show"
                        class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                        <div class="flex items-center justify-center min-h-screen px-4">
                            <div @click="show = false" class="fixed inset-0 bg-black opacity-50"></div>
                            <div class="relative bg-white rounded-2xl shadow-xl max-w-2xl w-full p-6 sm:p-8">
                                <h3 class="text-2xl font-bold text-gray-800 mb-6">Tambah Alamat Baru</h3>
                                <form method="POST" action="{{ route('profile.addresses.store') }}">
                                    @csrf

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Label Alamat
                                                <span class="text-red-500">*</span></label>
                                            <input type="text" name="label" value="{{ old('label') }}"
                                                required placeholder="Rumah, Kantor, dll"
                                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Penerima
                                                <span class="text-red-500">*</span></label>
                                            <input type="text" name="recipient_name"
                                                value="{{ old('recipient_name') }}" required
                                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        </div>

                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon
                                                <span class="text-red-500">*</span></label>
                                            <input type="text" name="phone" value="{{ old('phone') }}"
                                                required placeholder="08xxxxxxxxxx"
                                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        </div>

                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap
                                                <span class="text-red-500">*</span></label>
                                            <textarea name="address" rows="3" required placeholder="Jalan, RT/RW, Kelurahan, Kecamatan"
                                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('address') }}</textarea>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Kota/Kabupaten
                                                <span class="text-red-500">*</span></label>
                                            <input type="text" name="city" value="{{ old('city') }}"
                                                required
                                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Provinsi <span
                                                    class="text-red-500">*</span></label>
                                            <input type="text" name="province" value="{{ old('province') }}"
                                                required
                                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Kode Pos <span
                                                    class="text-red-500">*</span></label>
                                            <input type="text" name="postal_code"
                                                value="{{ old('postal_code') }}" required placeholder="12345"
                                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        </div>

                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan
                                                (Opsional)</label>
                                            <textarea name="notes" rows="2" placeholder="Cth: Dekat indomaret, rumah pagar hijau"
                                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('notes') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="mt-6 flex justify-end gap-3">
                                        <button type="button" @click="show = false"
                                            class="px-6 py-3 text-gray-600 border border-gray-300 rounded-xl hover:bg-gray-50">
                                            Batal
                                        </button>
                                        <button type="submit"
                                            class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl hover:shadow-lg">
                                            <i class="fas fa-save mr-2"></i>
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Change Password Tab -->
                <div x-show="activeTab === 'password'" x-transition class="bg-white rounded-2xl shadow-xl p-6 sm:p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Ubah Password</h2>
                    <form method="POST" action="{{ route('profile.password.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-6 max-w-md">
                            <!-- Current Password -->
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

                            <!-- New Password -->
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

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-gray-700 mb-2">
                                    Konfirmasi Password Baru <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    required
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

                <!-- Delete Account Tab -->
                <div x-show="activeTab === 'delete'" x-transition class="bg-white rounded-2xl shadow-xl p-6 sm:p-8">
                    <h2 class="text-2xl font-bold text-red-600 mb-4">Hapus Akun</h2>
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                        <div class="flex">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-3 mt-1"></i>
                            <div>
                                <h3 class="font-semibold text-red-800">Peringatan!</h3>
                                <p class="text-red-700 mt-1">
                                    Tindakan ini tidak dapat dibatalkan. Semua data Anda termasuk riwayat pesanan,
                                    alamat, dan informasi lainnya akan dihapus permanen.
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
    </div>
</x-app-layout>
