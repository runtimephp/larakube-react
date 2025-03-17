<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Clusters;

use App\Models\CloudAccount;
use App\Models\Cluster;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ShowClusterDeploymentsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_show_cluster_deployments(): void
    {
        $user = $this->createUserWithOrganization();
        $organization = $user->organizations()->first();
        $cloudAccount = CloudAccount::factory()->create([
            'organization_id' => $organization->id,
            'config' => [
                'key' => 'cloud-account',
            ],
        ]);
        $cluster = Cluster::factory()->create([
            'organization_id' => $organization->id,
            'cloud_account_id' => $cloudAccount->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('clusters.deployments', [
                'organization' => $organization->slug,
                'cluster' => $cluster->slug,
            ]));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('clusters/show/deployments')
            ->has('cluster')
            ->has('deployments')
        );
    }

    public function test_it_returns_404_when_cluster_not_found(): void
    {
        $user = User::factory()->create();
        $organization = Organization::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('clusters.deployments', [
                'organization' => $organization->slug,
                'cluster' => 'non-existent',
            ]));

        $response->assertNotFound();
    }

    public function test_it_returns_404_when_cluster_belongs_to_different_organization(): void
    {
        $user = User::factory()->create();
        $organization = Organization::factory()->create();
        $otherOrganization = Organization::factory()->create();
        $cloudAccount = CloudAccount::factory()->create([
            'organization_id' => $otherOrganization->id,
        ]);
        $cluster = Cluster::factory()->create([
            'organization_id' => $otherOrganization->id,
            'cloud_account_id' => $cloudAccount->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('clusters.deployments', [
                'organization' => $organization->slug,
                'cluster' => $cluster,
            ]));

        $response->assertNotFound();
    }
}
