<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Operator\DashboardController;

// 1. Redirect Halaman Utama ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Route Autentikasi (Tampilan & Proses Login/Logout)
Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', function () { return view('auth.register'); })->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// 3. Route Tampilan Pengemudi
Route::prefix('pengemudi')->group(function () {
    Route::get('/home', function () { return view('pengemudi.home'); })->name('pengemudi.home');
    Route::get('/history', function () { return view('pengemudi.history'); })->name('pengemudi.history');
    Route::get('/vehicles', function () { return view('pengemudi.vehicles'); })->name('pengemudi.vehicles');
    Route::get('/profile', function () { return view('pengemudi.profile'); })->name('pengemudi.profile');
});

// 4. Route Dashboard Operator
Route::prefix('operator')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('operator.dashboard');
});