<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('jobs', \App\Http\Controllers\JobController::class)
    ->middleware(['auth', 'verified'])
    ->except(['index', 'show']);
Route::get('/jobs', [\App\Http\Controllers\JobController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('jobs.index');
Route::get('/jobs/{job}', [\App\Http\Controllers\JobController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('jobs.show');
Route::post('/jobs/{job}/interested', [JobController::class, 'expressInterest'])->name('jobs.interest')
    ->middleware(['auth', 'verified'])
    ->name('jobs.interested');

require __DIR__.'/auth.php';
