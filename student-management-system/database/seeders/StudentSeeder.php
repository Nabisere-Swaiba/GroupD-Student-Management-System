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
            ['26/U/0001', 'Aisha',  'Namukasa',  'aisha.namukasa@campusdesk.test', '0772000001', '2004-03-12'],
            ['26/U/0002', 'David',  'Okello',    'david.okello@campusdesk.test',   '0772000002', '2003-11-02'],
            ['26/U/0003', 'Grace',  'Nakato',    'grace.nakato@campusdesk.test',   '0772000003', '2004-07-21'],
            ['26/U/0004', 'Brian',  'Mugisha',   'brian.mugisha@campusdesk.test',  '0772000004', '2003-01-30'],
            ['26/U/0005', 'Esther', 'Atim',      'esther.atim@campusdesk.test',    '0772000005', '2004-09-15'],
            ['26/U/0006', 'Joel',   'Ssemakula', 'joel.ssemakula@campusdesk.test', '0772000006', '2003-05-05'],
        ];

        foreach ($students as [$number, $first, $last, $email, $phone, $dob]) {
            Student::updateOrCreate(
                ['student_number' => $number],
                [
                    'user_id' => User::where('email', $email)->value('id'),
                    'first_name' => $first,
                    'last_name' => $last,
                    'email' => $email,
                    'phone' => $phone,
                    'date_of_birth' => $dob,
                    'programme' => 'Bachelor of Business Computing',
                ]
            );
        }
    }
}
