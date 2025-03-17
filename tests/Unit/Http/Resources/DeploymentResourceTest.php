<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Resources;

use App\Enums\Region;
use App\Http\Resources\DeploymentResource;
use App\Models\CloudAccount;
use App\Models\Cluster;
use App\Models\Deployment;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class DeploymentResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_to_array(): void
    {
        $deployment = Deployment::factory()->create();

        $resource = DeploymentResource::make($deployment);
        $array = $resource->toArray(request());

        $this->assertEquals($deployment->id, $array['id']);
        $this->assertEquals($deployment->created_at, $array['created_at']);
        $this->assertEquals($deployment->updated_at, $array['updated_at']);
    }

    public function test_to_array_with_relationships(): void
    {
        $organization = Organization::factory()->create();
        $cloudAccount = CloudAccount::factory()->create([
            'organization_id' => $organization->id,
        ]);
        $cluster = Cluster::factory()->create([
            'organization_id' => $organization->id,
            'cloud_account_id' => $cloudAccount->id,
            'region' => Region::HetznerAshburn->value,
        ]);
        $deployment = Deployment::factory()->create([
            'organization_id' => $organization->id,
            'cluster_id' => $cluster->id,
        ]);
        $deployment->load('cluster', 'organization');

        $resource = DeploymentResource::make($deployment);
        $array = $resource->toArray(request());

        $this->assertEquals($deployment->id, $array['id']);
        $this->assertEquals($deployment->cluster->id, $array['cluster']['id']);
        $this->assertEquals($deployment->cluster->name, $array['cluster']['name']);
        $this->assertEquals($deployment->cluster->slug, $array['cluster']['slug']);
        $this->assertEquals($deployment->cluster->regionName, $array['cluster']['regionName']);
        $this->assertEquals($deployment->cluster->created_at, $array['cluster']['created_at']);
        $this->assertEquals($deployment->cluster->updated_at, $array['cluster']['updated_at']);
        $this->assertEquals($deployment->organization->id, $array['organization']['id']);
        $this->assertEquals($deployment->organization->name, $array['organization']['name']);
        $this->assertEquals($deployment->organization->slug, $array['organization']['slug']);
        $this->assertEquals($deployment->created_at, $array['created_at']);
        $this->assertEquals($deployment->updated_at, $array['updated_at']);
    }
}
