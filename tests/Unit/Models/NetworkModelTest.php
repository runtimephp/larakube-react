<?php

declare(strict_types=1);

use App\Models\CloudAccount;
use App\Models\Network;
use App\Models\Organization;

test('it belongs to a organization', function (): void {

    // Arrange
    $organization = Organization::factory()
        ->createQuietly();

    $network = Network::factory()
        ->network()
        ->createQuietly();

    // Act
    $network->organization()->associate($organization);

    // Assert
    expect($network->organization->name)
        ->toBe($organization->name);

});

test('it belongs to a network', function (): void {

    /** @var Network $network */
    $network = Network::factory()
        ->network()
        ->createQuietly([
            'name' => 'Network 1',
        ]);

    /** @var Network $subnet */
    $subnet = Network::factory()
        ->subnet()
        ->createQuietly([
            'name' => 'Subnet 1',
        ])
        ->fresh();

    $subnet->network()->associate($network);

    expect($subnet->network->name)
        ->toBe('Network 1');

});

test('it has a network', function (): void {

    /** @var Network $network */
    $network = Network::factory()
        ->network()
        ->createQuietly();

    /** @var Network $subnet */
    $subnet = Network::factory()
        ->subnet()
        ->createQuietly([
            'name' => 'Subnet 1',
        ])
        ->fresh();

    $network->networkResources()->save($subnet);

    expect($subnet->name)
        ->toBe('Subnet 1');

});

test('it belong t a cloud account', function (): void {

    $network = Network::factory()
        ->network()
        ->createQuietly();

    /** @var CloudAccount $account */
    $account = CloudAccount::factory()
        ->createQuietly();

    $network->cloudAccount()->associate($account);

    expect($network->cloudAccount)->not()->toBeNull();

});

test('to array', function (): void {

    $network = Network::factory()
        ->network()
        ->createQuietly()
        ->fresh();

    expect(array_keys($network->toArray()))->toBe([
        'id',
        'organization_id',
        'cloud_account_id',
        'parent_id',
        'name',
        'type',
        'external_id',
        'config',
        'created_at',
        'updated_at',
    ]);

});
