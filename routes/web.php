<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ChatAdminController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

// ─────────────────────────────────────────────
//  Guest Routes (hanya bisa diakses jika belum login)
// ─────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);

    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ─────────────────────────────────────────────
//  ADMIN ROUTES (Guest)
// ─────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware('guest')->group(function () {
    Route::get('/login',     [AdminController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AdminController::class, 'login']);

    Route::get('/register',  [AdminController::class, 'showRegister'])->name('register');
    Route::post('/register', [AdminController::class, 'register']);
});

// ─────────────────────────────────────────────
//  Auth Routes (hanya bisa diakses jika sudah login)
// ─────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/dashboard', function () {
        return redirect()->route('home');
    })->name('dashboard');

    // ── Profil Pengguna ──────────────────────────────────
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::put('/profile', [HomeController::class, 'updateProfile'])->name('profile.update');

    Route::get('/products', [HomeController::class, 'products'])->name('products.index');
    Route::get('/product/{slug}', [HomeController::class, 'detail'])->name('product.detail');

    // ── Shopping Cart ──────────────────────────────────────
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/',              [CartController::class, 'index'])->name('index');
        Route::post('/add',          [CartController::class, 'add'])->name('add');
        Route::patch('/update/{id}', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{id}',[CartController::class, 'remove'])->name('remove');
        Route::delete('/clear',      [CartController::class, 'clear'])->name('clear');
        Route::post('/sync-demo',    [CartController::class, 'syncDemoCart'])->name('sync-demo');
    });

    // ── Checkout ───────────────────────────────────────────
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/process', [CheckoutController::class, 'process'])->name('process');
        Route::get('/success/{order_number}', [CheckoutController::class, 'success'])->name('success');
        Route::post('/coupon', [CheckoutController::class, 'applyCoupon'])->name('applyCoupon');
        Route::post('/shipping-cost', [CheckoutController::class, 'getShippingCost'])->name('shippingCost');
    });

    // ── Chat (User Side) ───────────────────────────────────
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::post('/send', [ChatController::class, 'send'])->name('send');
        Route::get('/poll',  [ChatController::class, 'poll'])->name('poll');
    });
});

// ─────────────────────────────────────────────
//  ADMIN AUTH ROUTES (LENGKAP)
// ─────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ── Order Management ───────────────────────────────────
    Route::get('/orders',            [OrderAdminController::class, 'index'])->name('orders');
    Route::patch('/orders/{id}',     [OrderAdminController::class, 'updateStatus'])->name('orders.update_status');

    // ── Product CRUD ───────────────────────────────────────
    Route::get('/products',          [ProductAdminController::class, 'index'])->name('products');
    Route::post('/products',         [ProductAdminController::class, 'store'])->name('products.store');
    Route::put('/products/{id}',     [ProductAdminController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}',  [ProductAdminController::class, 'destroy'])->name('products.destroy');

    // ── Category CRUD ───────────────────────────────────────
    Route::get('/categories',          [ProductAdminController::class, 'categoriesIndex'])->name('categories.index');
    Route::post('/categories',         [ProductAdminController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{id}',     [ProductAdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{id}',  [ProductAdminController::class, 'destroyCategory'])->name('categories.destroy');

    // ── Chat Admin ─────────────────────────────────────────
    Route::get('/chat',                   [ChatAdminController::class, 'index'])->name('chat');
    Route::get('/chat/{userId}/messages', [ChatAdminController::class, 'messages'])->name('chat.messages');
    Route::post('/chat/{userId}/reply',   [ChatAdminController::class, 'reply'])->name('chat.reply');
    Route::get('/chat/unread-count',      [ChatAdminController::class, 'unreadCount'])->name('chat.unread');
});