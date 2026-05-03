<?php

use App\Http\Controllers\Auth\AuthController;
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
//  Auth Routes (hanya bisa diakses jika sudah login)
// ─────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/dashboard', function () {
        return redirect()->route('home');
    })->name('dashboard');

    Route::get('/product/{slug}', [HomeController::class, 'detail'])->name('product.detail');

   // ── Shopping Cart ──────────────────────────────────────
     Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/add', [CartController::class, 'add'])->name('cart.add');
        Route::patch('/update/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
        Route::delete('/clear', [CartController::class, 'clear'])->name('cart.clear');
        Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    });
    Route::get('/cart-demo', function () {
    return view('cart.demo');
})->name('cart.demo');
});