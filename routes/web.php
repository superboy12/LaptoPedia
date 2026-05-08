<?php

use Illuminate\Http\Request;
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
use App\Http\Controllers\PaymentController;
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

    // ── Payment Routes ──────────────────────────────────────
    Route::get('/payment/{order}', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('/payment/upload/{order}', [PaymentController::class, 'uploadProof'])->name('payment.upload');

    // ── CHECKOUT PROCESS (FIX - TANPA DUPLICATE) ──
    Route::post('/checkout-process', function(Request $request) {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect('/cart')->with('error', 'Cart kosong');
        }
        
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        $shippingCost = 15000;
        $insurance = 15000;
        $total = $subtotal + $shippingCost + $insurance;
        
        $order = \App\Models\Order::create([
            'order_number' => 'ORD-' . time(),
            'user_id' => auth()->id(),
            'total_price' => $total,
            'status' => 'pending',
            'phone' => $request->phone,
            'address' => $request->address,
            'payment_method' => 'qris',
            'cart_data' => json_encode($cart),
        ]);
        
        foreach ($cart as $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }
        
        session()->forget('cart');
        
        return redirect('/payment/' . $order->id);
    });

    // ── Image Route ───────────────────────────────────────
    Route::get('/image/{path}', function ($path) {
        $fullPath = storage_path('app/public/' . $path);
        if (!file_exists($fullPath)) {
            abort(404);
        }
        return response()->file($fullPath);
    })->where('path', '.*')->name('image.show');

    // My Orders
    Route::get('/my-orders', [App\Http\Controllers\OrderController::class, 'index'])->name('my-orders');
    Route::get('/my-orders/{id}', [App\Http\Controllers\OrderController::class, 'show'])->name('my-orders.show');
});

// Confirm order delivery (customer confirms order received)
Route::post('/order/confirm/{id}', [App\Http\Controllers\OrderController::class, 'confirmDelivery'])->name('order.confirm');


    // ── Chat (User Side) ───────────────────────────────────
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::post('/send', [ChatController::class, 'send'])->name('send');
        Route::get('/poll',  [ChatController::class, 'poll'])->name('poll');
    });


// ─────────────────────────────────────────────
//  ADMIN AUTH ROUTES (LENGKAP)
// ─────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ── Order Management ───────────────────────────────────
    Route::get('/orders',                         [OrderAdminController::class, 'index'])->name('orders');
    Route::patch('/orders/{id}',                  [OrderAdminController::class, 'updateStatus'])->name('orders.update_status');
    Route::post('/orders/{id}/confirm-payment',   [OrderAdminController::class, 'confirmPayment'])->name('orders.confirm_payment');
    Route::post('/orders/{id}/reject-payment',    [OrderAdminController::class, 'rejectPayment'])->name('orders.reject_payment');
    Route::get('/orders/{id}/proof',              [OrderAdminController::class, 'viewProof'])->name('orders.proof');

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