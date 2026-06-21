<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MahasiswaController;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// ========== GUEST ROUTES ==========
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginProses'])->name('login.proses');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerProses'])->name('register.proses');
});

// ========== AUTH ROUTES ==========
Route::middleware('auth')->group(function () {

    // Logout (use match to support both GET and POST)
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

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
