<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuditLogFactory extends Factory
{
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'user_id' => User::factory(),
            'action' => fake()->randomElement(['user.created', 'user.updated', 'training.assigned', 'module.created']),
            'details' => fake()->sentence(),
        ];
    }
}
