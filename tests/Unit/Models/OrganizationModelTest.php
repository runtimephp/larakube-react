<?php

declare(strict_types=1);

use App\Models\Organization;
use App\Models\User;

test('to array', function (): void {

    /** @var Organization $organization */
    $organization = Organization::factory()
        ->for(User::factory(), 'owner')
        ->create()
        ->fresh();

    expect(array_keys($organization->toArray()))
        ->toBe([
            'id',
            'owner_id',
            'name',
            'slug',
            'config',
            'created_at',
            'updated_at',
        ]);

});
