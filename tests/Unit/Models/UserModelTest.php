<?php

declare(strict_types=1);

use App\Models\Organization;
use App\Models\User;

test('it can own a organization', function (): void {

    // Arrange
    $user = User::factory()
        ->createQuietly();

    $organization = Organization::factory()
        ->createQuietly()
        ->fresh();

    // Act
    $user->ownedOrganizations()->save($organization);

    // Assert
    expect($user->ownedOrganizations->first()->name)
        ->toBe($organization->name);

});
