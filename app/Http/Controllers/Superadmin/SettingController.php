<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\PlatformSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = PlatformSetting::all()->pluck('value', 'key');
        return response()->json($settings);
    }

    public function update(Request $request)
    {
        $rules = [
            'password_min_length' => 'nullable|integer|min:6|max:128',
            'require_special_characters' => 'nullable|boolean',
            'allow_tenant_signup' => 'nullable|boolean',
            'default_tenant_status' => 'nullable|in:pending,active,suspended',
            'company_name' => 'nullable|string|max:255',
        ];

        $validated = $request->validate($rules);

        foreach ($validated as $key => $value) {
            PlatformSetting::set($key, $value);
        }

        return response()->json(['message' => 'Settings updated successfully']);
    }
}

