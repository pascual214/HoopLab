<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\Auth\PasswordController;

Route::get('/', function () {
    return Inertia::render('LandingPage', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->middleware(['guest'])->name('landing');

Route::get('/dashboard', [ExerciseController::class, 'index'])
->middleware(['auth', 'verified'])
->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/trainings', [\App\Http\Controllers\TrainingController::class, 'store'])
        ->name('trainings.store');

    Route::get('/trainings/{training}', [\App\Http\Controllers\TrainingController::class, 'show'])
        ->name('trainings.show');

    Route::get('/exercises/create', [ExerciseController::class, 'create'])
        ->name('exercises.create');

    Route::post('/exercises', [ExerciseController::class, 'store'])
        ->name('exercises.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/picture', [ProfileController::class, 'updatePicture'])->name('profile.picture.update');
});

Route::put('password', [PasswordController::class, 'update'])->name('password.update');

require __DIR__.'/auth.php';
