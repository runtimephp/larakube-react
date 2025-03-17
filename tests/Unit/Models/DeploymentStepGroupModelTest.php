<?php

declare(strict_types=1);

use App\Models\Deployment;
use App\Models\DeploymentStep;
use App\Models\DeploymentStepGroup;

test('it belongs to a deployment', function (): void {
    // Arrange
    $stepGroup = DeploymentStepGroup::factory()
        ->createQuietly();

    // Act
    $deployment = $stepGroup->deployment;

    // Assert
    expect($deployment)
        ->not->toBeNull()
        ->toBeInstanceOf(Deployment::class);
});

test('it belongs to an organization', function (): void {
    // Arrange
    $stepGroup = DeploymentStepGroup::factory()
        ->createQuietly();

    // Act
    $organization = $stepGroup->organization;

    // Assert
    expect($organization)
        ->not->toBeNull();
});

test('it has many steps', function (): void {
    // Arrange
    $stepGroup = DeploymentStepGroup::factory()
        ->createQuietly();

    DeploymentStep::factory()
        ->count(3)
        ->for($stepGroup, 'stepGroup')
        ->createQuietly();

    // Act
    $steps = $stepGroup->steps;

    // Assert
    expect($steps)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(DeploymentStep::class);
});

test('steps are ordered by order', function (): void {
    // Arrange
    $stepGroup = DeploymentStepGroup::factory()
        ->createQuietly();

    DeploymentStep::factory()
        ->for($stepGroup, 'stepGroup')
        ->createQuietly(['order' => 3]);

    DeploymentStep::factory()
        ->for($stepGroup, 'stepGroup')
        ->createQuietly(['order' => 1]);

    DeploymentStep::factory()
        ->for($stepGroup, 'stepGroup')
        ->createQuietly(['order' => 2]);

    // Act
    $orders = $stepGroup->steps->pluck('order');

    // Assert
    expect($orders->toArray())
        ->toBe([1, 2, 3]);
});

test('to array', function (): void {
    $stepGroup = DeploymentStepGroup::factory()
        ->createQuietly()
        ->fresh();

    expect($stepGroup->toArray())
        ->toBeArray()
        ->toHaveKeys([
            'id',
            'organization_id',
            'deployment_id',
            'name',
            'description',
            'order',
            'status',
            'created_at',
            'updated_at',
        ]);
});
