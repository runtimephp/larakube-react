<?php

declare(strict_types=1);

use App\Models\Organization;

test('it return 404 if user don\'t belong to organization', function (): void {

    // Arrange
    $user = $this->createUserWithOrganization();
    $organization = Organization::factory()
        ->createQuietly();

    // Act
    $response = $this->actingAs($user)->post(
        organization_route('organizations.switch'),
        [
            'slug' => $organization->slug,
            'routeName' => 'clusters.index',
        ]
    );

    // Assert
    $response->assertStatus(404);

});

test('can switch organization', function (): void {

    // Arrange
    $user = $this->createUserWithOrganization();
    $organization = Organization::factory()
        ->createQuietly();

    $user->organizations()
        ->attach($organization->id, ['role' => 'member']);

    // Act
    $response = $this->actingAs($user)->post(
        organization_route('organizations.switch'),
        [
            'slug' => $organization->slug,
            'routeName' => 'clusters.index',
        ]
    );

    // Assert
    $response->assertRedirect();

});
