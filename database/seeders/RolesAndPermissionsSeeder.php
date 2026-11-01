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
        // Clear the cached roles/permissions
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            // students
            'view students', 'create students', 'edit students', 'delete students',
            // courses
            'view courses', 'create courses', 'edit courses', 'delete courses',
            'view assigned courses',     // lecturer
            'view available courses',    // student
            // registrations
            'view registrations', 'manage registrations',
            'register courses', 'view own registrations',   // student
            // users
            'manage users',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        // Administrator: everything
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web'])
            ->syncPermissions(Permission::all());

        // Lecturer: sees assigned courses and their registered students
        Role::firstOrCreate(['name' => 'lecturer', 'guard_name' => 'web'])
            ->syncPermissions(['view assigned courses']);

        // Student: sees available courses and own registrations
        Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web'])
            ->syncPermissions([
                'view available courses',
                'register courses',
                'view own registrations',
            ]);
    }
}
