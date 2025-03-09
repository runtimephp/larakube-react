<?php

declare(strict_types=1);

use App\Actions\Organization\CurrentOrganizationAction;
use App\Models\Organization;
use App\Models\User;

test('it returns the organization when organization is already in app container', function (): void {
    // Arrange
    $organization = Organization::factory()
        ->createQuietly()
        ->fresh();

    // Simulate organization already being in the container
    app()->instance('current.organization', $organization);

    $user = User::factory()
        ->createQuietly()
        ->fresh();

    // Act
    $action = new CurrentOrganizationAction();
    $result = $action->handle($user);

    // Assert
    expect($result)->toBe($organization);
});

test('it returns organization from current_organization_id when no organization in container', function (): void {
    // Arrange
    $organization = Organization::factory()
        ->createQuietly()
        ->fresh();

    $user = User::factory()
        ->createQuietly([
            'current_organization_id' => $organization->id,
        ])
        ->fresh();

    // Ensure the container is empty
    if (app()->has('current.organization')) {
        app()->forgetInstance('current.organization');
    }

    // Act
    $action = new CurrentOrganizationAction();
    $result = $action->handle($user);

    // Assert
    expect($result->id)->toBe($organization->id);
});

test('it returns the first owned organization when no current organization is set', function (): void {
    // Arrange
    $user = User::factory()
        ->createQuietly([
            'current_organization_id' => null,
        ])
        ->fresh();

    $organization = Organization::factory()
        ->for($user, 'owner')
        ->createQuietly()
        ->fresh();

    // Ensure the container is empty
    if (app()->has('current.organization')) {
        app()->forgetInstance('current.organization');
    }

    // Act
    $action = new CurrentOrganizationAction();
    $result = $action->handle($user);

    // Assert
    expect($result->id)->toBe($organization->id);
});
