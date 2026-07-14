<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Server;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    public function index(Request $request)
    {
        $query = Server::query();

        if ($request->has('status')) {
            $query->where('status', $request->boolean('status'));
        }

        if ($request->has('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        $servers = $query->with(['company', 'user'])->paginate(15);

        return $this->success($servers);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'host' => 'required|string|max:255',
            'port' => 'nullable|integer',
            'username' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:50',
            'status' => 'boolean',
            'company_id' => 'nullable|exists:companies,id',
            'os' => 'nullable|string|max:100',
            'cpu' => 'nullable|numeric',
            'ram' => 'nullable|numeric',
            'disk' => 'nullable|numeric',
        ]);

        $server = Server::create($validated);

        return $this->success($server, 'Server created successfully', 201);
    }

    public function show(Server $server)
    {
        return $this->success($server->load(['company', 'user', 'services', 'synchronizations']));
    }

    public function update(Request $request, Server $server)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'host' => 'sometimes|string|max:255',
            'port' => 'nullable|integer',
            'username' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:50',
            'status' => 'sometimes|boolean',
            'company_id' => 'nullable|exists:companies,id',
            'os' => 'nullable|string|max:100',
            'cpu' => 'nullable|numeric',
            'ram' => 'nullable|numeric',
            'disk' => 'nullable|numeric',
        ]);

        $server->update($validated);

        return $this->success($server, 'Server updated successfully');
    }

    public function destroy(Server $server)
    {
        $server->delete();

        return $this->success(null, 'Server deleted successfully');
    }
}
