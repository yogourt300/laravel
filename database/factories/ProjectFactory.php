<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'client_id' => null,
            'name' => fake()->catchPhrase(),
            'description' => fake()->sentence(15),
            'status' => fake()->randomElement(['actif', 'alerte', 'termine']),
        ];
    }
}
