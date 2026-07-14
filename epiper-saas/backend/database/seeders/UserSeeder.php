<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin Epiper',
            'email' => 'admin@epiper.com.br',
            'password' => Hash::make('admin123'),
            'status' => true,
        ]);

        $admin->assignRole('Admin');
    }
}