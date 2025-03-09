<?php

declare(strict_types=1);

namespace Tests;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use function App\Support\Organization\useOrganization;

abstract class TestCase extends BaseTestCase
{
    /**
     * Create a user with an organization
     *
     * @param  array<string, mixed>  $userAttributes
     * @param  array<string, mixed>  $organizationAttributes
     */
    protected function createUserWithOrganization(
        array $userAttributes = [],
        array $organizationAttributes = [],
        string $role = 'owner'
    ): ?User {

        $organization = Organization::factory()
            ->createQuietly($organizationAttributes)
            ->fresh();

        $user = User::factory()
            ->createQuietly($userAttributes)
            ->fresh();

        useOrganization($organization, $user);

        $user->organizations()->attach($organization->id, ['role' => $role]);

        return $user->fresh();
    }
}
