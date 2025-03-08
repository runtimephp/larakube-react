<?php

declare(strict_types=1);

namespace App\Actions\Organization;

use Illuminate\Cache\CacheManager;

final readonly class SetCurrentOrganizationAction
{
    public function __construct(protected CacheManager $cacheManager) {}

    public function handle(int $organizationId, int $userId): void
    {
        $this->cacheManager->put(
            'organization:current:'.$userId,
            $organizationId
        );
    }
}
