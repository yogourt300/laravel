<?php

namespace Database\Seeders;

use App\Models\Contract;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\TimeEntry;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->create([
            'name'     => 'Admin',
            'email'    => 'admin@test.com',
            'role'     => 'admin',
            'password' => bcrypt('password'),
        ]);

        $collab1 = User::factory()->create([
            'name'     => 'Alice Collaborateur',
            'email'    => 'collab1@test.com',
            'role'     => 'collaborateur',
            'password' => bcrypt('password'),
        ]);

        $collab2 = User::factory()->create([
            'name'     => 'Bob Collaborateur',
            'email'    => 'collab2@test.com',
            'role'     => 'collaborateur',
            'password' => bcrypt('password'),
        ]);

        $client1 = User::factory()->create([
            'name'     => 'Client Acme',
            'email'    => 'client1@test.com',
            'role'     => 'client',
            'password' => bcrypt('password'),
        ]);

        $client2 = User::factory()->create([
            'name'     => 'Client Globex',
            'email'    => 'client2@test.com',
            'role'     => 'client',
            'password' => bcrypt('password'),
        ]);

        $clients = collect([$client1, $client2]);
        $collabs = collect([$collab1, $collab2]);

        $project1 = Project::create(['name' => 'Migration Cloud Acme', 'client_id' => $client1->id, 'description' => 'Migration de l\'infrastructure vers AWS.', 'status' => 'actif']);
        $project2 = Project::create(['name' => 'Refonte Site Acme', 'client_id' => $client1->id, 'description' => 'Nouveau site vitrine responsive.', 'status' => 'actif']);
        $project3 = Project::create(['name' => 'ERP Globex', 'client_id' => $client2->id, 'description' => 'Déploiement ERP interne.', 'status' => 'actif']);
        $project4 = Project::create(['name' => 'Application Mobile Globex', 'client_id' => $client2->id, 'description' => 'App mobile iOS/Android.', 'status' => 'alerte']);

        $project1->collaborateurs()->attach([$collab1->id, $collab2->id]);
        $project2->collaborateurs()->attach([$collab1->id]);
        $project3->collaborateurs()->attach([$collab2->id]);
        $project4->collaborateurs()->attach([$collab1->id, $collab2->id]);

        Contract::create(['project_id' => $project1->id, 'included_hours' => 50, 'extra_hourly_rate' => 500]);
        Contract::create(['project_id' => $project2->id, 'included_hours' => 20, 'extra_hourly_rate' => 450]);
        Contract::create(['project_id' => $project3->id, 'included_hours' => 80, 'extra_hourly_rate' => 550]);
        Contract::create(['project_id' => $project4->id, 'included_hours' => 40, 'extra_hourly_rate' => 500]);

        $ticketsData = [
            ['project' => $project1, 'user' => $collab1, 'title' => 'Configuration serveur S3',         'type' => 'inclus',     'status' => 'nouveau'],
            ['project' => $project1, 'user' => $collab1, 'title' => 'Migration base de données',         'type' => 'inclus',     'status' => 'en_cours'],
            ['project' => $project1, 'user' => $collab2, 'title' => 'Tests de performance',              'type' => 'inclus',     'status' => 'en_attente'],
            ['project' => $project1, 'user' => $collab1, 'title' => 'Mise en production phase 1',        'type' => 'facturable', 'status' => 'a_valider'],
            ['project' => $project1, 'user' => $collab2, 'title' => 'Formation équipe client',           'type' => 'facturable', 'status' => 'valide'],
            ['project' => $project1, 'user' => $collab1, 'title' => 'Audit sécurité',                    'type' => 'facturable', 'status' => 'refuse'],

            ['project' => $project2, 'user' => $collab1, 'title' => 'Maquettes Figma',                   'type' => 'inclus',     'status' => 'valide'],
            ['project' => $project2, 'user' => $collab1, 'title' => 'Intégration HTML/CSS',              'type' => 'inclus',     'status' => 'en_cours'],
            ['project' => $project2, 'user' => $collab1, 'title' => 'Connexion formulaire de contact',   'type' => 'facturable', 'status' => 'a_valider'],

            ['project' => $project3, 'user' => $collab2, 'title' => 'Installation ERP',                  'type' => 'inclus',     'status' => 'valide'],
            ['project' => $project3, 'user' => $collab2, 'title' => 'Paramétrage modules RH',            'type' => 'inclus',     'status' => 'en_cours'],
            ['project' => $project3, 'user' => $collab2, 'title' => 'Import données historiques',        'type' => 'facturable', 'status' => 'a_valider'],

            ['project' => $project4, 'user' => $collab1, 'title' => 'Prototype iOS',                     'type' => 'inclus',     'status' => 'en_cours'],
            ['project' => $project4, 'user' => $collab2, 'title' => 'API REST backend mobile',           'type' => 'inclus',     'status' => 'en_attente'],
            ['project' => $project4, 'user' => $collab1, 'title' => 'Push notifications',               'type' => 'facturable', 'status' => 'nouveau'],
            ['project' => $project4, 'user' => $collab2, 'title' => 'Tests sur devices réels',           'type' => 'facturable', 'status' => 'a_valider'],
        ];

        $timeEntriesData = [
            [2.5, '2026-02-10', 'Initialisation du projet'],
            [3,   '2026-02-15', 'Travail sur les migrations'],
            [1.5, '2026-03-01', null],
            [4,   '2026-03-10', 'Session de tests complète'],
            [2,   '2026-03-20', 'Mise en prod réussie'],
            [1,   '2026-03-25', null],
            [3,   '2026-01-20', 'Maquettes validées par le client'],
            [5,   '2026-02-05', 'Intégration en cours'],
            [2,   '2026-03-15', 'Formulaire fonctionnel'],
            [4,   '2026-01-10', 'Installation terminée'],
            [3,   '2026-02-20', 'Modules configurés'],
            [2,   '2026-03-05', 'Import de 5000 lignes'],
            [3,   '2026-02-28', 'Prototype fonctionnel'],
            [4,   '2026-03-12', 'API endpoints créés'],
            [1.5, '2026-03-18', null],
            [2.5, '2026-03-22', 'Tests sur iPhone et Samsung'],
        ];

        foreach ($ticketsData as $index => $data) {
            $ticket = Ticket::create([
                'project_id'  => $data['project']->id,
                'user_id'     => $data['user']->id,
                'title'       => $data['title'],
                'description' => 'Description détaillée du ticket : ' . $data['title'],
                'type'        => $data['type'],
                'status'      => $data['status'],
            ]);

            $entry = $timeEntriesData[$index];
            TimeEntry::create([
                'ticket_id' => $ticket->id,
                'user_id'   => $data['user']->id,
                'hours'     => $entry[0],
                'date'      => $entry[1],
                'comment'   => $entry[2],
            ]);
        }
    }
}
