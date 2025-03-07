<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\NetworkResource;
use App\Models\CloudAccount;
use App\Models\Network;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Network>
 */
final class NetworkFactory extends Factory
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
            'name' => fake()->company,
            'external_id' => fake()->uuid,
            'config' => [],
        ];
    }

    public function network(): self
    {
        return $this->state(fn (): array => [
            'type' => NetworkResource::Network->value,
        ]);
    }

    public function subnet(): self
    {
        return $this->state(fn (): array => [
            'type' => NetworkResource::Subnet->value,
            'parent_id' => Network::factory()->network(),
        ]);
    }

    public function route(): self
    {
        return $this->state(fn (): array => [
            'type' => NetworkResource::Route->value,
            'parent_id' => Network::factory()->network(),
        ]);
    }
}
