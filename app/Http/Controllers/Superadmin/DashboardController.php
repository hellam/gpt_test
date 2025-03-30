<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth('api')->user();

        $total     = Tenant::count();
        $active    = Tenant::where('status', 'active')->count();
        $suspended = Tenant::where('status', 'suspended')->count();
        $recent    = Tenant::where('created_at', '>=', Carbon::now()->subDays(7))->get(['name', 'subdomain', 'created_at']);

        return response()->json([
            'message' => 'Welcome, Superadmin!',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ],
            'stats' => [
                'total_tenants' => $total,
                'active_tenants' => $active,
                'suspended_tenants' => $suspended
            ],
            'recent_tenants' => $recent,
        ]);
    }
}

