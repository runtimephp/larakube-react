<?php

declare(strict_types=1);

use App\Actions\Organization\GetOrganizationsByUserAction;
use App\Models\Organization;
use App\Models\User;

test('it returns the user organizations', function (): void {

    // Arrange
    $user = User::factory()
        ->createQuietly()
        ->fresh();

    $organizations = Organization::factory()
        ->count(2)
        ->createQuietly()
        ->fresh();

    $user->organizations()->attach($organizations->first(), ['role' => 'admin']);
    $user->organizations()->attach($organizations->last(), ['role' => 'member']);

    Organization::factory()
        ->count(2)
        ->createQuietly()
        ->fresh();

    // Act
    $organizations = app(GetOrganizationsByUserAction::class)
        ->handle($user);

    expect($organizations->count())->toBe(2);

});
