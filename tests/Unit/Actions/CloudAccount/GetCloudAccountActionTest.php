<?php

declare(strict_types=1);

use App\Actions\CloudAccount\GetCloudAccountsAction;
use App\Models\CloudAccount;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Collection;

test('it returns a list of cloud accounts', function (): void {

    // Arrange
    $organization = Organization::factory()
        ->createQuietly();

    CloudAccount::factory()
        ->count(5)
        ->for($organization)
        ->createQuietly();

    // Act
    $cloudAccounts = app(GetCloudAccountsAction::class)
        ->handle($organization);

    // Assert
    expect($cloudAccounts)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(5);

});
