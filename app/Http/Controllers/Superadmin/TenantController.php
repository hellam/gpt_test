<?php

namespace App\Http\Controllers\Superadmin;

use App\Helpers\AlertHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant;
use Illuminate\Support\Str;

class TenantController extends Controller
{
    public function index()
    {
        return response()->json(Tenant::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:tenants,email',
            'subdomain' => 'nullable|string|unique:tenants,subdomain',
        ]);

        // Generate subdomain from name if not provided
        $data['subdomain'] = $data['subdomain'] ?? Str::slug($data['name']);

        // Basic subdomain DNS test (optional)
//         if (!checkdnsrr("{$data['subdomain']}.ecobillafrica.com", 'A')) {
//             return response()->json(['message' => 'Subdomain not live yet.'], 422);
//         }

        $tenant = Tenant::create($data);
        AlertHelper::log('info', "Tenant '{$tenant->name}' was created by ".auth('api')->user()->name, 'Tenant', $tenant->id, 'superadmin');

        return response()->json([
            'message' => 'Tenant created successfully.',
            'tenant' => $tenant,
        ]);
    }

    public function show($id)
    {
        return response()->json(Tenant::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $tenant = Tenant::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:tenants,email,' . $tenant->id,
            'status' => 'sometimes|in:active,pending,suspended',
            'config' => 'sometimes|array',
            'config.sms_provider' => 'nullable|string|in:zettatel,africastalking',
            'config.sms_key' => 'nullable|string',
            'config.mpesa_paybill' => 'nullable|string',
            'config.mpesa_passkey' => 'nullable|string',
            'config.telegram_bot_token' => 'nullable|string',
            'config.telegram_chat_id' => 'nullable|string',
        ]);

        $tenant->update($request->only(['name', 'email', 'status', 'config']));

        AlertHelper::log('info', "Tenant '{$tenant->name}' was updated by ".auth('api')->user()->name, 'Tenant', $tenant->id, 'superadmin');
        return response()->json([
            'message' => 'Tenant updated.',
            'tenant' => $tenant,
        ]);
    }

    public function destroy($id)
    {
        Tenant::findOrFail($id)->delete();

        return response()->json(['message' => 'Tenant deleted.']);
    }
}
