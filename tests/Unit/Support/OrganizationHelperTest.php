<?php

declare(strict_types=1);

use App\Models\Organization;

use function App\Support\Organization\organization;
use function App\Support\Organization\organizationId;
use function App\Support\Organization\useOrganization;

test('it returns the organization id', function (): void {
    $organization = Organization::factory()
        ->createQuietly();

    useOrganization($organization);

    expect(organizationId())->toBe($organization->id);
});

test('it returns the organization', function (): void {
    $organization = Organization::factory()
        ->createQuietly();

    useOrganization($organization);

    expect(organization())->toBe($organization);
});
