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

    // Jobs resource routes
    Route::resource('/jobs', JobController::class);
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Express interest in a job
Route::post('/jobs/{job}/interest', [JobController::class, 'expressInterest'])
    ->middleware(['auth', 'verified'])
    ->name('jobs.interest');

// Revert interest in a job
Route::post('/jobs/{job}/revert-interest', [JobController::class, 'revertInterest'])
    ->middleware(['auth'])
    ->name('jobs.revertInterest');

// Inactive jobs
Route::middleware(['auth'])->group(function () {
    Route::get('/inactive', [JobController::class, 'inactiveJobs'])->name('jobs.inactive');
});


require __DIR__ . '/auth.php';
