<?php

declare(strict_types=1);

use App\Actions\Organization\CreateOrganizationAction;
use App\Models\Organization;
use App\Models\User;

test('creates organization', function (): void {
    // Arrange
    $action = new CreateOrganizationAction();
    /** @var User $user */
    $user = User::factory()
        ->createQuietly()
        ->fresh();

    // Act
    $organization = $action->handle($user);

    // Assert
    expect($organization)
        ->toBeInstanceOf(Organization::class)
        ->and($organization->owner->name)
        ->toBe($user->name)
        ->and($organization->name)
        ->toBe($user->name);

});
