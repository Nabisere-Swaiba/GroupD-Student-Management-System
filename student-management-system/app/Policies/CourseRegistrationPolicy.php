<?php

namespace App\Policies;

use App\Models\CourseRegistration;
use App\Models\User;

class CourseRegistrationPolicy
{
    /** Admins can remove any registration; students only their own. */
    public function delete(User $user, CourseRegistration $registration): bool
    {
        if ($user->can('manage registrations')) {
            return true;
        }

        return $user->can('register courses')
            && $user->student
            && $registration->student_id === $user->student->id;
    }
}
