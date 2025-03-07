<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\NetworkResource;
use App\Models\Concerns\BelongsToCloudAccount;
use App\Models\Concerns\BelongsToNetwork;
use App\Models\Concerns\BelongsToOrganization;
use App\Models\Concerns\HasManyNetworkResources;
use Database\Factories\NetworkFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Network extends Model
{
    use BelongsToCloudAccount;
    use BelongsToNetwork;
    use BelongsToOrganization;

    /** @use HasFactory<NetworkFactory> */
    use HasFactory;

    use HasManyNetworkResources;

    public function casts(): array
    {
        return [
            'type' => NetworkResource::class,
            'config' => 'array',
        ];
    }
}
