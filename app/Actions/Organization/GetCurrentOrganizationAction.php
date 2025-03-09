<?php

declare(strict_types=1);

namespace App\Actions\Organization;

use App\Models\Organization;
use App\Models\User;

final readonly class GetCurrentOrganizationAction
{
    public function handle(): ?Organization
    {
        return \App\Support\Organization\organization();
    }
}
