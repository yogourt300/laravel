<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_projects(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('projects.create'));

        $response->assertOk();
    }

    public function test_consultant_can_only_view_attached_projects(): void
    {
        $consultant = User::factory()->consultant()->create();
        $otherConsultant = User::factory()->consultant()->create();
        $client = User::factory()->client()->create();

        $visibleProject = Project::factory()->create([
            'client_id' => $client->id,
            'client_name' => $client->name,
        ]);
        $hiddenProject = Project::factory()->create([
            'client_id' => $client->id,
            'client_name' => $client->name,
        ]);

        $visibleProject->consultants()->attach($consultant->id);
        $hiddenProject->consultants()->attach($otherConsultant->id);

        $indexResponse = $this->actingAs($consultant)->get(route('projects.index'));
        $indexResponse->assertOk();
        $indexResponse->assertSee($visibleProject->name);
        $indexResponse->assertDontSee($hiddenProject->name);

        $showResponse = $this->actingAs($consultant)->get(route('projects.show', $hiddenProject));
        $showResponse->assertForbidden();
    }

    public function test_client_can_only_view_owned_projects(): void
    {
        $client = User::factory()->client()->create();
        $otherClient = User::factory()->client()->create();

        $ownedProject = Project::factory()->create([
            'client_id' => $client->id,
            'client_name' => $client->name,
        ]);
        $foreignProject = Project::factory()->create([
            'client_id' => $otherClient->id,
            'client_name' => $otherClient->name,
        ]);

        $indexResponse = $this->actingAs($client)->get(route('projects.index'));
        $indexResponse->assertOk();
        $indexResponse->assertSee($ownedProject->name);
        $indexResponse->assertDontSee($foreignProject->name);

        $showResponse = $this->actingAs($client)->get(route('projects.show', $foreignProject));
        $showResponse->assertForbidden();
    }
}
