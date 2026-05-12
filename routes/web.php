<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;

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
});