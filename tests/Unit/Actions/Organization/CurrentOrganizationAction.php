<?php

declare(strict_types=1);

use App\Actions\Organization\CurrentOrganizationAction;
use App\Models\Organization;
use App\Models\User;

test('it gets the organization from the user current organization', function (): void {

    // Arrange
    $user = User::factory()
        ->createQuietly()
        ->fresh();

    $organization = Organization::factory()
        ->for($user, 'owner')
        ->createQuietly()
        ->fresh();

    $user->currentOrganization()->associate($organization);

    $user->organizations()->save($organization, ['role' => 'owner']);

    // Act
    $action = new CurrentOrganizationAction();
    $organization = $action->handle($user);

    // Assert
    expect($organization)
        ->toBeInstanceOf(Organization::class)
        ->and($user->currentOrganization->id)
        ->toBe($organization->id);

});

test('it sets the organization if user has no current organization', function (): void {

    // Arrange
    $user = User::factory()
        ->createQuietly()
        ->fresh();

    $organization = Organization::factory()
        ->for($user, 'owner')
        ->createQuietly()
        ->fresh();

    $user->organizations()->save($organization, ['role' => 'owner']);

    // Act
    $action = new CurrentOrganizationAction();
    $organization = $action->handle($user);

    // Assert
    expect($organization)
        ->toBeInstanceOf(Organization::class)
        ->and($user->belongsToOrganization($organization->slug))
        ->toBeTrue();

});
