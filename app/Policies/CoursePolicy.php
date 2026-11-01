<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    /**
     * Admin: any course. Lecturer: only courses assigned to them.
     * Student: any available course.
     */
    public function view(User $user, Course $course): bool
    {
        if ($user->can('view courses')) {
            return true;
        }

        if ($user->can('view assigned courses')) {
            return $course->lecturer_id === $user->id;
        }

        return $user->can('view available courses');
    }

    /** Only admins and the course's own lecturer may see who registered. */
    public function viewStudents(User $user, Course $course): bool
    {
        return $user->can('view courses')
            || ($user->can('view assigned courses') && $course->lecturer_id === $user->id);
    }
}
