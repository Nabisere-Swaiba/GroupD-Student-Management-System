<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            ['Alice Namatovu', 'alice@student.test',  'STU/2026/001', 'BBC'],
            ['Brian Mukasa',   'brian@student.test',  'STU/2026/002', 'BBC'],
            ['Carol Atim',     'carol@student.test',  'STU/2026/003', 'BOIM'],
            ['David Ssebuufu', 'david@student.test',  'STU/2026/004', 'BBC'],
            ['Esther Achieng', 'esther@student.test', 'STU/2026/005', 'BOIM'],
        ];

        foreach ($students as [$name, $email, $number, $programme]) {
            $user = User::firstOrCreate(
                ['email' => $email],
                ['name' => $name, 'password' => 'password']
            );
            $user->syncRoles(['student']);

            Student::firstOrCreate(
                ['student_number' => $number],
                ['user_id' => $user->id, 'programme' => $programme]
            );
        }
    }
}
