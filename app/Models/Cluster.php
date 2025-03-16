<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\BelongsToOrganization;
use Carbon\Carbon;
use Database\Factories\ClusterFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property-read int $organization_id
 * @property-read int $cloud_account_id
 * @property-read string $name
 * @property-read string $slug
 * @property-read array<string, mixed> $config
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read Organization $organization
 * @property-read CloudAccount $cloudAccount
 */
final class Cluster extends Model
{
    use BelongsToOrganization;

    /** @use HasFactory<ClusterFactory> */
    use HasFactory;

    /**
     * @return array<string, mixed>
     */
    public function casts(): array
    {
        return [
            'config' => 'array',
        ];
    }

    /**
     * @return BelongsTo<CloudAccount, $this>
     */
    public function cloudAccount(): BelongsTo
    {
        return $this->belongsTo(CloudAccount::class);
    }
}
