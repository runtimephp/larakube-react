<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Deployment;
use App\Models\DeploymentStep;
use App\Models\DeploymentStepGroup;
use App\Models\Organization;
use Illuminate\Database\Seeder;

final class DeploymentSeeder extends Seeder
{
    public function run(): void
    {
        $organization = Organization::factory()->create();

        $deployment = Deployment::factory()->create([
            'organization_id' => $organization->id,
            'status' => 'in_progress',
            'started_at' => now(),
        ]);

        // Network Setup Group
        $networkGroup = DeploymentStepGroup::factory()->create([
            'organization_id' => $organization->id,
            'deployment_id' => $deployment->id,
            'name' => 'Network Setup',
            'description' => 'Setting up the network infrastructure',
            'order' => 1,
            'status' => 'completed',
        ]);

        DeploymentStep::factory()->create([
            'organization_id' => $organization->id,
            'deployment_step_group_id' => $networkGroup->id,
            'name' => 'Create Network',
            'description' => 'Creating private network for cluster',
            'order' => 1,
            'status' => 'completed',
            'started_at' => now()->subMinutes(5),
            'completed_at' => now()->subMinutes(4),
        ]);

        // SSH Key Setup Group
        $sshGroup = DeploymentStepGroup::factory()->create([
            'organization_id' => $organization->id,
            'deployment_id' => $deployment->id,
            'name' => 'SSH Key Setup',
            'description' => 'Setting up SSH keys for server access',
            'order' => 2,
            'status' => 'in_progress',
        ]);

        DeploymentStep::factory()->create([
            'organization_id' => $organization->id,
            'deployment_step_group_id' => $sshGroup->id,
            'name' => 'Create SSH Key',
            'description' => 'Creating SSH key for server access',
            'order' => 1,
            'status' => 'in_progress',
            'started_at' => now()->subMinute(),
        ]);

        // Server Setup Group
        $serverGroup = DeploymentStepGroup::factory()->create([
            'organization_id' => $organization->id,
            'deployment_id' => $deployment->id,
            'name' => 'Server Setup',
            'description' => 'Creating and configuring servers',
            'order' => 3,
            'status' => 'pending',
        ]);

        DeploymentStep::factory()->createMany([
            [
                'organization_id' => $organization->id,
                'deployment_step_group_id' => $serverGroup->id,
                'name' => 'Create Master Node',
                'description' => 'Creating master node server',
                'order' => 1,
                'status' => 'pending',
            ],
            [
                'organization_id' => $organization->id,
                'deployment_step_group_id' => $serverGroup->id,
                'name' => 'Create Worker Node 1',
                'description' => 'Creating first worker node server',
                'order' => 2,
                'status' => 'pending',
            ],
            [
                'organization_id' => $organization->id,
                'deployment_step_group_id' => $serverGroup->id,
                'name' => 'Create Worker Node 2',
                'description' => 'Creating second worker node server',
                'order' => 3,
                'status' => 'pending',
            ],
        ]);
    }
}
