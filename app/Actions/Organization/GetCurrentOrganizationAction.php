<?php

declare(strict_types=1);

namespace App\Actions\Organization;

use App\Models\Organization;
use App\Models\User;

final readonly class GetCurrentOrganizationAction
{
    public function handle(User $user): ?Organization
    {
        return \App\Support\Organization\organization();
    }
}
