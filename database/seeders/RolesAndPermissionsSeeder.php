<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
{
    app()[PermissionRegistrar::class]->forgetCachedPermissions();

    $permissions = [
        'access dashboard',
        'fill application',
        'logout',
        'view users',
        'review certificates',
        'suggest validation status',
        'validate certificate',
        'reject certificate',
        'activate user',
        'deactivate user',
        'assign role',
        'assign permission',
    ];

    foreach ($permissions as $permission) {
        Permission::firstOrCreate([
            'name' => $permission,
            'guard_name' => 'web'
        ]);
    }

    $user = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
    $editor = Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);
    $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

    $user->givePermissionTo([
        'access dashboard',
        'fill application',
        'logout'
    ]);

    $editor->givePermissionTo([
        'view users',
        'review certificates',
        'suggest validation status'
    ]);

    $admin->givePermissionTo(Permission::all());
}

}
