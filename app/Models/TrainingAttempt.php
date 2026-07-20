<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_training_id',
        'lesson_id',
        'attempt_number',
        'score',
        'passed',
    ];

    protected function casts(): array
    {
        return [
            'passed' => 'boolean',
            'attempted_at' => 'datetime',
        ];
    }

    public function training(): BelongsTo
    {
        return $this->belongsTo(EmployeeTraining::class, 'employee_training_id');
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
