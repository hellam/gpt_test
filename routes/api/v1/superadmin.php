<?php

use App\Http\Controllers\Superadmin\AlertController;
use App\Http\Controllers\Superadmin\AuthController;
use App\Http\Controllers\Superadmin\ProfileController;
use App\Http\Controllers\Superadmin\SettingController;
use App\Http\Controllers\Superadmin\TenantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Superadmin\DashboardController;

Route::post('login', [AuthController::class, 'login']);
Route::middleware(['auth:api', 'issuperadmin'])->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show']);
        Route::put('/', [ProfileController::class, 'update']);
        Route::put('/password', [ProfileController::class, 'changePassword']);
    });
    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingController::class, 'index']);
        Route::put('/', [SettingController::class, 'update']);
    });
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('alerts', [AlertController::class, 'index']);
    Route::prefix('tenants')->group(function () {
        Route::get('/', [TenantController::class, 'index']);
        Route::post('/', [TenantController::class, 'store']);
        Route::get('{id}', [TenantController::class, 'show']);
        Route::put('{id}', [TenantController::class, 'update']);
        Route::delete('{id}', [TenantController::class, 'destroy']);
        Route::post('suggest-subdomain', function (Request $request) {
            $request->validate(['name' => 'required|string']);
            $slug = Illuminate\Support\Str::slug($request->name);

            $reserved = App\Helpers\SubdomainHelper::isReserved($slug);

            if ($reserved) {
                $slug .= '-' . uniqid();
            }

            $exists = \App\Models\Tenant::where('subdomain', $slug)->exists();
            $slug = $exists ? $slug . '-' . uniqid() : $slug;

            return response()->json(['suggested' => $slug]);
        });

    });
});
