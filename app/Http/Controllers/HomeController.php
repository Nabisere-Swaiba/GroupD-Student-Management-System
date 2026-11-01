<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Student;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'students' => Student::count(),
            'courses' => Course::count(),
            'registrations' => CourseRegistration::count(),
            'lecturers' => User::whereHas('roles', fn ($q) => $q->where('name', 'lecturer'))->count(),
        ];

        $lecturers = User::whereHas('roles', fn ($q) => $q->where('name', 'lecturer'))
            ->with(['courses' => fn ($q) => $q->withCount('students')])
            ->orderBy('name')
            ->get();

        return view('home', compact('stats', 'lecturers'));
    }
}
