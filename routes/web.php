<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

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

    Route::get('/product/{slug}', [HomeController::class, 'detail'])->name('product.detail');

    // ── Shopping Cart ──────────────────────────────────────
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/',              [CartController::class, 'index'])->name('index');
        Route::post('/add',          [CartController::class, 'add'])->name('add');
        Route::patch('/update/{id}', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{id}',[CartController::class, 'remove'])->name('remove');
        Route::delete('/clear',      [CartController::class, 'clear'])->name('clear');
        Route::post('/checkout',     [CartController::class, 'checkout'])->name('checkout');
    });

    // tambahan dari upstream
    Route::get('/cart-demo', function () {
        return view('cart.demo');
    })->name('cart.demo');

    // Demo Detail Produk
    Route::get('/product-demo/{slug}', function ($slug) {
        $products = [
            'macbook-pro-16' => (object)[
                'name' => 'MacBook Pro 16"',
                'slug' => 'macbook-pro-16',
                'price' => 28999000,
                'description' => 'M3 Pro chip · 18GB RAM · 512GB SSD · Liquid Retina XDR. Perangkat bertenaga luar biasa yang dirancang untuk mengedit video dan merender 3D dengan lancar.',
                'image' => null
            ],
            'dell-xps-15' => (object)[
                'name' => 'Dell XPS 15',
                'slug' => 'dell-xps-15',
                'price' => 25999000,
                'description' => 'Intel i7-13700H · 16GB · 1TB SSD · 4K OLED Touch. Kekuatan memukau dalam desain super tipis. Warna akurat untuk pekerja seni digital.',
                'image' => null
            ],
            'asus-rog-strix-g16' => (object)[
                'name' => 'ASUS ROG Strix G16',
                'slug' => 'asus-rog-strix-g16',
                'price' => 32999000,
                'description' => 'RTX 4070 · i9-13980HX · 32GB · 2TB SSD · 240Hz. Dominasi setiap permainan tanpa hambatan berkat layar refresh rate ekstrem dan termal canggih.',
                'image' => null
            ],
            'hp-spectre-x360' => (object)[
                'name' => 'HP Spectre x360',
                'slug' => 'hp-spectre-x360',
                'price' => 19999000,
                'description' => 'Intel i7 · 16GB · 512GB SSD · OLED Touch · 2-in-1. Fleksibilitas premium untuk profesional modern. Berubah wujud dengan mudah dari laptop ke tablet.',
                'image' => null
            ]
        ];

        $product = $products[$slug] ?? $products['macbook-pro-16'];
        return view('product.detail', compact('product'));
    })->name('product.demo');
});

// ─────────────────────────────────────────────
//  ADMIN AUTH ROUTES
// ─────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/products', [DashboardController::class, 'products'])->name('products');
    Route::get('/orders', [DashboardController::class, 'orders'])->name('orders');
});