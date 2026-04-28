<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
// Note: Admin controller belum kita buat isinya, jadi kita nonaktifkan dulu rutenya sementara biar tidak error
// use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
// use App\Http\Controllers\Admin\ProductController as AdminProduct;

Auth::routes();

// --- ROUTE PUBLIC (Bisa diakses siapa saja) ---
// BARIS INI YANG PALING PENTING: Mengubah halaman depan menjadi Katalog Laptop
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{slug}', [HomeController::class, 'detail'])->name('product.detail');

// --- ROUTE USER (Harus Login) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('user.dashboard');
    
    // Rute Cart & Checkout (Nanti kita buat kodenya)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
});