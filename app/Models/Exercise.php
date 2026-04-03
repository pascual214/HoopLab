<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $table = 'exercise'; // importante si tu tabla NO es 'exercises'

    protected $primaryKey = 'id_exercise'; // porque no usas 'id'

    public $timestamps = false; // si no tienes created_at / updated_at

    protected $fillable = [
        'title',
        'description',
        'type',
        'difficulty',
        'created_by',
        'id_user',
        'is_individual',
    ];
}