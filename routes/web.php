<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\AttendanceController;
use Inertia\Inertia;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::get('/', function () {
    return Inertia::render('Scanner');
});

Route::post('/attendance/scan', [StudentController::class, 'recordAttendance']);

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// 2. Protected Routes (Must be logged in)
Route::middleware('auth')->group(function () {
    
    // THIS IS THE FIX: Point this to your Controller, not a closure
    Route::get('/dashboard', [StudentController::class, 'index'])->name('dashboard');
    
    Route::post('/students', [StudentController::class, 'store']);
    Route::get('/students/{student}/print', [StudentController::class, 'printId'])->name('student.print');
    
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
});

// Temporary Registration Route (Remove in production)
Route::get('/setup-admin', function () {
    // Check if the user already exists to avoid duplicates
    if (User::where('email', 'admin@diazcollege.edu')->exists()) {
        return "Admin already exists!";
    }

    User::create([
        'name' => 'Diaz Admin',
        'email' => 'admin@diazcollege.edu',
        'password' => Hash::make('admin'), 
    ]);

    return "Admin account created successfully!";
});

require __DIR__.'/settings.php';