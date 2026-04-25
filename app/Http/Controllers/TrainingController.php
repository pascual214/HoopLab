<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\TrainingExercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'duration' => 'nullable|integer|min:1',
            'exercises' => 'required|array|min:1',
            'exercises.*.id_exercise' => 'required|integer|exists:exercise,id_exercise',
            'exercises.*.order' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            $training = Training::create([
                'id_user' => auth()->id(),
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'duration' => $validated['duration'] ?? null,
                'created_by' => auth()->user()->name,
            ]);

            $rows = collect($validated['exercises'])->map(function ($exercise) use ($training) {
                return [
                    'id_training' => $training->id_training,
                    'id_exercise' => $exercise['id_exercise'],
                    'order' => $exercise['order'],
                ];
            })->toArray();

            TrainingExercise::insert($rows);
        });

        return redirect()->back()->with('success', 'Entrenamiento guardado correctamente.');
    }
}
