<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create the admin role if it doesn't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Create a new admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'], // Change this email if needed
            [
                'name' => 'System Admin',
                'password' => Hash::make('password123'), // Change the password
            ]
        );

        // Assign role to the user
        $admin->assignRole($adminRole);
    }
}
