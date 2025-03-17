<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\CloudAccount;
use App\Models\Cluster;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class OrganizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_casts(): void
    {
        $organization = Organization::factory()->create([
            'config' => ['key' => 'value'],
        ]);

        $this->assertIsArray($organization->config);
        $this->assertEquals(['key' => 'value'], $organization->config);
    }

    public function test_owner_relationship(): void
    {
        $organization = Organization::factory()->create();

        $this->assertInstanceOf(User::class, $organization->owner);
    }

    public function test_users_relationship(): void
    {
        $organization = Organization::factory()->create();
        $user = User::factory()->create();

        $organization->users()->attach($user, ['role' => 'member']);

        $this->assertTrue($organization->users->contains($user));
        $this->assertEquals('member', $organization->users->first()->pivot->role);
    }

    public function test_cloud_accounts_relationship(): void
    {
        $organization = Organization::factory()->create();
        $cloudAccount = CloudAccount::factory()->create([
            'organization_id' => $organization->id,
        ]);

        $this->assertTrue($organization->cloudAccounts->contains($cloudAccount));
    }

    public function test_clusters_relationship(): void
    {
        $organization = Organization::factory()->create();
        $cluster = Cluster::factory()->create([
            'organization_id' => $organization->id,
        ]);

        $this->assertTrue($organization->clusters->contains($cluster));
    }
}
