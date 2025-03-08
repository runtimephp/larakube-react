<?php

declare(strict_types=1);

use App\Enums\Region;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

test('it created a new cluster', function (): void {

    $user = User::factory()
        ->createQuietly();

    Storage::fake('local');

    $this->actingAs($user)
        ->post(route('clusters.store'), [
            'name' => 'Cluster 1',
            'region' => Region::Ashburn->value,
        ])
        ->assertRedirect(route('clusters.index'));

});
