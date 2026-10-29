<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $l1 = User::where('email', 'lecturer1@university.test')->value('id');
        $l2 = User::where('email', 'lecturer2@university.test')->value('id');

        $courses = [
            ['BUC3131', 'Advanced Web Application Development', 4, $l1],
            ['BUC3102', 'Database Systems',                      3, $l1],
            ['BUC3203', 'Systems Analysis and Design',           3, $l2],
            ['BUC3304', 'Information Systems Security',          3, $l2],
        ];

        foreach ($courses as [$code, $title, $credits, $lecturerId]) {
            Course::firstOrCreate(
                ['code' => $code],
                [
                    'title' => $title,
                    'credits' => $credits,
                    'lecturer_id' => $lecturerId,
                    'description' => "Course unit: $title",
                ]
            );
        }
    }
}
