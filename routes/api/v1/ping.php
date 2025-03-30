<?php
use Illuminate\Support\Facades\Route;
use App\Models\Tenant;

Route::get('{subdomain}/ping', function ($subdomain) {
    $tenant = Tenant::where('subdomain', $subdomain)->first();

    if (!$tenant) {
        return response()->json(['status' => 'invalid', 'message' => 'Tenant not found'], 404);
    }

    if ($tenant->status !== 'active') {
        return response()->json(['status' => 'inactive', 'message' => 'Tenant inactive'], 403);
    }

    return response()->json([
        'status' => 'OK',
        'tenant' => [
            'name' => $tenant->name,
            'subdomain' => $tenant->subdomain,
        ],
    ]);
});
