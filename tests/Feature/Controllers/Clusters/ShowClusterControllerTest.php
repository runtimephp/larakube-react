<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Clusters;

use App\Models\CloudAccount;
use App\Models\Cluster;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ShowClusterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_show_cluster_details(): void
    {
        $user = User::factory()
            ->createQuietly()
            ->fresh();

        /** @var Organization $organization */
        $organization = Organization::factory()
            ->for($user, 'owner')
            ->createQuietly()
            ->fresh();

        $organization->users()->attach($user, ['role' => 'admin']);

        $cloudAccount = CloudAccount::factory()
            ->createQuietly([
                'organization_id' => $organization->id,
                'config' => [
                    'key' => 'cloud-account',
                ],
            ])
            ->fresh();
        $cluster = Cluster::factory()->create([
            'organization_id' => $organization->id,
            'cloud_account_id' => $cloudAccount->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('clusters.show', [
                'organization' => $organization->slug,
                'cluster' => $cluster->slug,
            ]));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('clusters/show/cluster')
            ->has('cluster', fn ($cluster) => $cluster
                ->has('id')
                ->has('name')
                ->has('slug')
                ->has('regionName')
                ->has('cloudAccount', fn ($cloudAccount) => $cloudAccount
                    ->has('id')
                    ->has('name')
                    ->has('providerName')
                    ->etc()
                )
                ->etc()
            )
        );
    }

    public function test_it_returns_404_when_cluster_not_found(): void
    {
        $user = User::factory()->create();
        $organization = Organization::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('clusters.show', [
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
            ->get(route('clusters.show', [
                'organization' => $organization->slug,
                'cluster' => $cluster,
            ]));

        $response->assertNotFound();
    }
}
