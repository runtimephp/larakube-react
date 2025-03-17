<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\DeploymentStepGroup;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

final class DeploymentStepFactory extends Factory
{
    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'deployment_step_group_id' => DeploymentStepGroup::factory(),
            'name' => fake()->word(),
            'description' => fake()->sentence(),
            'order' => fake()->numberBetween(1, 10),
            'status' => fake()->randomElement(['pending', 'in_progress', 'completed', 'failed']),
            'metadata' => [],
            'output' => [],
            'started_at' => fake()->optional()->dateTime(),
            'completed_at' => fake()->optional()->dateTime(),
        ];
    }
}
