<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CloudProvider;
use App\Models\Concerns\BelongsToOrganization;
use Database\Factories\CloudAccountFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
