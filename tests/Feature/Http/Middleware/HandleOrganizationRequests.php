<?php

declare(strict_types=1);

use App\Models\Organization;

test('user cannot access organization that don\'t belong to', function (): void {

    // Arrange
    $user = $this->createUserWithOrganization();
    $organization = Organization::factory()
        ->createQuietly();

    // Act
    $response = $this->actingAs($user)->get(
        organization_route(
            'clusters.index',
            ['organization' => $organization->slug]
        )
    );

    // Assert
    $response->assertStatus(404);

});
