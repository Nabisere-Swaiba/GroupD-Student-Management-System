<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'view students',
            'create students',
            'edit students',
            'delete students',
            'view courses',
            'create courses',
            'edit courses',
            'delete courses',
            'view assigned courses',
            'view available courses',
            'view registrations',
            'manage registrations',
            'register courses',
            'view own registrations',
            'manage users',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web',
            ]);
        }

        // Admin gets all permissions
        Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ])->syncPermissions(Permission::all());

        // Lecturer permissions
        Role::firstOrCreate([
            'name' => 'lecturer',
            'guard_name' => 'web',
        ])->syncPermissions([
            'view assigned courses',
        ]);

        // Student permissions
        Role::firstOrCreate([
            'name' => 'student',
            'guard_name' => 'web',
        ])->syncPermissions([
            'view available courses',
            'register courses',
            'view own registrations',
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}