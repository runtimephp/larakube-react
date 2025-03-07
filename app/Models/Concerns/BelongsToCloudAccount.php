<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use App\Models\CloudAccount;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToCloudAccount
{
    /**
     * @return BelongsTo<CloudAccount, $this>
     */
    public function cloudAccount(): BelongsTo
    {
        return $this->belongsTo(CloudAccount::class);
    }
}
