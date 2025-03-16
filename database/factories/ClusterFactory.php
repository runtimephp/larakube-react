<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\CloudAccount;
use App\Models\Cluster;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Cluster>
 */
final class ClusterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'cloud_account_id' => CloudAccount::factory(),
            'name' => $name = $this->faker->name,
            'slug' => Str::slug($name),
            'config' => [],
        ];
    }
}
