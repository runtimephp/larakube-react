<?php

declare(strict_types=1);

test('it renders the page', function (): void {

    $user = $this->createUserWithOrganization();

    $this->actingAs($user)
        ->get(route('clusters.index', ['organization' => $user->organizations()->first()->slug]))
        ->assertOk();

});
