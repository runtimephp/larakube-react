<?php

declare(strict_types=1);

namespace App\Actions\Organization;

use App\Models\User;
use Illuminate\Cache\Repository;

final readonly class WarmUpUserOrganizationsCacheAction
{
    public function __construct(private Repository $cache) {}

    public function handle(User $user): void
    {

        $this->cache->forget('organizations:user:'.$user->id);

        $this->cache->put(
            'organizations:user:'.$user->id,
            $user->organizations,
            now()->addDay()
        );

    }
}
