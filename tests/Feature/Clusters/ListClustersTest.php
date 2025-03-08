<?php

declare(strict_types=1);

use App\Models\User;

test('it renders the page', function (): void {

    $user = User::factory()
        ->createQuietly();

    $this->actingAs($user)
        ->get(route('clusters.index'))
        ->assertOk();

});
