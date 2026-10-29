<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Registration;
use App\Models\Student;
use Illuminate\Database\Seeder;

class RegistrationSeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            'STU/2026/001' => ['BUC3131', 'BUC3102'],
            'STU/2026/002' => ['BUC3131', 'BUC3203'],
            'STU/2026/003' => ['BUC3102', 'BUC3304'],
            'STU/2026/004' => ['BUC3131'],
            'STU/2026/005' => ['BUC3203', 'BUC3304'],
        ];

        foreach ($map as $number => $codes) {
            $student = Student::where('student_number', $number)->first();
            foreach ($codes as $code) {
                $course = Course::where('code', $code)->first();
                if ($student && $course) {
                    Registration::firstOrCreate(
                        ['student_id' => $student->id, 'course_id' => $course->id],
                        ['registered_at' => now()]
                    );
                }
            }
        }
    }
}
