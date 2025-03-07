<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use App\Enums\NetworkResource;
use App\Models\Network;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyNetworkResources
{
    /**
     * @return HasMany<Network, $this>
     */
    public function networkResources(): HasMany
    {
        return $this->hasMany(Network::class, 'parent_id', 'id')
            ->whereNot('type', NetworkResource::Network->value);
    }
}
