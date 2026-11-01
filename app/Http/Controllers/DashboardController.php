<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Student;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $data = [];

        if ($user->can('view students')) {                 // administrator
            $mode = 'admin';
            $data['stats'] = [
                'students' => Student::count(),
                'courses' => Course::count(),
                'registrations' => CourseRegistration::count(),
                'users' => User::count(),
            ];
            $data['latest'] = CourseRegistration::with(['student', 'course'])
                ->latest('registered_at')->take(6)->get();
        } elseif ($user->can('view assigned courses')) {   // lecturer
            $mode = 'lecturer';
            $data['courses'] = $user->courses()->withCount('students')->get();
        } else {                                           // student
            $mode = 'student';
            $student = $user->student;
            $data['student'] = $student;
            $data['myCourses'] = $student
                ? $student->courses()->with('lecturer')->get()
                : collect();
        }

        return view('dashboard', array_merge(['mode' => $mode], $data));
    }
}
