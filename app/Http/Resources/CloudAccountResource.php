<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\CloudAccount;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CloudAccount
 */
final class CloudAccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'provider' => $this->provider,
            'providerName' => $this->provider->name(),
            'providerLogo' => $this->provider->logo(),
            'name' => $this->name,
            'config' => [
                'key' => $this->config['key'],
            ],
        ];
    }
}
