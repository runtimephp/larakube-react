<?php

declare(strict_types=1);

use App\Actions\Organization\SwitchOrganizationAction;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

test('it adds the currents organization id on the session', function (): void {

    // Arrange
    $organization = Organization::factory()
        ->createQuietly()
        ->fresh();

    $user = User::factory()
        ->createQuietly()
        ->fresh();

    // Act
    app(SwitchOrganizationAction::class)
        ->handle(
            user: $user,
            organization: $organization
        );

    $cachedOrganization = \App\Support\Organization\organization();

    // Assert
    expect($cachedOrganization)
        ->toBeInstanceOf(Organization::class)
        ->and($cachedOrganization->id)
        ->toBe($organization->id);

    Cache::forget('organizations:current:'.$user->id);

});
