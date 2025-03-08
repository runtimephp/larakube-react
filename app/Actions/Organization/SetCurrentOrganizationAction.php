<?php

declare(strict_types=1);

namespace App\Actions\Organization;

use Illuminate\Cache\CacheManager;

final readonly class SetCurrentOrganizationAction
{
    public function __construct(private CacheManager $cacheManager) {}

    public function handle(int $organizationId, int $userId): void
    {
        $this->cacheManager->put(
            'organizations:current:'.$userId,
            $organizationId
        );
    }
}
