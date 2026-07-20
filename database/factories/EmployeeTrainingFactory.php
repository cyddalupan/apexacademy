<?php

namespace Database\Factories;

use App\Models\TrainingModule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeTrainingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'employee_id' => User::factory()->employee(),
            'training_module_id' => TrainingModule::factory(),
            'status' => 'assigned',
            'failed_attempts' => 0,
        ];
    }

    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'in_progress',
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
        ]);
    }

    public function flagged(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'flagged',
            'failed_attempts' => 5,
        ]);
    }
}
