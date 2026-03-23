<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Admin ESN',
            'email' => 'admin@esn.test',
        ]);

        $clients = User::factory()->count(4)->client()->create();
        $consultants = User::factory()->count(6)->consultant()->create();

        $projects = collect();

        foreach ($clients as $client) {
            $clientProjects = Project::factory()
                ->count(3)
                ->create([
                    'client_id' => $client->id,
                    'client_name' => $client->name,
                ]);

            foreach ($clientProjects as $project) {
                $project->consultants()->attach(
                    $consultants->random(rand(1, 3))->pluck('id')->all()
                );
            }

            $projects = $projects->merge($clientProjects);
        }

        foreach (range(1, 40) as $index) {
            Ticket::factory()->create([
                'project_id' => $projects->random()->id,
            ]);
        }
    }
}
