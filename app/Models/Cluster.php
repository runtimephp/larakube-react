<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Region;
use App\Models\Concerns\BelongsToOrganization;
use Carbon\Carbon;
use Database\Factories\ClusterFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read int $id
 * @property-read int $organization_id
 * @property-read int $cloud_account_id
 * @property-read string $name
 * @property string $slug
 * @property-read array<string, mixed> $config
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read Organization $organization
 * @property-read CloudAccount $cloudAccount
 * @property-read string $regionName
 */
final class Cluster extends Model
{
    use BelongsToOrganization;

    /** @use HasFactory<ClusterFactory> */
    use HasFactory;

    protected $casts = [
        'region' => Region::class,
        'config' => 'array',
    ];

    protected $appends = [
        'regionName',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getRegionNameAttribute(): string
    {
        return $this->region->name();
    }

    /**
     * @return BelongsTo<CloudAccount, $this>
     */
    public function cloudAccount(): BelongsTo
    {
        return $this->belongsTo(CloudAccount::class);
    }

    /**
     * @return HasMany<Deployment, $this>
     */
    public function deployments(): HasMany
    {
        return $this->hasMany(Deployment::class);
    }
}
