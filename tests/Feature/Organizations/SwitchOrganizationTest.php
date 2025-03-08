<?php

declare(strict_types=1);

use App\Actions\Organization\SetCurrentOrganizationAction;
use App\Models\Organization;

test('can switch organization', function (): void {

    // Arrange
    $user = $this->createUserWithOrganization();
    $organization = Organization::factory()
        ->for($user, 'owner')
        ->createQuietly();

    $user->organizations()->attach($organization->id, ['role' => 'member']);
    app(SetCurrentOrganizationAction::class)->handle(
        $user->organizations()->first()->id,
        $user->id
    );

    // Act
    $response = $this->actingAs($user)->post(
        route('organizations.switch', ['organization' => $organization, 'routeName' => 'clusters.index']),
        ['organizationId' => $organization->id]
    );

    // Assert
    $response->assertRedirect();

});
