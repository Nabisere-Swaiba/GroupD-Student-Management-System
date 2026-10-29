<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /** Records shown depend on the user's role (Q4d). */
    public function index()
    {
        $user = auth()->user();
        $registeredIds = collect();

        if ($user->can('manage courses')) {
            // Admin: all courses
            $courses = Course::with('lecturer')->withCount('students')->latest()->paginate(10);
        } elseif ($user->can('view assigned courses')) {
            // Lecturer: only their own courses
            $courses = $user->taughtCourses()->with('lecturer')->withCount('students')->latest()->paginate(10);
        } else {
            // Student: all available courses + which ones they already registered
            $courses = Course::with('lecturer')->withCount('students')->orderBy('code')->paginate(10);
            $registeredIds = $user->student
                ? $user->student->courses()->pluck('courses.id')
                : collect();
        }

        return view('courses.index', compact('courses', 'registeredIds'));
    }

    public function show(Course $course)
    {
        $user = auth()->user();

        // A lecturer may only see their own course; admin may see all
        abort_unless($user->can('manage courses') || $course->lecturer_id === $user->id, 403);

        // Q1c: students registered for this course
        $course->load('students.user', 'lecturer');

        return view('courses.show', compact('course'));
    }

    public function create()
    {
        $lecturers = User::role('lecturer')->orderBy('name')->get();
        return view('courses.create', compact('lecturers'));
    }

    public function store(Request $request)
    {
        Course::create($this->validated($request));

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        $lecturers = User::role('lecturer')->orderBy('name')->get();
        return view('courses.edit', compact('course', 'lecturers'));
    }

    public function update(Request $request, Course $course)
    {
        $course->update($this->validated($request, $course->id));

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        if ($course->registrations()->exists()) {
            return back()->with('error', 'Cannot delete a course that has registered students.');
        }

        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'code'        => ['required', 'string', 'max:20', 'unique:courses,code' . ($ignoreId ? ",$ignoreId" : '')],
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'credits'     => ['required', 'integer', 'min:1', 'max:10'],
            'lecturer_id' => ['nullable', 'exists:users,id'],
        ]);
    }
}
