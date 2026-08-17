<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/about', [HomeController::class, 'about'])->name('about');

    // Users (superadmin only)
    Route::middleware('can:manage-users')->group(function () {
        Route::get('/users', [UsersController::class, 'index'])->name('users.index');
        Route::get('/users/add', [UsersController::class, 'create'])->name('users.add');
        Route::post('/users/store', [UsersController::class, 'store'])->name('users.store');
        Route::get('/users/edit/{id}', [UsersController::class, 'edit'])->name('users.edit');
        Route::post('/users/update/{id}', [UsersController::class, 'update'])->name('users.update');
        Route::delete('/users/delete/{id}', [UsersController::class, 'destroy'])->name('users.delete');
    });

    // Product (admin & superadmin)
    Route::middleware('can:manage-products')->group(function () {
        Route::get('/product', [ProductController::class, 'index'])->name('product.index');
        Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/product/delete/{id}', [ProductController::class, 'destroy'])->name('product.delete');
    });
});

require __DIR__.'/auth.php';
