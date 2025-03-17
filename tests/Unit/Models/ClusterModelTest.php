<?php

declare(strict_types=1);

use App\Models\Cluster;

test('it belongs to a cloud account', function (): void {

    // Arrange
    $cluster = Cluster::factory()
        ->createQuietly();

    // Act
    $cloudAccount = $cluster->cloudAccount;

    // Assert
    expect($cloudAccount)
        ->not->toBeNull();

});

test('to array', function (): void {

    $cluster = Cluster::factory()
        ->createQuietly()
        ->fresh();

    expect($cluster->toArray())
        ->toBeArray()
        ->toHaveKeys([
            'id',
            'organization_id',
            'cloud_account_id',
            'name',
            'slug',
            'region',
            'config',
            'created_at',
            'updated_at',
        ]);

});
