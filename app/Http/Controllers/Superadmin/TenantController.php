<?php

namespace App\Http\Controllers\Superadmin;

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

        $data['subdomain'] = $data['subdomain'] ?? Str::slug($data['name']);
        $tenant = Tenant::create($data);

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

        $tenant->update($request->only(['name', 'email', 'status', 'config']));

        return response()->json(['message' => 'Tenant updated.', 'tenant' => $tenant]);
    }

    public function destroy($id)
    {
        Tenant::findOrFail($id)->delete();

        return response()->json(['message' => 'Tenant deleted.']);
    }
}
