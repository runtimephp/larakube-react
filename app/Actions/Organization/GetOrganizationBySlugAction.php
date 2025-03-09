<?php

declare(strict_types=1);

namespace App\Actions\Organization;

use App\Models\Organization;
use Illuminate\Cache\Repository;

final readonly class GetOrganizationBySlugAction
{
    public function __construct(private Repository $cache) {}

    public function handle(string $slug): ?Organization
    {
        return $this->cache->remember(
            'organization.slug.'.$slug,
            now()->addDays(1),
            fn () => Organization::query()
                ->where('slug', $slug)
                ->first()
        );
    }
}
