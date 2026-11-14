<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/profil', [PublicController::class, 'profile'])->name('profile');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::prefix('produk-layanan')->name('products.')->group(function (): void {
    Route::get('/', [PublicController::class, 'products'])->name('index');
    Route::get('/{slug}', [PublicController::class, 'productDetail'])->name('show');
});

Route::get('/galeri', [PublicController::class, 'gallery'])->name('gallery');
Route::get('/kontak', [PublicController::class, 'contact'])->name('contact');

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/kontak', [ContactController::class, 'submit'])->name('contact.submit');
});
