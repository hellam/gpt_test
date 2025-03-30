<?php

use App\Http\Controllers\Superadmin\AuthController;
use App\Http\Controllers\Superadmin\TenantController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Superadmin\DashboardController;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['auth:api', 'issuperadmin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/tenants', [TenantController::class, 'index']);
    Route::post('/tenants', [TenantController::class, 'store']);
    Route::get('/tenants/{id}', [TenantController::class, 'show']);
    Route::put('/tenants/{id}', [TenantController::class, 'update']);
    Route::delete('/tenants/{id}', [TenantController::class, 'destroy']);
});
