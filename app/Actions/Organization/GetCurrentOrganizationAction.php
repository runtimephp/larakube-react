<?php

declare(strict_types=1);

namespace App\Actions\Organization;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Cache\Repository;
use RuntimeException;

final readonly class GetCurrentOrganizationAction
{
    public function __construct(
        private Repository $cache,
        private SetCurrentOrganizationAction $setCurrentOrganizationAction
    ) {}

    public function handle(User $user): ?Organization
    {
        $organization = $this->cache->get('organizations:current:'.$user->id);

        if ($organization === null) {

            $organization = $user->organizations()->first();

            if (! $organization instanceof Organization) {
                throw new RuntimeException('Organization not found');
            }

            $this->setCurrentOrganizationAction->handle(
                organizationId: $organization->id,
                userId: $user->id
            );
        }

        return $organization instanceof Organization ? $organization : null;
    }
}
