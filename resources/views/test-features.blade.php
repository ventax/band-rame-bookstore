@extends('layouts.app')

@section('title', 'Test Fitur Interaktif - BandRame')

@section('content')
    <div class="bg-gray-100 py-12">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-3xl font-bold mb-8">🧪 Test Fitur Interaktif</h1>

            <!-- Alpine.js Test -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">1. Alpine.js Status</h2>
                <div x-data="{ message: 'Alpine.js BEKERJA! ✅' }">
                    <p x-text="message" class="text-green-600 font-bold"></p>
                </div>
                <p class="text-sm text-gray-600 mt-2">Jika text di atas muncul hijau, Alpine.js sudah loaded.</p>
            </div>

            <!-- Toast Test -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">2. Toast Notification Test</h2>
                <div class="space-x-2">
                    <button
                        onclick="window.dispatchEvent(new CustomEvent('toast', { detail: { message: 'Success Toast!', type: 'success' }}))"
                        class="bg-green-500 text-white px-4 py-2 rounded">Success</button>
                    <button
                        onclick="window.dispatchEvent(new CustomEvent('toast', { detail: { message: 'Error Toast!', type: 'error' }}))"
                        class="bg-red-500 text-white px-4 py-2 rounded">Error</button>
                    <button
                        onclick="window.dispatchEvent(new CustomEvent('toast', { detail: { message: 'Info Toast!', type: 'info' }}))"
                        class="bg-blue-500 text-white px-4 py-2 rounded">Info</button>
                </div>
                <p class="text-sm text-gray-600 mt-2">Toast harus muncul di kanan atas layar.</p>
            </div>

            <!-- Live Search Test -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">3. Live Search Test</h2>
                <p class="text-sm text-gray-600 mb-2">Ketik minimal 2 huruf di search bar navbar, hasil harus muncul
                    otomatis.</p>
                <p class="font-mono text-xs bg-gray-100 p-2 rounded">Route: GET /search?q={query}</p>
            </div>

            <!-- Quick View Test -->
            <div class="bg-white rounded-lg shadow p-6 mb-6" x-data="{ showModal: false, testBook: { id: 1, title: 'Test Book', author: 'Test Author', price: '50.000', image: '/images/book-placeholder.png', description: 'Test description', category: 'Fiction', stock: 10, publisher: 'Test Publisher' } }">
                <h2 class="text-xl font-semibold mb-4">4. Quick View Modal Test</h2>
                <button @click="showModal = true" class="bg-purple-600 text-white px-4 py-2 rounded">
                    <i class="fas fa-eye mr-2"></i>Open Quick View
                </button>

                <!-- Modal -->
                <div x-show="showModal" x-cloak @click.self="showModal = false"
                    class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                    <div @click.stop class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-6">
                        <div class="flex justify-between mb-4">
                            <h3 class="text-2xl font-bold">Quick View Working! ✅</h3>
                            <button @click="showModal = false" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times text-2xl"></i>
                            </button>
                        </div>
                        <p>Modal muncul dengan smooth animation.</p>
                    </div>
                </div>
                <p class="text-sm text-gray-600 mt-2">Modal harus muncul dengan background overlay.</p>
            </div>

            @auth
                <!-- Slide-over Cart Test -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">5. Slide-over Cart Test</h2>
                    <p class="text-sm text-gray-600 mb-2">
                        Lihat floating cart button (mobile) atau tambah item ke cart.<br>
                        Cart harus slide dari kanan dengan isi keranjang Anda.
                    </p>
                    <button onclick="window.dispatchEvent(new CustomEvent('cart-updated'))"
                        class="bg-purple-600 text-white px-4 py-2 rounded">
                        Trigger Cart Reload
                    </button>
                </div>

                <!-- Wishlist Test -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">6. Wishlist Test</h2>
                    <p class="text-sm text-gray-600 mb-2">Klik icon heart pada kartu buku di katalog.</p>
                    <p class="font-mono text-xs bg-gray-100 p-2 rounded">Route: POST /wishlist/toggle</p>
                    <div class="mt-2">
                        <a href="{{ route('wishlist.index') }}" class="text-purple-600 hover:underline">
                            Lihat Wishlist Page &rarr;
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
                    <p class="text-yellow-800">⚠️ <strong>Login diperlukan</strong> untuk test Wishlist dan Cart!</p>
                    <a href="{{ route('login') }}" class="text-purple-600 hover:underline">Login sekarang &rarr;</a>
                </div>
            @endauth

            <!-- Routes Check -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">7. Routes Check</h2>
                <div class="space-y-1 font-mono text-xs">
                    <div class="flex items-center">
                        <span class="w-20 bg-green-100 text-green-800 px-2 py-1 rounded mr-2">GET</span>
                        <span>/search</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-20 bg-green-100 text-green-800 px-2 py-1 rounded mr-2">GET</span>
                        <span>/books/{book}/quick-view</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-20 bg-blue-100 text-blue-800 px-2 py-1 rounded mr-2">POST</span>
                        <span>/wishlist/toggle</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-20 bg-green-100 text-green-800 px-2 py-1 rounded mr-2">GET</span>
                        <span>/cart/items</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-20 bg-blue-100 text-blue-800 px-2 py-1 rounded mr-2">POST</span>
                        <span>/cart/add/{book}</span>
                    </div>
                </div>
            </div>

            <!-- Console Check -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">8. Browser Console Check</h2>
                <p class="text-sm text-gray-600 mb-2">Buka Browser DevTools (F12) → Console Tab</p>
                <p class="text-sm text-gray-600">Cari error messages. Tidak boleh ada error JavaScript.</p>
            </div>

            <!-- Success Indicators -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                <h3 class="font-bold text-green-800 mb-2">✅ Checklist Fitur Berhasil:</h3>
                <ul class="space-y-1 text-sm text-green-700">
                    <li>✓ Alpine.js text berubah warna hijau</li>
                    <li>✓ Toast muncul saat diklik</li>
                    <li>✓ Live search dropdown muncul saat ketik</li>
                    <li>✓ Quick View modal muncul smooth</li>
                    <li>✓ Cart slide dari kanan (jika logged in)</li>
                    <li>✓ Heart icon berubah solid saat klik</li>
                    <li>✓ Animasi smooth di semua interaksi</li>
                </ul>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('books.index') }}"
                    class="inline-block bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700">
                    Kembali ke Katalog Buku
                </a>
            </div>
        </div>
    </div>
@endsection
