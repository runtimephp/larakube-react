<?php

declare(strict_types=1);

namespace App\Actions\Organization;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Cache\Repository;
use Illuminate\Database\Eloquent\Collection;

final readonly class UserOrganizationsAction
{
    public function __construct(
        private Repository $cache
    ) {}

    /**
     * @return Collection<int, Organization>
     */
    public function handle(User $user): Collection
    {
        return $this->cache->remember(
            'organizations:user:'.$user->id,
            now()->addDay(),
            fn () => $user->organizations
        );
    }
}
