<?php
use App\Http\Controllers\Tenant\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenant\DashboardController;

Route::prefix('tenant')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware(['auth:api'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index']);
        // Future: profile, staff, vehicles, etc
    });
});

