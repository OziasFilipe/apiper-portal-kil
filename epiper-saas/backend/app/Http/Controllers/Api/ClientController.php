<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::query();

        if ($request->has('status')) {
            $query->where('status', $request->boolean('status'));
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $clients = $query->with(['company', 'user'])->paginate(15);

        return $this->success($clients);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'document' => 'nullable|string|max:20',
            'company_id' => 'nullable|exists:companies,id',
            'notes' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $client = Client::create($validated);

        return $this->success($client, 'Client created successfully', 201);
    }

    public function show(Client $client)
    {
        return $this->success($client->load(['company', 'user', 'services']));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'document' => 'nullable|string|max:20',
            'company_id' => 'nullable|exists:companies,id',
            'notes' => 'nullable|string',
            'status' => 'sometimes|boolean',
        ]);

        $client->update($validated);

        return $this->success($client, 'Client updated successfully');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return $this->success(null, 'Client deleted successfully');
    }
}
