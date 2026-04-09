<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

// Public Routes
Route::get('/', function () {
    return Inertia::render('Scanner');
})->name('home');

Route::post('/attendance/scan', [StudentController::class, 'recordAttendance']);

// Login Routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Protected Admin Routes
Route::middleware('auth')->group(function () {
    
   
    Route::get('/dashboard', [StudentController::class, 'index'])->name('dashboard');
    
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{student}/print', [StudentController::class, 'printId'])->name('student.print');
    
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Temporary Registration Route
// Route::get('/setup-admin', function () {
//     if (User::where('email', 'admin@diazcollege.edu')->exists()) {
//         return "Admin already exists!";
//     }

//     User::create([
//         'name' => 'Diaz Admin',
//         'email' => 'admin@diazcollege.edu',
//         'password' => Hash::make('admin123'), 
//     ]);

//     return "Admin account created successfully!";
// });

require __DIR__.'/settings.php';