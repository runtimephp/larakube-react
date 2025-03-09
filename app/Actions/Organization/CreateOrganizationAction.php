<?php

declare(strict_types=1);

namespace App\Actions\Organization;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Str;

final readonly class CreateOrganizationAction
{
    public function __construct(
        private SwitchOrganizationAction $switchOrganization
    ) {}

    public function handle(User $user, ?string $name = null): Organization
    {

        $organization = Organization::query()->createQuietly([
            'owner_id' => $user->id,
            'name' => $name ??= $user->name,
            'slug' => $this->generateUniqueSlug(
                Str::slug($name)
            ),
            'config' => [],
        ]);

        $organization->users()->save($user, ['role' => 'owner']);

        return $this->switchOrganization->handle(
            user: $user,
            organization: $organization
        );

    }

    private function generateUniqueSlug(string $baseSlug): string
    {
        $slug = $baseSlug;
        $counter = 1;

        // Keep checking until we find a unique slug
        while ($this->slugExists($slug)) {
            $counter++;
            $slug = $baseSlug.'-'.$counter;
        }

        return $slug;
    }

    private function slugExists(string $slug): bool
    {
        return Organization::query()
            ->where('slug', $slug)
            ->exists();
    }
}
