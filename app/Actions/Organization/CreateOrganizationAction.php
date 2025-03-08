<?php

declare(strict_types=1);

namespace App\Actions\Organization;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Str;

final readonly class CreateOrganizationAction
{
    public function __construct(
        private SetCurrentOrganizationAction $setCurrentOrganizationAction
    ) {}

    public function handle(User $user): Organization
    {

        $organization = Organization::query()->createQuietly([
            'owner_id' => $user->id,
            'name' => $user->name,
            'slug' => Str::slug($user->name),
            'config' => [],
        ]);

        $organization->users()->save($user, ['role' => 'admin']);

        $this->setCurrentOrganizationAction->handle(
            $organization->id,
            $user->id
        );

        return $organization;

    }
}
