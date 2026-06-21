<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MahasiswaController;

// ========== GUEST ROUTES (Tanpa Login) ==========
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginProses'])->name('login.proses');
    
    // Register
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerProses'])->name('register.post');
});

// ========== AUTH ROUTES (Harus Login) ==========
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard (Semua role bisa akses)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ========== ADMIN ONLY ==========
    Route::middleware('role:admin')->group(function () {
        // CRUD User
        Route::resource('user', UserController::class);
        
        // CRUD Kategori
        Route::resource('kategori', KategoriController::class);

        // Data Mahasiswa
        Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
    });

    // ========== MAHASISWA & ADMIN ==========
    Route::middleware('role:admin,mahasiswa')->group(function () {
        // Jurnal
        Route::resource('jurnal', JurnalController::class);
    });

});

// ========== HOME REDIRECT ==========
Route::get('/', function () {
    return redirect()->route('login');
});