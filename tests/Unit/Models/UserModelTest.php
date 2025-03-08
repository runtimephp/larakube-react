<?php

declare(strict_types=1);

use App\Models\Organization;
use App\Models\User;

test('it can belong to multiple organizations', function (): void {

    // Arrange
    $user = User::factory()
        ->createQuietly()
        ->fresh();

    $organization1 = Organization::factory()
        ->createQuietly()
        ->fresh();

    $organization2 = Organization::factory()
        ->createQuietly()
        ->fresh();

    // Act
    $user->organizations()->attach($organization1, ['role' => 'admin']);
    $user->organizations()->attach($organization2, ['role' => 'member']);

    // Assert
    expect($user->organizations->first()->name)
        ->toBe($organization1->name);

    expect($user->organizations->last()->name)
        ->toBe($organization2->name);

});

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
