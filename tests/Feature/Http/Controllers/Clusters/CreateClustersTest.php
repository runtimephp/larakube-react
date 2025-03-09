<?php

declare(strict_types=1);

use App\Enums\Region;
use Illuminate\Support\Facades\Storage;

test('it created a new cluster', function (): void {

    $user = $this->createUserWithOrganization();

    Storage::fake('local');

    $organization = $user->organizations()->first()->slug;

    $this->actingAs($user)
        ->post(route('clusters.store', ['organization' => $organization]), [
            'name' => 'Cluster 1',
            'region' => Region::Ashburn->value,
        ])
        ->assertRedirect(route('clusters.index', ['organization' => $organization]));

});
