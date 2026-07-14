<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('status')) {
            $query->where('status', $request->boolean('status'));
        }

        if ($request->has('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        $users = $query->with(['company', 'roles'])->paginate(15);

        return $this->success($users);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'company_id' => 'nullable|exists:companies,id',
            'status' => 'boolean',
            'roles' => 'nullable|array',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        if (isset($validated['roles'])) {
            $user->assignRole($validated['roles']);
        }

        return $this->success($user->load('roles'), 'User created successfully', 201);
    }

    public function show(User $user)
    {
        return $this->success($user->load(['company', 'roles', 'permissions']));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'company_id' => 'nullable|exists:companies,id',
            'status' => 'sometimes|boolean',
            'roles' => 'nullable|array',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        if (isset($validated['roles'])) {
            $user->syncRoles($validated['roles']);
        }

        return $this->success($user->load('roles'), 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return $this->success(null, 'User deleted successfully');
    }
}
