<?php

declare(strict_types=1);

use App\Models\Organization;

test('can create a new organization', function (): void {

    // Arrange
    $user = $this->createUserWithOrganization();

    // Act
    $response = $this->actingAs($user)
        ->post(organization_route('organizations.store'), [
            'name' => 'Brand New Organization',
        ]);

    // Assert
    $response->assertRedirect(
        organization_route('dashboard')
    );

    $this->assertDatabaseHas('organizations', [
        'name' => 'Brand New Organization',
        'owner_id' => $user->id,
    ]);

    $organization = Organization::query()
        ->where('name', 'Brand New Organization')
        ->first();

    $user->refresh();

    expect($organization->owner->id)
        ->toBe($user->id)
        ->and(
            $user
                ->organizations
                ->contains('id', $organization->id)
        )
        ->toBeTrue();

});

test('organization name is required', function (): void {
    // Arrange
    $user = $this->createUserWithOrganization();

    // Act
    $response = $this->actingAs($user)
        ->from(organization_route('dashboard'))
        ->post(
            organization_route('organizations.store'),
            [
                'name' => '',
                'routeName' => 'dashboard',
            ]
        );

    // Assert
    $response->assertSessionHasErrors('name');
});

test('organization name must be at least 3 characters', function (): void {
    // Arrange
    $user = $this->createUserWithOrganization();

    // Act
    $response = $this->actingAs($user)
        ->from(organization_route('dashboard'))
        ->post(
            organization_route('organizations.store'),
            [
                'name' => 'ab',
                'routeName' => 'dashboard',
            ]
        );

    // Assert
    $response->assertSessionHasErrors('name');
});
