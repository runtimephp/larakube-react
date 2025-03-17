<?php

declare(strict_types=1);

namespace App\Actions\CloudAccount;

use App\Models\CloudAccount;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Collection;

final class GetCloudAccountsAction
{
    /**
     * @return Collection<int, CloudAccount>
     */
    public function handle(?Organization $organization = null): Collection
    {

        $query = CloudAccount::query();

        if ($organization instanceof \App\Models\Organization) {
            $query->where('organization_id', $organization->id);
        }

        return $query->get();

    }
}
