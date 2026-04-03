<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Inertia\Inertia;

class ExerciseController extends Controller
{
    public function index()
    {
        $individualExercises = Exercise::where('is_individual', true)->get();
        $teamExercises = Exercise::where('is_individual', false)->get();

        return Inertia::render('Dashboard', [
            'individualExercises' => $individualExercises,
            'teamExercises' => $teamExercises,
        ]);
    }
}