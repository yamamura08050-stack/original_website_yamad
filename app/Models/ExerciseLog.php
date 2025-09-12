<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'exercise_id',
        'weight',
        'reps',
    ];

    public function getDisplayWeightAttribute()
    {
        $user = auth()->user();

        if ($user && $user->unit === 'lbs') {
            return round($this->weight / 0.453592, 1); // kg → lbs
        }

        return $this->weight; // そのままkg
    }
}
