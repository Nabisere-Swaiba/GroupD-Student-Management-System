<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $lecturer = fn (string $email) => User::where('email', $email)->value('id');

        $courses = [
            [
                'code' => 'BUC3131',
                'title' => 'Advanced Web Application Development',
                'description' => 'Building database-driven web applications with Laravel, Eloquent, authentication, roles and permissions.',
                'credit_units' => 4, 'capacity' => 40,
                'lecturer_id' => $lecturer('peter.tumusiime@campusdesk.test'),
            ],
            [
                'code' => 'BUC3122',
                'title' => 'Database Administration',
                'description' => 'Relational design, indexing, transactions, backup and performance tuning.',
                'credit_units' => 3, 'capacity' => 45,
                'lecturer_id' => $lecturer('sarah.nabirye@campusdesk.test'),
            ],
            [
                'code' => 'BUC3103',
                'title' => 'Software Engineering',
                'description' => 'Requirements, design patterns, testing, version control and team collaboration.',
                'credit_units' => 4, 'capacity' => 50,
                'lecturer_id' => $lecturer('daniel.kato@campusdesk.test'),
            ],
            [
                'code' => 'BUC3114',
                'title' => 'Business Analytics',
                'description' => 'Turning business data into decisions using dashboards and basic statistics.',
                'credit_units' => 3, 'capacity' => 35,
                'lecturer_id' => $lecturer('sarah.nabirye@campusdesk.test'),
            ],
            [
                'code' => 'BUC3125',
                'title' => 'Information Systems Security',
                'description' => 'Threats, access control, secure coding and risk management.',
                'credit_units' => 3, 'capacity' => 30,
                'lecturer_id' => $lecturer('peter.tumusiime@campusdesk.test'),
            ],
        ];

        foreach ($courses as $course) {
            Course::updateOrCreate(['code' => $course['code']], $course);
        }
    }
}
