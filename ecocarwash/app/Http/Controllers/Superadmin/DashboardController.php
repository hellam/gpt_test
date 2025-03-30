<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Welcome, Superadmin!',
            'user' => auth('api')->user(),
        ]);
    }
}

