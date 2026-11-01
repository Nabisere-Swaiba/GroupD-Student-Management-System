<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StudentController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view students', only: ['index', 'show']),
            new Middleware('permission:create students', only: ['create', 'store']),
            new Middleware('permission:edit students', only: ['edit', 'update']),
            new Middleware('permission:delete students', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $search = trim((string) $request->query('search'));

        $students = Student::query()
            ->withCount('courses')
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('student_number', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('last_name')
            ->paginate(10)
            ->withQueryString();

        return view('students.index', compact('students', 'search'));
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
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'student_number' => ['required', 'string', 'max:30', Rule::unique('students', 'student_number')->ignore($student->id)],
            'first_name' => ['required', 'string', 'max:80'],
            'last_name' => ['required', 'string', 'max:80'],
            'email' => [
                'required', 'email', 'max:150',
                Rule::unique('students', 'email')->ignore($student->id),
                Rule::unique('users', 'email')->ignore($student->user_id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'programme' => ['nullable', 'string', 'max:150'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        DB::transaction(function () use ($data, $student) {
            $student->update(collect($data)->except('password')->all());

            if ($student->user) {
                $student->user->name = $data['first_name'] . ' ' . $data['last_name'];
                $student->user->email = $data['email'];
                if (! empty($data['password'])) {
                    $student->user->password = $data['password'];
                }
                $student->user->save();
            }
        });

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        DB::transaction(function () use ($student) {
            $user = $student->user;
            $student->delete();      // registrations are removed by the cascade
            $user?->delete();
        });

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }
}
