<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'train_date',
        'user_id',
        'exercise_name',
        

    ];

    public function logs()
    {
        return $this->hasMany(ExerciseLog::class, 'exercise_id');
    }
}
