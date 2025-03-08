<?php

declare(strict_types=1);

namespace App\Actions\Organization;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Str;

final class CreateOrganizationAction
{
    public function handle(User $user): Organization
    {

        return Organization::query()->createQuietly([
            'owner_id' => $user->id,
            'name' => $user->name,
            'slug' => Str::slug($user->name),
            'config' => [],
        ]);

    }
}
