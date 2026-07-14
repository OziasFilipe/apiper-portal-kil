<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Integration;
use Illuminate\Http\Request;

class IntegrationController extends Controller
{
    public function index(Request $request)
    {
        $query = Integration::query();

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('status')) {
            $query->where('status', $request->boolean('status'));
        }

        $integrations = $query->paginate(15);

        return $this->success($integrations);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'provider' => 'required|string|max:255',
            'status' => 'boolean',
            'config' => 'nullable|array',
            'credentials' => 'nullable|array',
        ]);

        $integration = Integration::create($validated);

        return $this->success($integration, 'Integration created successfully', 201);
    }

    public function show(Integration $integration)
    {
        return $this->success($integration->load('synchronizations'));
    }

    public function update(Request $request, Integration $integration)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|string|max:100',
            'provider' => 'sometimes|string|max:255',
            'status' => 'sometimes|boolean',
            'config' => 'nullable|array',
            'credentials' => 'nullable|array',
        ]);

        $integration->update($validated);

        return $this->success($integration, 'Integration updated successfully');
    }

    public function destroy(Integration $integration)
    {
        $integration->delete();

        return $this->success(null, 'Integration deleted successfully');
    }
}
