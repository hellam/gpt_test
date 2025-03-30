<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Superadmin\DashboardController;

Route::middleware(['auth:api', 'issuperadmin'])
    ->prefix('superadmin')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index']);
    });
