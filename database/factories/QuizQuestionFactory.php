<?php

namespace Database\Factories;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizQuestionFactory extends Factory
{
    public function definition(): array
    {
        $options = [
            'A' => fake()->sentence(),
            'B' => fake()->sentence(),
            'C' => fake()->sentence(),
            'D' => fake()->sentence(),
        ];

        return [
            'lesson_id' => Lesson::factory(),
            'question_text' => fake()->sentence(),
            'options' => $options,
            'correct_answer' => 'A',
            'sort_order' => fake()->numberBetween(1, 5),
        ];
    }
}
