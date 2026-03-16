<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminBookController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Test Features Page
Route::get('/test-features', function () {
    return view('test-features');
})->name('test.features');

// Dashboard (redirect based on role)
Route::get('/dashboard', function () {
    if (\Illuminate\Support\Facades\Auth::check()) {
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user && $user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home');
    }
    return redirect()->route('login');
})->name('dashboard');

// Books
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{slug}', [BookController::class, 'show'])->name('books.show');
Route::get('/books/{book}/quick-view', [BookController::class, 'quickView'])->name('books.quick-view');
Route::get('/books/{book}/pdf', [BookController::class, 'viewPdf'])->name('books.pdf');
Route::get('/search', [BookController::class, 'search'])->name('books.search');

// Cart
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
    Route::get('/cart/items', [CartController::class, 'items'])->name('cart.items');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::get('/wishlist/count', [WishlistController::class, 'count'])->name('wishlist.count');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{wishlist}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    // Reviews
    Route::post('/books/{book}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Checkout Flow (Multi-Step)
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/address', [CheckoutController::class, 'address'])->name('address');
        Route::get('/payment', function () {
            return redirect()->route('checkout.address')
                ->with('error', 'Sesi checkout pembayaran tidak ditemukan. Silakan pilih alamat terlebih dahulu.');
        })->name('payment.fallback');
        Route::post('/payment', [CheckoutController::class, 'payment'])->name('payment');
        Route::post('/process', [CheckoutController::class, 'process'])->name('process');
        Route::get('/success/{orderNumber}', [CheckoutController::class, 'success'])->name('success');
        Route::get('/midtrans/finish', [CheckoutController::class, 'midtransFinish'])->name('midtrans.finish');
    });

    // Orders Management
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{orderNumber}', [OrderController::class, 'show'])->name('show');
        Route::post('/{orderNumber}/upload-payment', [OrderController::class, 'uploadPaymentProof'])->name('upload-payment');
        Route::post('/{orderNumber}/cancel', [OrderController::class, 'cancel'])->name('cancel');
        Route::post('/{orderNumber}/confirm-whatsapp', [OrderController::class, 'confirmWhatsapp'])->name('confirm-whatsapp');
        Route::post('/{orderNumber}/confirm-received', [OrderController::class, 'confirmReceived'])->name('confirm-received');
    });

    // Address Management
    Route::resource('addresses', AddressController::class)->except(['show']);
    Route::post('/addresses/{address}/set-default', [AddressController::class, 'setDefault'])->name('addresses.set-default');

    // Profile Setup (onboarding setelah register)
    Route::get('/profile/setup', [ProfileController::class, 'setup'])->name('profile.setup');
    Route::post('/profile/setup', [ProfileController::class, 'storeSetup'])->name('profile.setup.store');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Addresses
    Route::post('/profile/addresses', [ProfileController::class, 'storeAddress'])->name('profile.addresses.store');
    Route::patch('/profile/addresses/{address}', [ProfileController::class, 'updateAddress'])->name('profile.addresses.update');
    Route::delete('/profile/addresses/{address}', [ProfileController::class, 'destroyAddress'])->name('profile.addresses.destroy');
    Route::post('/profile/addresses/{address}/set-default', [ProfileController::class, 'setDefaultAddress'])->name('profile.addresses.set-default');
});

// Payment Gateway Callback
Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');

// Admin Auth Routes (tidak perlu middleware auth/admin)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'create'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'store'])->name('login.store');
    Route::post('/logout', [AdminLoginController::class, 'destroy'])->middleware('auth')->name('logout');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
    // Redirect /admin to /admin/dashboard
    Route::redirect('/', '/admin/dashboard');

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Books Management
    Route::resource('books', AdminBookController::class);

    // Categories Management
    Route::resource('categories', AdminCategoryController::class);

    // Orders Management
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/check-new', [AdminOrderController::class, 'checkNewOrders'])->name('check-new');
        Route::get('/{order}', [AdminOrderController::class, 'show'])->name('show');
        Route::patch('/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('updateStatus');
        Route::post('/{order}/verify-payment', [AdminOrderController::class, 'verifyPayment'])->name('verifyPayment');
        Route::delete('/{order}', [AdminOrderController::class, 'destroy'])->name('destroy');
    });

    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/logo', [AdminSettingController::class, 'logo'])->name('logo');
        Route::post('/logo', [AdminSettingController::class, 'uploadLogo'])->name('logo.upload');
        Route::delete('/logo', [AdminSettingController::class, 'deleteLogo'])->name('logo.delete');
        Route::post('/favicon', [AdminSettingController::class, 'uploadFavicon'])->name('favicon.upload');
        Route::delete('/favicon', [AdminSettingController::class, 'deleteFavicon'])->name('favicon.delete');
        Route::post('/site-name', [AdminSettingController::class, 'updateSiteName'])->name('site-name.update');

        // CMS — Konten website
        Route::get('/content/{group?}', [AdminSettingController::class, 'content'])->name('content');
        Route::post('/content/{group}', [AdminSettingController::class, 'updateContent'])->name('content.update');
    });
});

require __DIR__ . '/auth.php';
