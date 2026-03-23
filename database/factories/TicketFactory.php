<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // On ne met PLUS de Project::factory() ici.
            // Si on oublie de donner un ID dans le seeder, ça plantera.
            'project_id' => null, 
            
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'hours_spent' => fake()->randomFloat(2, 0.5, 8),
            'type' => fake()->randomElement(['inclus', 'facturable']),
            'status' => fake()->randomElement(['ouvert', 'en cours', 'ferme']),
        ];
    }
}
