<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Synchronization;
use Illuminate\Http\Request;

class SynchronizationController extends Controller
{
    public function index(Request $request)
    {
        $query = Synchronization::query();

        if ($request->has('status')) {
            $query->where('status', $request->boolean('status'));
        }

        if ($request->has('integration_id')) {
            $query->where('integration_id', $request->integration_id);
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $syncs = $query->with(['integration', 'server', 'company'])->paginate(15);

        return $this->success($syncs);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'status' => 'boolean',
            'integration_id' => 'nullable|exists:integrations,id',
            'server_id' => 'nullable|exists:servers,id',
            'company_id' => 'nullable|exists:companies,id',
            'schedule' => 'nullable|string|max:100',
            'next_run_at' => 'nullable|date',
        ]);

        $sync = Synchronization::create($validated);

        return $this->success($sync, 'Synchronization created successfully', 201);
    }

    public function show(Synchronization $synchronization)
    {
        return $this->success($synchronization->load(['integration', 'server', 'company']));
    }

    public function update(Request $request, Synchronization $synchronization)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|string|max:100',
            'status' => 'sometimes|boolean',
            'integration_id' => 'nullable|exists:integrations,id',
            'server_id' => 'nullable|exists:servers,id',
            'company_id' => 'nullable|exists:companies,id',
            'schedule' => 'nullable|string|max:100',
            'next_run_at' => 'nullable|date',
        ]);

        $synchronization->update($validated);

        return $this->success($synchronization, 'Synchronization updated successfully');
    }

    public function destroy(Synchronization $synchronization)
    {
        $synchronization->delete();

        return $this->success(null, 'Synchronization deleted successfully');
    }

    public function run(Request $request, Synchronization $synchronization)
    {
        $synchronization->update([
            'last_run_at' => now(),
            'logs' => ['message' => 'Synchronization executed successfully', 'executed_at' => now()->toDateTimeString()],
        ]);

        return $this->success($synchronization, 'Synchronization executed successfully');
    }
}
