<?php

namespace Database\Factories;

use App\Models\TrainingModule;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonFactory extends Factory
{
    public function definition(): array
    {
        return [
            'training_module_id' => TrainingModule::factory(),
            'title' => fake()->sentence(4),
            'content_body' => fake()->paragraphs(3, true),
            'sort_order' => fake()->numberBetween(1, 10),
        ];
    }
}
