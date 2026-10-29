<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StudentController;
use App\Models\Course;
use App\Models\Registration;
use App\Models\Student;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('dashboard'));

// Jetstream convention: Sanctum auth + session guard (no 'verified' so seeded users can log in)
Route::middleware(['auth:sanctum', config('jetstream.auth_session')])->group(function () {

    Route::get('/dashboard', function () {
        $user = auth()->user();
        $stats = [];

        if ($user->can('manage students')) {
            $stats = [
                'Students'      => Student::count(),
                'Courses'       => Course::count(),
                'Registrations' => Registration::count(),
            ];
        } elseif ($user->can('view assigned courses')) {
            $stats = ['My courses' => $user->taughtCourses()->count()];
        } elseif ($user->student) {
            $stats = [
                'Available courses' => Course::count(),
                'My registrations'  => $user->student->registrations()->count(),
            ];
        }

        return view('dashboard', compact('stats'));
    })->name('dashboard');

    // ---- Students: admin only ----
    Route::resource('students', StudentController::class)
        ->except('show')
        ->middleware('permission:manage students');

    // ---- Courses ----
    // Admin-only management routes (declared BEFORE courses/{course})
    Route::middleware('permission:manage courses')->group(function () {
        Route::resource('courses', CourseController::class)->except(['index', 'show']);
    });

    // Anyone with a course-viewing permission (content filtered by role in controller)
    Route::get('courses', [CourseController::class, 'index'])
        ->middleware('permission:manage courses|view assigned courses|view available courses')
        ->name('courses.index');

    // Admin + lecturer (lecturer restricted to own course inside controller)
    Route::get('courses/{course}', [CourseController::class, 'show'])
        ->middleware('permission:manage courses|view assigned courses')
        ->name('courses.show');

    // ---- Registrations ----
    Route::get('registrations', [RegistrationController::class, 'index'])
        ->middleware('permission:manage registrations|view own registrations')
        ->name('registrations.index');

    Route::middleware('permission:manage registrations|register courses')->group(function () {
        Route::get('registrations/create', [RegistrationController::class, 'create'])->name('registrations.create');
        Route::post('registrations', [RegistrationController::class, 'store'])->name('registrations.store');
        Route::delete('registrations/{registration}', [RegistrationController::class, 'destroy'])->name('registrations.destroy');
    });
});
