<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingExercise extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $table = 'exercise_training';
    protected $primaryKey = null;

    protected $fillable = [
        'id_training',
        'id_exercise',
        'order',
    ];

    public function training()
    {
        return $this->belongsTo(Training::class, 'id_training', 'id_training');
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class, 'id_exercise', 'id_exercise');
    }
}
