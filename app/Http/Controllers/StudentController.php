<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('user')->latest()->paginate(10);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'email', 'max:255', 'unique:users,email'],
            'student_number' => ['required', 'string', 'max:50', 'unique:students,student_number'],
            'programme'      => ['required', 'string', 'max:100'],
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => 'password', // default password, hashed by cast
            ]);
            $user->assignRole('student');

            Student::create([
                'user_id'        => $user->id,
                'student_number' => $data['student_number'],
                'programme'      => $data['programme'],
            ]);
        });

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function edit(Student $student)
    {
        $student->load('user');
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($student->user_id)],
            'student_number' => ['required', 'string', 'max:50', Rule::unique('students', 'student_number')->ignore($student->id)],
            'programme'      => ['required', 'string', 'max:100'],
        ]);

        DB::transaction(function () use ($data, $student) {
            $student->user->update(['name' => $data['name'], 'email' => $data['email']]);
            $student->update([
                'student_number' => $data['student_number'],
                'programme'      => $data['programme'],
            ]);
        });

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        // Deleting the user cascades to the student and their registrations
        $student->user->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
