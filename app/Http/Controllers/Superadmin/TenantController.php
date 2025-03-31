<?php

namespace App\Http\Controllers\Superadmin;

use App\Helpers\AlertHelper;
use App\Helpers\SubdomainHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant;
use Illuminate\Support\Str;

/**
 * @OA\Tag(
 *     name="Tenants",
 *     description="Tenant management by Superadmin"
 * )
 */
class TenantController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/superadmin/tenants",
     *     summary="List all tenants",
     *     tags={"Tenants"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of tenants"
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Tenant::query()->paginate(5));
    }

    /**
     * @OA\Post(
     *     path="/api/v1/superadmin/tenants",
     *     summary="Create a new tenant",
     *     tags={"Tenants"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="subdomain", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tenant created"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:tenants,email',
            'subdomain' => 'nullable|string|unique:tenants,subdomain',
        ]);

        // Generate subdomain from name if not provided
        $slug = $data['subdomain'] ?? Str::slug($data['name']);

        if (SubdomainHelper::isReserved($slug)) {
            return response()->json(['message' => 'This subdomain is reserved and cannot be used.'], 422);
        }

        $data['subdomain'] = $slug;

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

    /**
     * @OA\Get(
     *     path="/api/v1/superadmin/tenants/{id}",
     *     summary="Get single tenant by ID",
     *     tags={"Tenants"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tenant data"
     *     )
     * )
     */
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
