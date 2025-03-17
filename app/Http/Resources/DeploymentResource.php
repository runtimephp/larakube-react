<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Deployment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Deployment
 */
final class DeploymentResource extends JsonResource
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
            'cluster' => $this->whenLoaded('cluster', fn () => ClusterResource::make($this->cluster)),
            'organization' => $this->whenLoaded('organization', fn () => OrganizationResource::make($this->organization)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
