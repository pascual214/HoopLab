<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $table = 'training';
    protected $primaryKey = 'id_training';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'name',
        'description',
        'duration',
        'created_by',
    ];

    public function exercises()
    {
        return $this->hasMany(TrainingExercise::class, 'id_training', 'id_training')
            ->orderBy('order');
    }
}
