<?php

declare(strict_types=1);

use App\Enums\Region;
use App\Models\CloudAccount;
use Illuminate\Support\Facades\Storage;

test('it created a new cluster', function (): void {

    $user = $this->createUserWithOrganization();

    Storage::fake('local');

    $organization = $user->organizations()->first();

    $cloudAccount = CloudAccount::factory()
        ->createQuietly(['organization_id' => $organization->id]);

    $this->actingAs($user)
        ->post(route('clusters.store', ['organization' => $organization->slug]), [
            'name' => 'Cluster 1',
            'region' => Region::HetznerAshburn->value,
            'cloudAccountId' => $cloudAccount->id,
        ])
        ->assertRedirect(route('clusters.index', ['organization' => $organization]));

});
