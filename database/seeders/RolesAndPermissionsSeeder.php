<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view documents',
            'create documents',
            'edit documents',
            'delete documents',
            'comment documents',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo($permissions);

        $standardUser = Role::firstOrCreate(['name' => 'standardUser']);
        $standardUser->givePermissionTo(['create documents', 'view documents', 'comment documents']);

        $guestUser = Role::firstOrCreate(['name' => 'guestUser']);
        $guestUser->givePermissionTo(['view documents']);

    }
}
