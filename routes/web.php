<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;


Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {

    // Normal user dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
});



Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

    // Product list
    Route::get('/products', [ProductController::class, 'adminIndex'])->name('products.index');

    // Create product page
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

    // Store product
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    // Edit product page
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

    // Update product
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

    // Delete product
    Route::get('/products/{product}/delete', [ProductController::class, 'delete'])->name('products.delete');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

});
