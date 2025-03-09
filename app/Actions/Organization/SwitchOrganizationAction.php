<?php

declare(strict_types=1);

namespace App\Actions\Organization;

use App\Models\Organization;
use App\Models\User;

use function App\Support\Organization\useOrganization;

final readonly class SwitchOrganizationAction
{
    public function handle(User $user, Organization $organization): Organization
    {
        return useOrganization($organization, $user);
    }
}
