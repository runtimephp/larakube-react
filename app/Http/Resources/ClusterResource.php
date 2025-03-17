<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Enums\Region;
use App\Models\Cluster;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Cluster
 *
 * @property Region $region
 */
final class ClusterResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'region' => $this->region,
            'regionName' => $this->region->name(),
            'config' => $this->config,
            'cloudAccount' => CloudAccountResource::make($this->whenLoaded('cloudAccount')),
            'organization' => OrganizationResource::make($this->whenLoaded('organization')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
