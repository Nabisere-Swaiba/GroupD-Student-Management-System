<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            // [name, email, role]
            ['System Administrator', 'admin@campusdesk.test', 'admin'],

            ['Dr. Peter Tumusiime', 'peter.tumusiime@campusdesk.test', 'lecturer'],
            ['Ms. Sarah Nabirye',   'sarah.nabirye@campusdesk.test',   'lecturer'],
            ['Mr. Daniel Kato',     'daniel.kato@campusdesk.test',     'lecturer'],

            ['Aisha Namukasa', 'aisha.namukasa@campusdesk.test', 'student'],
            ['David Okello',   'david.okello@campusdesk.test',   'student'],
            ['Grace Nakato',   'grace.nakato@campusdesk.test',   'student'],
            ['Brian Mugisha',  'brian.mugisha@campusdesk.test',  'student'],
            ['Esther Atim',    'esther.atim@campusdesk.test',    'student'],
            ['Joel Ssemakula', 'joel.ssemakula@campusdesk.test', 'student'],
        ];

        foreach ($accounts as [$name, $email, $role]) {
            // updateOrCreate => running the seeder twice never duplicates users
            $user = User::updateOrCreate(
                ['email' => $email],
                ['name' => $name, 'password' => 'password']   // hashed by the model cast
            );
            $user->syncRoles([$role]);
        }
    }
}
