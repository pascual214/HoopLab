<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
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

    public function create()
    {
        return Inertia::render('Exercises/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'type' => 'nullable|string|max:100',
            'difficulty' => 'nullable|in:facil,intermedio,dificil',
            'is_individual' => 'sometimes|boolean',
        ]);

        $exerciseData = [
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'type' => $validated['type'] ?? null,
            'difficulty' => $validated['difficulty'] ?? null,
            'created_by' => Auth::user()->name ?? Auth::user()->email,
            'id_user' => Auth::id(),
        ];

        if (Schema::hasColumn('exercise', 'is_individual')) {
            $exerciseData['is_individual'] = $validated['is_individual'] ?? false;
        }

        Exercise::create($exerciseData);

        return redirect()->route('dashboard');
    }
}