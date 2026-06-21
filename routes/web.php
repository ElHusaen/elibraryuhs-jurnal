<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MahasiswaController;

// ========== GUEST ROUTES ==========
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginProses'])->name('login.proses');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerProses'])->name('register.post');
});

// ========== AUTH ROUTES ==========
Route::middleware('auth')->group(function () {

    // Logout - HANYA SATU (POST)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ========== ADMIN ONLY ==========
    Route::middleware('role:admin')->group(function () {
        Route::resource('user', UserController::class);
        Route::resource('kategori', KategoriController::class);
        Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
    });

    // ========== MAHASISWA & ADMIN ==========
    Route::middleware('role:admin,mahasiswa')->group(function () {
        Route::resource('jurnal', JurnalController::class);
    });

});

// ========== HOME REDIRECT ==========
Route::get('/', function () {
    return redirect()->route('login');
});