@extends('layouts.app')

@section('title', $book->title . ' - ATigaBookStore')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-8 text-sm">
                <ol class="flex items-center space-x-2 text-gray-600">
                    <li><a href="{{ route('home') }}" class="hover:text-primary-600">Home</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><a href="{{ route('books.index') }}" class="hover:text-primary-600">Katalog</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><a href="{{ route('books.index', ['category' => $book->category_id]) }}"
                            class="hover:text-primary-600">{{ $book->category->name }}</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li class="text-gray-900">{{ $book->title }}</li>
                </ol>
            </nav>

            @php
                $bookImages = collect([$book->cover_image])
                    ->merge($book->gallery_images ?? [])
                    ->filter()
                    ->unique()
                    ->map(fn($path) => asset('storage/' . $path))
                    ->values()
                    ->all();
            @endphp

            <!-- Book Detail -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="grid md:grid-cols-2 gap-8 p-8">
                    <!-- Book Image -->
                    <div class="relative" x-data="{ images: @js($bookImages), current: 0 }">
                        @if ($book->discount > 0)
                            <div class="absolute top-4 left-4 z-10">
                                <span
                                    class="inline-flex items-center gap-1.5 bg-gradient-to-r from-red-500 to-orange-500 text-white font-black px-3 py-1.5 rounded-lg shadow-xl ring-2 ring-white text-sm">
                                    <i class="fas fa-bolt text-yellow-300"></i> -{{ $book->discount }}% OFF
                                </span>
                            </div>
                        @endif

                        @if (count($bookImages) > 0)
                            <div class="relative overflow-hidden rounded-lg shadow-lg">
                                <img :src="images[current]" alt="{{ $book->title }}" class="w-full rounded-lg">

                                @if (count($bookImages) > 1)
                                    <button @click="current = (current - 1 + images.length) % images.length"
                                        class="absolute left-3 top-1/2 -translate-y-1/2 h-9 w-9 rounded-full bg-white/90 hover:bg-white text-gray-700 shadow flex items-center justify-center">
                                        <i class="fas fa-chevron-left text-sm"></i>
                                    </button>
                                    <button @click="current = (current + 1) % images.length"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 h-9 w-9 rounded-full bg-white/90 hover:bg-white text-gray-700 shadow flex items-center justify-center">
                                        <i class="fas fa-chevron-right text-sm"></i>
                                    </button>
                                @endif
                            </div>

                            @if (count($bookImages) > 1)
                                <div class="mt-3 grid grid-cols-5 gap-2">
                                    @foreach ($bookImages as $index => $imageUrl)
                                        <button @click="current = {{ $index }}"
                                            :class="current === {{ $index }} ? 'ring-2 ring-blue-500 border-blue-500' :
                                                'border-gray-200'"
                                            class="rounded-lg overflow-hidden border transition-all">
                                            <img src="{{ $imageUrl }}" alt="Thumbnail {{ $index + 1 }}"
                                                class="w-full h-16 object-cover">
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="w-full h-96 bg-gray-300 flex items-center justify-center rounded-lg">
                                <i class="fas fa-book text-gray-500 text-8xl"></i>
                            </div>
                        @endif

                        @if (!empty($book->pdf_file))
                            <a href="{{ route('books.pdf', $book->id) }}" target="_blank"
                                class="block w-full mt-4 py-2.5 rounded-xl font-semibold bg-gray-100 text-red-600 hover:bg-gray-200 text-center text-sm">
                                <i class="fas fa-file-pdf mr-2"></i>Lihat PDF
                            </a>
                        @endif
                    </div>

                    <!-- Book Info -->
                    <div x-data="{ quantity: 1 }">
                        @if ($book->is_featured)
                            <span
                                class="inline-block bg-yellow-400 text-gray-900 text-xs font-bold px-3 py-1 rounded-full mb-4">
                                <i class="fas fa-star"></i> Buku Pilihan
                            </span>
                        @endif

                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $book->title }}</h1>
                        <p class="text-gray-600 mb-4">oleh <span class="font-semibold">{{ $book->author }}</span></p>

                        <div class="mb-6">
                            @if ($book->discount > 0)
                                {{-- Discount banner --}}
                                <div
                                    class="inline-flex items-center gap-2 bg-gradient-to-r from-red-500 to-orange-500 text-white text-sm font-black px-4 py-1.5 rounded-xl shadow-md mb-3 animate-pulse">
                                    <i class="fas fa-bolt text-yellow-300"></i>
                                    DISKON {{ $book->discount }}% OFF
                                </div>
                                <div class="flex flex-wrap items-end gap-3">
                                    <span class="text-4xl font-black text-red-600">Rp
                                        {{ number_format($book->discounted_price, 0, ',', '.') }}</span>
                                    <div class="flex flex-col pb-1">
                                        <span class="text-sm text-gray-400 line-through">Rp
                                            {{ number_format($book->price, 0, ',', '.') }}</span>
                                        <span
                                            class="inline-flex items-center gap-1 text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-full mt-1">
                                            <i class="fas fa-piggy-bank"></i> Hemat Rp
                                            {{ number_format($book->price - $book->discounted_price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            @else
                                <span class="text-3xl font-bold text-primary-600">Rp
                                    {{ number_format($book->discounted_price, 0, ',', '.') }}</span>
                            @endif
                            <div class="mt-3">
                                @if ($book->stock > 0)
                                    <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">
                                        <i class="fas fa-check-circle"></i> Stok Tersedia ({{ $book->stock }})
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-sm px-3 py-1 rounded-full">
                                        <i class="fas fa-times-circle"></i> Stok Habis
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="border-t border-b border-gray-200 py-4 mb-6">
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Kategori:</span>
                                    <span class="font-semibold ml-2">{{ $book->category->name }}</span>
                                </div>
                                @if ($book->publisher)
                                    <div>
                                        <span class="text-gray-600">Penerbit:</span>
                                        <span class="font-semibold ml-2">{{ $book->publisher }}</span>
                                    </div>
                                @endif
                                @if ($book->isbn)
                                    <div>
                                        <span class="text-gray-600">ISBN:</span>
                                        <span class="font-semibold ml-2">{{ $book->isbn }}</span>
                                    </div>
                                @endif
                                @if ($book->pages)
                                    <div>
                                        <span class="text-gray-600">Halaman:</span>
                                        <span class="font-semibold ml-2">{{ $book->pages }}</span>
                                    </div>
                                @endif
                                <div>
                                    <span class="text-gray-600">Bahasa:</span>
                                    <span class="font-semibold ml-2">{{ $book->language }}</span>
                                </div>
                                @if ($book->published_year)
                                    <div>
                                        <span class="text-gray-600">Tahun Terbit:</span>
                                        <span class="font-semibold ml-2">{{ $book->published_year }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Add to Cart -->
                        @auth
                            @if ($book->stock > 0)
                                <div class="flex items-center space-x-4 mb-6">
                                    <div class="flex items-center border border-gray-300 rounded-lg">
                                        <button @click="quantity > 1 ? quantity-- : quantity"
                                            class="px-4 py-2 text-gray-600 hover:bg-gray-100">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" x-model="quantity" min="1" :max="{{ $book->stock }}"
                                            class="w-16 text-center border-x border-gray-300 py-2 focus:outline-none">
                                        <button @click="quantity < {{ $book->stock }} ? quantity++ : quantity"
                                            class="px-4 py-2 text-gray-600 hover:bg-gray-100">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>

                                    <button @click="addToCart({{ $book->id }}, quantity)" class="flex-1 btn-primary">
                                        <i class="fas fa-shopping-cart mr-2"></i> Tambah ke Keranjang
                                    </button>
                                </div>
                            @else
                                <div class="bg-gray-100 text-gray-600 text-center py-3 rounded-lg mb-6">
                                    Maaf, buku ini sedang tidak tersedia
                                </div>
                            @endif
                        @else
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                                <p class="text-yellow-800"><i class="fas fa-info-circle mr-2"></i> Silakan <a
                                        href="{{ route('login') }}" class="font-semibold underline">login</a> untuk membeli
                                    buku ini</p>
                            </div>
                        @endauth

                        <!-- Description -->
                        <div>
                            <h2 class="text-xl font-semibold mb-3">Deskripsi Buku</h2>
                            <p class="text-gray-700 leading-relaxed">{{ $book->description }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Books -->
            @if ($relatedBooks->count() > 0)
                <div class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Buku Terkait</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach ($relatedBooks as $relatedBook)
                            <div class="card group">
                                <a href="{{ route('books.show', $relatedBook->slug) }}" class="block">
                                    <div class="relative overflow-hidden">
                                        @if ($relatedBook->cover_image)
                                            <img src="{{ asset('storage/' . $relatedBook->cover_image) }}"
                                                alt="{{ $relatedBook->title }}"
                                                class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-64 bg-gray-300 flex items-center justify-center">
                                                <i class="fas fa-book text-gray-500 text-6xl"></i>
                                            </div>
                                        @endif
                                        @if ($relatedBook->discount > 0)
                                            <span
                                                class="absolute top-2 left-2 inline-flex items-center gap-0.5 bg-gradient-to-r from-red-500 to-orange-500 text-white text-xs font-black px-2 py-0.5 rounded-lg shadow-lg">
                                                <i class="fas fa-bolt text-yellow-300" style="font-size:9px"></i>
                                                -{{ $relatedBook->discount }}%
                                            </span>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                                            {{ $relatedBook->title }}
                                        </h3>
                                        <p class="text-sm text-gray-600 mb-2">{{ $relatedBook->author }}</p>
                                        @if ($relatedBook->discount > 0)
                                            <span class="text-xs text-gray-400 line-through">Rp
                                                {{ number_format($relatedBook->price, 0, ',', '.') }}</span><br>
                                            <span class="text-lg font-black text-red-600">Rp
                                                {{ number_format($relatedBook->discounted_price, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-lg font-bold text-primary-600">Rp
                                                {{ number_format($relatedBook->discounted_price, 0, ',', '.') }}</span>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- ══════════════════ REVIEWS & RATING ══════════════════ --}}
    <div class="bg-white border-t mt-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            {{-- Flash messages --}}
            @if (session('success'))
                <div
                    class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 rounded-xl px-5 py-4">
                    <i class="fas fa-check-circle text-green-500 text-lg"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div
                    class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-5 py-4">
                    <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <div class="grid lg:grid-cols-3 gap-10">

                {{-- Left: Rating Summary --}}
                <div class="lg:col-span-1">
                    <h2 class="text-2xl font-black text-gray-900 mb-6">Ulasan Pembeli</h2>

                    @if ($reviewsCount > 0)
                        <div class="bg-gradient-to-br from-blue-50 to-orange-50 rounded-2xl p-6 mb-6 text-center">
                            <div class="text-6xl font-black text-gray-900 leading-none mb-1">
                                {{ number_format($avgRating, 1) }}</div>
                            <div class="flex justify-center gap-0.5 my-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= floor($avgRating))
                                        <i class="fas fa-star text-amber-400 text-xl"></i>
                                    @elseif($i - $avgRating < 1)
                                        <i class="fas fa-star-half-alt text-amber-400 text-xl"></i>
                                    @else
                                        <i class="far fa-star text-amber-300 text-xl"></i>
                                    @endif
                                @endfor
                            </div>
                            <p class="text-gray-500 text-sm">Berdasarkan {{ $reviewsCount }} ulasan</p>
                        </div>

                        {{-- Star breakdown bar --}}
                        <div class="space-y-2 mb-6">
                            @foreach ($starBreakdown as $star => $data)
                                <div class="flex items-center gap-3 text-sm">
                                    <span class="w-3 text-right font-semibold text-gray-600">{{ $star }}</span>
                                    <i class="fas fa-star text-amber-400 text-xs flex-shrink-0"></i>
                                    <div class="flex-1 bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                        <div class="bg-amber-400 h-2.5 rounded-full transition-all"
                                            style="width: {{ $data['percent'] }}%"></div>
                                    </div>
                                    <span class="w-8 text-gray-500 text-xs">{{ $data['count'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-2xl p-6 text-center mb-6">
                            <i class="far fa-comment-alt text-gray-300 text-5xl mb-3 block"></i>
                            <p class="text-gray-500 font-medium">Belum ada ulasan</p>
                            <p class="text-gray-400 text-sm mt-1">Jadilah yang pertama mengulas buku ini</p>
                        </div>
                    @endif

                    {{-- Write Review Form --}}
                    @auth
                        @if ($userReview)
                            {{-- User already reviewed --}}
                            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-5">
                                <p class="text-blue-700 font-semibold text-sm mb-1"><i class="fas fa-check-circle mr-1"></i>
                                    Ulasan Anda</p>
                                <div class="flex gap-0.5 mb-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i
                                            class="fas fa-star {{ $i <= $userReview->rating ? 'text-amber-400' : 'text-gray-200' }} text-sm"></i>
                                    @endfor
                                </div>
                                @if ($userReview->title)
                                    <p class="font-semibold text-gray-800 text-sm">{{ $userReview->title }}</p>
                                @endif
                                @if ($userReview->body)
                                    <p class="text-gray-600 text-sm mt-1">{{ $userReview->body }}</p>
                                @endif
                                <form method="POST" action="{{ route('reviews.destroy', $userReview) }}" class="mt-3"
                                    onsubmit="return confirm('Hapus ulasan Anda?')">
                                    @csrf @method('DELETE')
                                    <button class="text-xs text-red-500 hover:text-red-700 font-semibold">
                                        <i class="fas fa-trash mr-1"></i> Hapus ulasan
                                    </button>
                                </form>
                            </div>
                        @elseif($userCanReview)
                            {{-- Form: verified purchaser --}}
                            <div class="bg-white border-2 border-blue-100 rounded-2xl p-6">
                                <h3 class="font-bold text-gray-900 mb-1">Tulis Ulasan</h3>
                                <p class="text-xs text-green-600 font-semibold mb-4">
                                    <i class="fas fa-check-circle mr-1"></i> Pembelian Terverifikasi
                                </p>

                                <form method="POST" action="{{ route('reviews.store', $book) }}" x-data="{ rating: 0, hovering: 0 }">
                                    @csrf
                                    {{-- Star picker --}}
                                    <div class="mb-4">
                                        <p class="text-sm font-semibold text-gray-700 mb-2">Rating <span
                                                class="text-red-500">*</span></p>
                                        <div class="flex gap-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <button type="button" @click="rating = {{ $i }}"
                                                    @mouseenter="hovering = {{ $i }}" @mouseleave="hovering = 0"
                                                    class="text-3xl transition-transform hover:scale-110 focus:outline-none">
                                                    <i
                                                        :class="(hovering || rating) >= {{ $i }} ?
                                                            'fas fa-star text-amber-400' : 'far fa-star text-gray-300'"></i>
                                                </button>
                                            @endfor
                                        </div>
                                        <input type="hidden" name="rating" :value="rating" required>
                                        @error('rating')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Ulasan</label>
                                        <input type="text" name="title" maxlength="100"
                                            placeholder="Ringkasan singkat..."
                                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                                            value="{{ old('title') }}">
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Ulasan</label>
                                        <textarea name="body" rows="4" maxlength="2000" placeholder="Ceritakan pengalaman membaca Anda..."
                                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none">{{ old('body') }}</textarea>
                                    </div>

                                    <button type="submit" x-bind:disabled="rating === 0"
                                        :class="rating === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:shadow-md'"
                                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-3 rounded-xl transition-all text-sm">
                                        <i class="fas fa-paper-plane mr-2"></i> Kirim Ulasan
                                    </button>
                                </form>
                            </div>
                        @else
                            {{-- Not purchased --}}
                            <div class="bg-orange-50 border border-orange-200 rounded-2xl p-5 text-center">
                                <i class="fas fa-shopping-bag text-orange-300 text-3xl mb-2 block"></i>
                                <p class="text-gray-700 font-semibold text-sm">Beli dulu, review kemudian</p>
                                <p class="text-gray-500 text-xs mt-1">Hanya pembeli yang dapat memberikan ulasan</p>
                            </div>
                        @endif
                    @else
                        <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5 text-center">
                            <p class="text-gray-600 text-sm font-medium">
                                <a href="{{ route('login') }}" class="text-blue-600 font-bold underline">Login</a>
                                untuk memberikan ulasan
                            </p>
                        </div>
                    @endauth
                </div>

                {{-- Right: Reviews List --}}
                <div class="lg:col-span-2">
                    @if ($reviews->count() > 0)
                        <div class="space-y-5">
                            @foreach ($reviews as $review)
                                <div
                                    class="border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                                    <div class="flex items-start justify-between gap-3 mb-3">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-orange-500 flex items-center justify-center text-white font-black text-sm flex-shrink-0">
                                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-900 text-sm">{{ $review->user->name }}</p>
                                                <p class="text-gray-400 text-xs">
                                                    {{ $review->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-end gap-1">
                                            <div class="flex gap-0.5">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fas fa-star {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }} text-sm"></i>
                                                @endfor
                                            </div>
                                            @if ($review->is_verified_purchase)
                                                <span class="text-xs text-green-600 font-semibold">
                                                    <i class="fas fa-check-circle"></i> Pembelian Terverifikasi
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    @if ($review->title)
                                        <h4 class="font-bold text-gray-800 mb-1">{{ $review->title }}</h4>
                                    @endif
                                    @if ($review->body)
                                        <p class="text-gray-600 text-sm leading-relaxed">{{ $review->body }}</p>
                                    @endif

                                    @auth
                                        @if (Auth::id() === $review->user_id)
                                            <form method="POST" action="{{ route('reviews.destroy', $review) }}"
                                                class="mt-3" onsubmit="return confirm('Hapus ulasan ini?')">
                                                @csrf @method('DELETE')
                                                <button class="text-xs text-red-400 hover:text-red-600 font-semibold">
                                                    <i class="fas fa-trash mr-1"></i> Hapus
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        @if ($reviews->hasPages())
                            <div class="mt-8">{{ $reviews->links() }}</div>
                        @endif
                    @else
                        <div class="flex flex-col items-center justify-center h-48 text-center">
                            <i class="far fa-comment-dots text-gray-200 text-6xl mb-4"></i>
                            <p class="text-gray-500 font-medium">Belum ada ulasan untuk buku ini</p>
                            <p class="text-gray-400 text-sm mt-1">Jadilah yang pertama berbagi pendapatmu!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @auth
        @push('scripts')
            <script>
                function addToCart(bookId, quantity) {
                    // Trigger flying animation
                    const bookImage = document.querySelector('.aspect-square img, .aspect-square > div');
                    const bookTitle = '{{ $book->title }}';

                    if (bookImage) {
                        window.flyToCart(bookImage, bookTitle);
                    }

                    fetch(`/cart/add/${bookId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                quantity: quantity
                            })
                        })
                        .then(async response => {
                            const data = await response.json();

                            if (!response.ok) {
                                throw new Error(data.message || `HTTP ${response.status}`);
                            }

                            return data;
                        })
                        .then(data => {
                            if (data.success) {
                                window.dispatchEvent(new CustomEvent('cart-updated'));
                                window.showToast('success', data.message || 'Produk berhasil ditambahkan ke keranjang');
                                return;
                            }

                            window.showToast('error', data.message || 'Terjadi kesalahan. Silakan coba lagi.');
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            window.showToast('error', error.message || 'Terjadi kesalahan. Silakan coba lagi.');
                        });
                }
            </script>
        @endpush
    @endauth
@endsection
