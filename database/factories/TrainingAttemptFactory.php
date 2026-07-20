<?php

namespace Database\Factories;

use App\Models\EmployeeTraining;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrainingAttemptFactory extends Factory
{
    public function definition(): array
    {
        return [
            'employee_training_id' => EmployeeTraining::factory(),
            'lesson_id' => Lesson::factory(),
            'attempt_number' => 1,
            'score' => fake()->numberBetween(0, 100),
            'passed' => false,
        ];
    }

    public function passed(): static
    {
        return $this->state(fn (array $attributes) => [
            'passed' => true,
            'score' => fake()->numberBetween(80, 100),
        ]);
    }
}
