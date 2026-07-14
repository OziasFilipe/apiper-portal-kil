<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::query();

        if ($request->has('status')) {
            $query->where('status', $request->boolean('status'));
        }

        if ($request->has('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        if ($request->has('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        if ($request->has('server_id')) {
            $query->where('server_id', $request->server_id);
        }

        $services = $query->with(['client', 'company', 'server', 'product'])->paginate(15);

        return $this->success($services);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'boolean',
            'client_id' => 'nullable|exists:clients,id',
            'company_id' => 'nullable|exists:companies,id',
            'server_id' => 'nullable|exists:servers,id',
            'product_id' => 'nullable|exists:products,id',
            'price' => 'nullable|numeric|min:0',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after:starts_at',
            'notes' => 'nullable|string',
        ]);

        $service = Service::create($validated);

        return $this->success($service->load(['client', 'company', 'server', 'product']), 'Service created successfully', 201);
    }

    public function show(Service $service)
    {
        return $this->success($service->load(['client', 'company', 'server', 'product']));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|boolean',
            'client_id' => 'nullable|exists:clients,id',
            'company_id' => 'nullable|exists:companies,id',
            'server_id' => 'nullable|exists:servers,id',
            'product_id' => 'nullable|exists:products,id',
            'price' => 'nullable|numeric|min:0',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after:starts_at',
            'notes' => 'nullable|string',
        ]);

        $service->update($validated);

        return $this->success($service->load(['client', 'company', 'server', 'product']), 'Service updated successfully');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return $this->success(null, 'Service deleted successfully');
    }
}
