<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public landing page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Guests only
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

// Authenticated users. Per-action permissions are enforced inside each controller
// (HasMiddleware) using the spatie "permission:" middleware.
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('students', StudentController::class);
    Route::resource('courses', CourseController::class);

    Route::resource('registrations', RegistrationController::class)
        ->only(['index', 'create', 'store', 'destroy']);

    Route::resource('users', UserController::class)
        ->only(['index', 'edit', 'update']);
});
