<?php

namespace App\Http\Controllers\Tenant;

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return response()->json([
            'user' => [
                'name'  => $user->name,
                'email' => $user->email
            ],
            'today_revenue' => 24500,
            'change_percent' => 8,
            'vehicles_washed_today' => 18,
            'vehicles_pending' => 3,
            'bookings_today' => 24,
            'walk_ins' => 6,
            'staff_on_duty' => 6,
            'staff_on_leave' => 2,
            'recent_bookings' => [
                [
                    'vehicle' => 'Toyota Prado',
                    'plate' => 'KCG 123A',
                    'service' => 'Premium Wash',
                    'amount' => 'KES 2500',
                    'status' => 'completed'
                ],
                [
                    'vehicle' => 'Honda Civic',
                    'plate' => 'KDG 456B',
                    'service' => 'Standard Wash',
                    'amount' => 'KES 1500',
                    'status' => 'in-progress'
                ],
                [
                    'vehicle' => 'BMW X5',
                    'plate' => 'KBV 789C',
                    'service' => 'Full Detailing',
                    'amount' => 'KES 5000',
                    'status' => 'pending'
                ]
            ]
        ]);
    }
}
