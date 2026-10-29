<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'manage students',
            'manage courses',
            'manage registrations',
            'manage users',
            'view assigned courses',
            'view available courses',
            'view own registrations',
            'register courses',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        // Administrator: everything
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web'])
            ->syncPermissions(Permission::all());

        // Lecturer: assigned courses + their registered students
        Role::firstOrCreate(['name' => 'lecturer', 'guard_name' => 'web'])
            ->syncPermissions(['view assigned courses']);

        // Student: available courses + own registrations
        Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web'])
            ->syncPermissions(['view available courses', 'view own registrations', 'register courses']);
    }
}
