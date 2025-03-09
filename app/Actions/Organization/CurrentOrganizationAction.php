<?php

declare(strict_types=1);

namespace App\Actions\Organization;

use App\Models\Organization;
use App\Models\User;

use function App\Support\Organization\organization;
use function App\Support\Organization\useOrganization;

final readonly class CurrentOrganizationAction
{
    public function handle(User $user): Organization
    {

        $organization = organization();

        if (! $organization instanceof Organization && $user->current_organization_id) {
            $organization = Organization::query()->find($user->current_organization_id);
        }

        if (! $organization) {
            $organization = $user->ownedOrganizations()->first();
        }

        if ($organization) {
            useOrganization($organization, $user);
        }

        assert($organization instanceof Organization);

        return $organization;

    }
}
