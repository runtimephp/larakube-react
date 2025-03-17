<?php

declare(strict_types=1);

use App\Models\Deployment;
use App\Models\DeploymentStepGroup;

test('it belongs to a cluster', function (): void {
    // Arrange
    $deployment = Deployment::factory()
        ->createQuietly();

    // Act
    $cluster = $deployment->cluster;

    // Assert
    expect($cluster)
        ->not->toBeNull();
});

test('it belongs to an organization', function (): void {
    // Arrange
    $deployment = Deployment::factory()
        ->createQuietly();

    // Act
    $organization = $deployment->organization;

    // Assert
    expect($organization)
        ->not->toBeNull();
});

test('it has many step groups', function (): void {
    // Arrange
    $deployment = Deployment::factory()
        ->createQuietly();

    DeploymentStepGroup::factory()
        ->count(3)
        ->for($deployment)
        ->createQuietly();

    // Act
    $stepGroups = $deployment->stepGroups;

    // Assert
    expect($stepGroups)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(DeploymentStepGroup::class);
});

test('step groups are ordered by order', function (): void {
    // Arrange
    $deployment = Deployment::factory()
        ->createQuietly();

    DeploymentStepGroup::factory()
        ->for($deployment)
        ->createQuietly(['order' => 3]);

    DeploymentStepGroup::factory()
        ->for($deployment)
        ->createQuietly(['order' => 1]);

    DeploymentStepGroup::factory()
        ->for($deployment)
        ->createQuietly(['order' => 2]);

    // Act
    $orders = $deployment->stepGroups->pluck('order');

    // Assert
    expect($orders->toArray())
        ->toBe([1, 2, 3]);
});

test('to array', function (): void {
    $deployment = Deployment::factory()
        ->createQuietly()
        ->fresh();

    expect($deployment->toArray())
        ->toBeArray()
        ->toHaveKeys([
            'id',
            'organization_id',
            'cluster_id',
            'status',
            'metadata',
            'started_at',
            'completed_at',
            'created_at',
            'updated_at',
        ]);
});
