<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class RegistrationController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view registrations|view own registrations', only: ['index']),
            new Middleware('permission:manage registrations', only: ['create']),
            new Middleware('permission:manage registrations|register courses', only: ['store', 'destroy']),
        ];
    }

    public function index()
    {
        $user = auth()->user();

        $query = CourseRegistration::with(['student', 'course.lecturer'])->latest('registered_at');

        if ($user->can('view registrations')) {
            $heading = 'All course registrations';
        } else {
            // students only ever see THEIR OWN registrations
            $student = $user->student;
            abort_unless($student, 403, 'Your account has no student profile.');
            $query->where('student_id', $student->id);
            $heading = 'My registrations';
        }

        $registrations = $query->paginate(10);

        return view('registrations.index', compact('registrations', 'heading'));
    }

    /** Admin form: register any student for any course. */
    public function create()
    {
        return view('registrations.create', [
            'students' => Student::orderBy('last_name')->get(),
            'courses' => Course::orderBy('code')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user->can('manage registrations');

        if ($isAdmin) {
            $request->validate(['student_id' => ['required', 'exists:students,id']]);
            $studentId = (int) $request->input('student_id');
        } else {
            // a student can only register THEMSELVES
            if (! $user->student) {
                return back()->with('error', 'Your account has no student profile. Please contact the administrator.');
            }
            $studentId = $user->student->id;
        }

        $request->validate(
            [
                'course_id' => [
                    'required',
                    'exists:courses,id',
                    // duplicate-registration prevention
                    Rule::unique('course_registrations', 'course_id')->where('student_id', $studentId),
                ],
            ],
            ['course_id.unique' => 'This student is already registered for that course.']
        );

        $course = Course::findOrFail($request->input('course_id'));

        if ($course->isFull()) {
            return back()->withInput()->with('error', "{$course->code} is full. Registration was not completed.");
        }

        CourseRegistration::create([
            'student_id' => $studentId,
            'course_id' => $course->id,
            'registered_at' => now(),
        ]);

        $route = $isAdmin ? 'registrations.index' : 'courses.index';

        return redirect()->route($route)
            ->with('success', "Registered for {$course->code} - {$course->title}.");
    }

    public function destroy(CourseRegistration $registration)
    {
        // admins: any registration; students: only their own
        Gate::authorize('delete', $registration);

        $registration->delete();

        return back()->with('success', 'Registration removed.');
    }
}
