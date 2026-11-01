<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class CourseController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view courses|view assigned courses|view available courses', only: ['index', 'show']),
            new Middleware('permission:create courses', only: ['create', 'store']),
            new Middleware('permission:edit courses', only: ['edit', 'update']),
            new Middleware('permission:delete courses', only: ['destroy']),
        ];
    }

    /** Records shown depend on the role of the logged-in user. */
    public function index()
    {
        $user = auth()->user();

        $query = Course::with('lecturer')->withCount('students')->orderBy('code');

        if ($user->can('view courses')) {
            $heading = 'All courses';
        } elseif ($user->can('view assigned courses')) {
            $query->where('lecturer_id', $user->id);
            $heading = 'My assigned courses';
        } else {
            $heading = 'Available courses';
        }

        $courses = $query->paginate(10);

        // ids of courses the logged-in student already registered for
        $registeredIds = $user->student
            ? $user->student->registrations()->pluck('course_id')->all()
            : [];

        return view('courses.index', compact('courses', 'heading', 'registeredIds'));
    }

    public function create()
    {
        return view('courses.create', ['lecturers' => $this->lecturers()]);
    }

    public function store(Request $request)
    {
        Course::create($this->validated($request));

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        // Lecturers cannot open courses that belong to other lecturers
        Gate::authorize('view', $course);

        $course->load('lecturer');
        $canSeeStudents = auth()->user()->can('viewStudents', $course);

        // Eloquent: students registered for this course
        $students = $canSeeStudents ? $course->students()->orderBy('last_name')->get() : collect();

        $isRegistered = false;
        if ($student = auth()->user()->student) {
            $isRegistered = $student->registrations()->where('course_id', $course->id)->exists();
        }

        return view('courses.show', compact('course', 'students', 'canSeeStudents', 'isRegistered'));
    }

    public function edit(Course $course)
    {
        return view('courses.edit', [
            'course' => $course,
            'lecturers' => $this->lecturers(),
        ]);
    }

    public function update(Request $request, Course $course)
    {
        $course->update($this->validated($request, $course));

        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    private function lecturers()
    {
        return User::role('lecturer')->orderBy('name')->get();
    }

    private function validated(Request $request, ?Course $course = null): array
    {
        return $request->validate([
            'code' => ['required', 'string', 'max:20', Rule::unique('courses', 'code')->ignore($course?->id)],
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:2000'],
            'credit_units' => ['required', 'integer', 'between:1,10'],
            'capacity' => ['required', 'integer', 'between:1,500'],
            'lecturer_id' => ['nullable', 'exists:users,id'],
        ]);
    }
}
