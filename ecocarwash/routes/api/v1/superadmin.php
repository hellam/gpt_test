<?php

use App\Http\Controllers\Superadmin\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Superadmin\DashboardController;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['auth:api', 'issuperadmin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
