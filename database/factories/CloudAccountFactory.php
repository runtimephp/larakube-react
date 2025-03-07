<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\CloudProvider;
use App\Models\CloudAccount;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CloudAccount>
 */
final class CloudAccountFactory extends Factory
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
            'provider' => fake()->randomElement(CloudProvider::cases()),
            'name' => fake()->company(),
            'config' => [],
        ];
    }
}
