<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use App\Enums\NetworkResource;
use App\Models\Network;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToNetwork
{
    /**
     * @return BelongsTo<Network, $this>
     */
    public function network(): BelongsTo
    {
        return $this->belongsTo(Network::class, 'parent_id')
            ->where('type', NetworkResource::Network->value);
    }
}
