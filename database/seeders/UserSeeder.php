<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['Admin User',        'admin@university.test',     'admin'],
            ['Dr. Grace Nakato',  'lecturer1@university.test', 'lecturer'],
            ['Mr. Peter Okello',  'lecturer2@university.test', 'lecturer'],
        ];

        foreach ($users as [$name, $email, $role]) {
            // firstOrCreate => running the seeder twice creates no duplicates
            $user = User::firstOrCreate(
                ['email' => $email],
                ['name' => $name, 'password' => 'password']   // hashed by model cast
            );
            $user->syncRoles([$role]);
        }
    }
}
