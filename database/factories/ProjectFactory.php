<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->catchPhrase(),
            'client_name' => fake()->company(),
            'client_id' => null,
            'description' => fake()->sentence(15),
            'total_hours' => fake()->numberBetween(20, 150),
            'hourly_rate' => fake()->randomElement([450, 500, 550, 600, 800]),
            'status' => fake()->randomElement(['actif', 'alerte', 'termine']),
        ];
    }
}
