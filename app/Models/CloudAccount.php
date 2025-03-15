<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CloudProvider;
use App\Models\Concerns\BelongsToOrganization;
use Carbon\Carbon;
use Database\Factories\CloudAccountFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property-read int $organization_id
 * @property-read CloudProvider $provider
 * @property-read string $name
 * @property-read array<string, mixed> $config
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
final class CloudAccount extends Model
{
    use BelongsToOrganization;

    /** @use HasFactory<CloudAccountFactory> */
    use HasFactory;

    /**
     * @return array<string|mixed>
     */
    public function casts(): array
    {
        return [
            'provider' => CloudProvider::class,
            'config' => 'array',
        ];
    }
}
