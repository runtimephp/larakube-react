<?php

declare(strict_types=1);

use App\Actions\Organization\SetCurrentOrganizationAction;
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

    Cache::shouldReceive('put')
        ->once()
        ->with('organization:current:'.$user->id, $organization->id);

    $action = app(SetCurrentOrganizationAction::class);

    // Act
    $action->handle($organization->id, $user->id);

});
