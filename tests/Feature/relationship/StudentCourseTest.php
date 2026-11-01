<?php

namespace Tests\Feature\Relationship;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentCourseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_retrieve_a_students_registered_courses_and_vice_versa()
    {
        // 1. Create student matching your table columns
        $student = Student::create([
            'student_number' => 'S2026/001',
            'first_name' => 'Swaiba',
            'last_name' => 'Natukwatsa',
            'email' => 'natukwatsa@example.com',
        ]);

        // 2. Use 'title' to match your courses table schema
        $course = Course::create([
            'code' => 'BUC3131',
            'title' => 'Advanced Web Application Development',
        ]);

        // 3. Register the student for the course
        $student->courses()->attach($course->id);

        // 4. Assert Student -> Courses relationship works (Question 1c)
        $this->assertTrue($student->courses->contains($course));
        $this->assertEquals(1, $student->courses->count());
        $this->assertEquals('BUC3131', $student->courses->first()->code);

        // 5. Assert Course -> Students relationship works (Question 1c)
        $this->assertTrue($course->students->contains($student));
        $this->assertEquals(1, $course->students->count());
        $this->assertEquals('Swaiba', $course->students->first()->first_name);
    }

    /** @test */
    public function it_prevents_duplicate_course_registrations()
    {
        // Expect a database query exception due to unique composite foreign keys (Question 1d)
        $this->expectException(QueryException::class);

        $student = Student::create([
            'student_number' => 'S2026/002',
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane@example.com',
        ]);

        $course = Course::create([
            'code' => 'BUC3132',
            'title' => 'Database Systems',
        ]);

        // First registration attempt (Should succeed)
        $student->courses()->attach($course->id);

        // Duplicate registration attempt (Should throw a unique constraint violation)
        $student->courses()->attach($course->id);
    }
}