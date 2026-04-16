<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $table = 'exercise';
    protected $primaryKey = 'id_exercise';
    public $timestamps = false;

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