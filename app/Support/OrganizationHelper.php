<?php

declare(strict_types=1);

namespace App\Support\Organization;

use App\Models\Organization;
use App\Models\User;

use function function_exists;

if (! function_exists('organization')) {
    function organization(): ?Organization
    {

        return app()->has('current.organization')
            ? app('current.organization')
            : null;
    }
}

if (! function_exists('organizationId')) {
    function organizationId(): int
    {
        return app('current.organization.id');
    }
}

if (! function_exists('useOrganization')) {
    function useOrganization(Organization $organization, ?User $user = null): Organization
    {
        app()->instance('current.organization', $organization);
        app()->instance('current.organization.id', $organization->id);

        $user?->currentOrganization()->associate($organization);

        return $organization;

    }
}
