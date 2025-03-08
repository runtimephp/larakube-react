<?php

declare(strict_types=1);

use App\Models\Organization;
use App\Models\User;

test('it can belong to multiple users', function (): void {

    // Arrange
    $organization = Organization::factory()
        ->createQuietly()
        ->fresh();

    $user1 = User::factory()
        ->createQuietly()
        ->fresh();

    $user2 = User::factory()
        ->createQuietly()
        ->fresh();

    // Act
    $organization->users()->attach($user1, ['role' => 'admin']);
    $organization->users()->attach($user2, ['role' => 'member']);

    // Assert
    expect($organization->users()->count())
        ->toBe(2);

});

test('to array', function (): void {

    /** @var Organization $organization */
    $organization = Organization::factory()
        ->for(User::factory(), 'owner')
        ->create()
        ->fresh();

    expect(array_keys($organization->toArray()))
        ->toBe([
            'id',
            'owner_id',
            'name',
            'slug',
            'config',
            'created_at',
            'updated_at',
        ]);

});
