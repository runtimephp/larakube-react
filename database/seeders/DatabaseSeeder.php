<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $organization = Organization::factory()
            ->create([
                'owner_id' => $user->id,
                'name' => 'Test Organization',
                'slug' => 'test-organization',
                'config' => [],
            ]);

        $organization2 = Organization::factory()
            ->create([
                'owner_id' => $user->id,
                'name' => 'Second Test Organization',
                'slug' => 'second-test-organization',
                'config' => [],
            ]);

        $organization->users()->save($user, ['role' => 'admin']);
        $organization2->users()->save($user, ['role' => 'admin']);

    }
}
