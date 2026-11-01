<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Student;
use Illuminate\Database\Seeder;

class CourseRegistrationSeeder extends Seeder
{
    public function run(): void
    {
        // student number => course codes
        $map = [
            '26/U/0001' => ['BUC3131', 'BUC3122', 'BUC3103'],
            '26/U/0002' => ['BUC3131', 'BUC3114'],
            '26/U/0003' => ['BUC3131', 'BUC3103', 'BUC3125'],
            '26/U/0004' => ['BUC3122', 'BUC3114'],
            '26/U/0005' => ['BUC3131', 'BUC3125'],
            '26/U/0006' => ['BUC3103'],
        ];

        foreach ($map as $number => $codes) {
            $student = Student::where('student_number', $number)->first();
            if (! $student) {
                continue;
            }

            foreach ($codes as $code) {
                $course = Course::where('code', $code)->first();
                if (! $course) {
                    continue;
                }

                // firstOrCreate => no duplicate registrations when re-seeding
                CourseRegistration::firstOrCreate(
                    ['student_id' => $student->id, 'course_id' => $course->id],
                    ['registered_at' => now()]
                );
            }
        }
    }
}
