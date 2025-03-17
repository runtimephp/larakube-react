<?php

declare(strict_types=1);

use App\Enums\CloudProvider;
use App\Enums\Region;
use App\Models\CloudAccount;

test('it has many clusters', function (): void {

    // Arrange
    $cloudAccount = CloudAccount::factory()
        ->hasClusters(3)
        ->createQuietly();

    // Act
    $clusters = $cloudAccount->clusters;

    // Assert
    expect($clusters)
        ->toHaveCount(3);

});

test('it has the supported regions', function (): void {

    // Arrange
    $cloudAccount = CloudAccount::factory()
        ->createQuietly([
            'provider' => CloudProvider::HetznerCloud->value,
        ])
        ->fresh();

    // Act
    $regions = $cloudAccount?->provider->supportedRegions();

    // Assert
    expect($regions)
        ->toBe(
            Region::providerRegionsOptions(
                CloudProvider::HetznerCloud
            )
        );

});

test('to array', function (): void {

    $cloudAccount = CloudAccount::factory()
        ->createQuietly()
        ->fresh();

    expect(array_keys($cloudAccount->toArray()))
        ->toBe([
            'id',
            'organization_id',
            'provider',
            'name',
            'config',
            'created_at',
            'updated_at',
        ]);

});
