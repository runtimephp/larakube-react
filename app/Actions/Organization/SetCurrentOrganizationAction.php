<?php

declare(strict_types=1);

namespace App\Actions\Organization;

use App\Models\Organization;
use Illuminate\Cache\Repository;

final readonly class SetCurrentOrganizationAction
{
    public function __construct(private Repository $cache) {}

    public function handle(int $organizationId, int $userId): void
    {
        $this->cache->put(
            'organizations:current:'.$userId,
            Organization::query()
                ->where('id', $organizationId)
                ->first(),
        );
    }
}
