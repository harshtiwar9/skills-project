<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

// Default landing page (redirect to jobs index)
Route::get('/', function () {
    return redirect()->route('jobs.index');
});

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Redirect dashboard to jobs index
    Route::get('/dashboard', function () {
        return redirect()->route('jobs.index');
    })->name('dashboard');
});

// Profile routes for authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); // Edit profile
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Update profile
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Delete profile
});

// Job-related routes
Route::middleware(['auth'])->group(function () {
    Route::resource('/jobs', JobController::class); // CRUD operations for jobs
    Route::post('/jobs/{job}/interest', [JobController::class, 'expressInterest'])->name('jobs.interest'); // Express interest in a job
    Route::post('/jobs/{job}/revert-interest', [JobController::class, 'revertInterest'])->name('jobs.revertInterest'); // Revert interest in a job
    Route::get('/inactive', [JobController::class, 'inactiveJobs'])->name('jobs.inactive'); // View inactive jobs (only for posters)
});

require __DIR__ . '/auth.php';
