<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition(): array
    {
        return [
            'project_id' => null,
            'user_id' => null,
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'type' => $this->faker->randomElement(['inclus', 'facturable']),
            'status' => $this->faker->randomElement(['nouveau', 'en_cours', 'en_attente', 'a_valider', 'valide', 'refuse']),
        ];
    }
}
