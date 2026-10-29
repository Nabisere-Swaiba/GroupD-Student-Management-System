<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Registration;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegistrationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->can('manage registrations')) {
            $registrations = Registration::with(['student.user', 'course'])->latest()->paginate(15);
        } else {
            // Students only ever see their OWN registrations
            abort_unless($user->student, 403);
            $registrations = Registration::with('course')
                ->where('student_id', $user->student->id)
                ->latest()->paginate(15);
        }

        return view('registrations.index', compact('registrations'));
    }

    public function create()
    {
        $courses  = Course::orderBy('code')->get();
        $students = auth()->user()->can('manage registrations')
            ? Student::with('user')->orderBy('student_number')->get()
            : collect();

        return view('registrations.create', compact('courses', 'students'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        // Decide WHICH student is being registered
        if ($user->can('manage registrations')) {
            $request->validate(['student_id' => ['required', 'exists:students,id']]);
            $studentId = (int) $request->student_id;
        } else {
            abort_unless($user->student, 403);
            $studentId = $user->student->id;      // students can only register themselves
        }

        $validator = Validator::make($request->all(), [
            'course_id' => [
                'required',
                'exists:courses,id',
                // duplicate-registration prevention
                Rule::unique('registrations', 'course_id')->where('student_id', $studentId),
            ],
        ], [
            'course_id.unique' => 'This student is already registered for the selected course.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Registration::create([
            'student_id'    => $studentId,
            'course_id'     => $request->course_id,
            'registered_at' => now(),
        ]);

        return redirect()->route('registrations.index')->with('success', 'Course registration successful.');
    }

    public function destroy(Registration $registration)
    {
        $user = auth()->user();

        // Only admin, or the owner of the registration, may remove it
        abort_unless(
            $user->can('manage registrations') || optional($user->student)->id === $registration->student_id,
            403
        );

        $registration->delete();

        return back()->with('success', 'Registration removed.');
    }
}
