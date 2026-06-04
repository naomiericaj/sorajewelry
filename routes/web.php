<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AiChatbotController;



Route::middleware('auth')->group(function () {
    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/item/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/item/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Payment
    Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{order}/finish', [PaymentController::class, 'finish'])
    ->name('payment.finish');

    // Customer orders
    Route::get('/my-orders', [CustomerOrderController::class, 'index'])->name('customer.orders.index');
    Route::get('/my-orders/{order}', [CustomerOrderController::class, 'show'])->name('customer.orders.show');
});

// Midtrans notification must be outside auth because Midtrans server calls it
Route::post('/midtrans/notification', [PaymentController::class, 'notification'])->name('midtrans.notification');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/orders/{order}/check-payment', [AdminOrderController::class, 'checkPayment'])->name('orders.checkPayment');
});

// HOME
Route::get('/', [HomeController::class, 'index'])->name('home');

// CUSTOMER PRODUCT SIDE
Route::get('/catalogue', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('/products/{slug}', [ProductController::class, 'show'])
    ->name('products.show');

// AUTH PAGES
Route::get('/login', [AuthController::class, 'showCustomerLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'customerLogin'])
    ->name('login.submit');

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.submit');

// ADMIN LOGIN
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])
    ->name('admin.login');

Route::post('/admin/login', [AuthController::class, 'adminLogin'])
    ->name('admin.login.submit');

// LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// CUSTOMER DASHBOARD
Route::get('/customer/dashboard', [CustomerDashboardController::class, 'index'])
    ->name('customer.dashboard')
    ->middleware('auth');

// ADMIN SIDE
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/products', [AdminProductController::class, 'index'])
        ->name('products.index');

    Route::get('/products/create', [AdminProductController::class, 'create'])
        ->name('products.create');

    Route::post('/products', [AdminProductController::class, 'store'])
        ->name('products.store');
        Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])
    ->name('products.edit');

Route::patch('/products/{product}', [AdminProductController::class, 'update'])
    ->name('products.update');

    Route::delete('/products/images/{image}', [AdminProductController::class, 'deleteImage'])
    ->name('products.images.delete');

Route::patch('/products/images/{image}/main', [AdminProductController::class, 'setMainImage'])
    ->name('products.images.main');

    Route::post('/products/{product}/images', [AdminProductController::class, 'storeImages'])
    ->name('products.images.store');

        
});


Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle'])
    ->name('google.redirect');

Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])
    ->name('google.callback');

// Customer contact page
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Customer order pages
Route::middleware('auth')->group(function () {
    Route::get('/my-orders', [CustomerOrderController::class, 'index'])
        ->name('customer.orders.index');

    Route::get('/my-orders/{order}', [CustomerOrderController::class, 'show'])
        ->name('customer.orders.show');
});

Route::post('/ai-chatbot/message', [AiChatbotController::class, 'message'])
    ->name('ai.chatbot.message');

// Admin order pages
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/orders', [AdminOrderController::class, 'index'])
        ->name('orders.index');

    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])
        ->name('orders.show');

    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
        ->name('orders.updateStatus');

    Route::get('/orders/{order}/check-payment', [AdminOrderController::class, 'checkPayment'])
        ->name('orders.checkPayment');
});