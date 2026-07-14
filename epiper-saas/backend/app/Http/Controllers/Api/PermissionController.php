<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Permission::query();

        if ($request->has('group')) {
            $query->where('group', $request->group);
        }

        $permissions = $query->get(['id', 'name', 'guard_name', 'group']);

        $groups = Permission::select('group')->distinct()->pluck('group');

        return $this->success([
            'permissions' => $permissions,
            'groups' => $groups,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'guard_name' => 'nullable|string|max:255',
            'group' => 'nullable|string|max:100',
        ]);

        $permission = Permission::create($validated);

        return $this->success($permission, 'Permission created successfully', 201);
    }

    public function show(Permission $permission)
    {
        return $this->success($permission->load('roles'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255|unique:permissions,name,' . $permission->id,
            'group' => 'nullable|string|max:100',
        ]);

        $permission->update($validated);

        return $this->success($permission, 'Permission updated successfully');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return $this->success(null, 'Permission deleted successfully');
    }

    public function roles(Request $request)
    {
        $roles = Role::all(['id', 'name', 'guard_name']);

        return $this->success($roles);
    }
}
