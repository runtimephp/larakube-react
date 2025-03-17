<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Cluster;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

final class DeploymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'cluster_id' => Cluster::factory(),
            'status' => fake()->randomElement(['pending', 'in_progress', 'completed', 'failed']),
            'metadata' => [],
            'started_at' => fake()->optional()->dateTime(),
            'completed_at' => fake()->optional()->dateTime(),
        ];
    }
}
