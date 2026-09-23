<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StationController;
use App\Http\Controllers\Api\ChargingController;

// Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Profil & Kendaraan
    Route::get('/user/profile', [AuthController::class, 'profile']);
    
    // Stasiun & Charger
    Route::get('/stations', [StationController::class, 'index']);
    Route::get('/stations/{id}', [StationController::class, 'show']);
    
    // Sesi Charging & Pembayaran
    Route::post('/charging/start', [ChargingController::class, 'startSession']);
    Route::post('/charging/stop', [ChargingController::class, 'stopSession']);
    Route::get('/charging/history', [ChargingController::class, 'history']);
});