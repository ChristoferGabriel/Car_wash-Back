<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ClienteAuthController;
use App\Http\Controllers\ServicoController;
use Illuminate\Support\Facades\Route;

Route::get('/servicos', [ServicoController::class, 'index']);

Route::prefix('auth')->group(function () {
    Route::post('/register', [ClienteAuthController::class, 'register'])->middleware('throttle:registro');
    Route::post('/login', [ClienteAuthController::class, 'login'])->middleware('throttle:login');

    Route::middleware(['auth:sanctum', 'perfil:cliente'])->group(function () {
        Route::post('/logout', [ClienteAuthController::class, 'logout']);
        Route::get('/me', [ClienteAuthController::class, 'me']);
    });
});

Route::prefix('admin')->group(function () {
    Route::post('/login', [AdminAuthController::class, 'login'])->middleware('throttle:login');

    Route::middleware(['auth:sanctum', 'perfil:admin'])->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout']);
        Route::get('/me', [AdminAuthController::class, 'me']);
    });
});