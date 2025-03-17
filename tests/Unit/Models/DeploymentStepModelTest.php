<?php

declare(strict_types=1);

use App\Models\DeploymentStep;
use App\Models\DeploymentStepGroup;

test('it belongs to a step group', function (): void {
    // Arrange
    $step = DeploymentStep::factory()
        ->createQuietly();

    // Act
    $stepGroup = $step->stepGroup;

    // Assert
    expect($stepGroup)
        ->not->toBeNull()
        ->toBeInstanceOf(DeploymentStepGroup::class);
});

test('it belongs to an organization', function (): void {
    // Arrange
    $step = DeploymentStep::factory()
        ->createQuietly();

    // Act
    $organization = $step->organization;

    // Assert
    expect($organization)
        ->not->toBeNull();
});

test('to array', function (): void {
    $step = DeploymentStep::factory()
        ->createQuietly()
        ->fresh();

    expect($step->toArray())
        ->toBeArray()
        ->toHaveKeys([
            'id',
            'organization_id',
            'deployment_step_group_id',
            'name',
            'description',
            'order',
            'status',
            'metadata',
            'output',
            'started_at',
            'completed_at',
            'created_at',
            'updated_at',
        ]);
});
