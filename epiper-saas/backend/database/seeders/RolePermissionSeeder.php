<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'manage_clients',
            'manage_companies',
            'manage_servers',
            'manage_products',
            'manage_users',
            'manage_permissions',
            'manage_settings',
            'manage_integrations',
            'manage_synchronizations',
            'manage_services',
            'view_dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'group' => 'general']);
        }

        $adminRole = Role::create(['name' => 'Admin', 'description' => 'Administrator']);
        $managerRole = Role::create(['name' => 'Manager', 'description' => 'Manager']);
        $userRole = Role::create(['name' => 'User', 'description' => 'Standard User']);

        $adminRole->givePermissionTo(Permission::all());
        $managerRole->givePermissionTo(['manage_clients', 'manage_companies', 'manage_servers', 'manage_products', 'manage_services', 'view_dashboard']);
        $userRole->givePermissionTo(['view_dashboard', 'manage_clients']);
    }
}