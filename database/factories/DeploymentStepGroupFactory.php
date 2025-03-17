<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Deployment;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

final class DeploymentStepGroupFactory extends Factory
{
    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'deployment_id' => Deployment::factory(),
            'name' => fake()->word(),
            'description' => fake()->sentence(),
            'order' => fake()->numberBetween(1, 10),
            'status' => fake()->randomElement(['pending', 'in_progress', 'completed', 'failed']),
        ];
    }
}
