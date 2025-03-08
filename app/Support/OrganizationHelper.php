<?php

declare(strict_types=1);

namespace App\Support\Organization;

use App\Models\Organization;

use function function_exists;

if (! function_exists('organization')) {
    function organization(): Organization
    {
        return app('current.organization');
    }
}

if (! function_exists('organizationId')) {
    function organizationId(): int
    {
        return app('current.organization.id');
    }
}

if (! function_exists('useOrganization')) {
    function useOrganization(Organization $organization): void
    {
        app()->instance('current.organization', $organization);
        app()->instance('current.organization.id', $organization->id);
    }
}
