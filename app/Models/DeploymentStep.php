<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\BelongsToOrganization;
use Database\Factories\DeploymentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class DeploymentStep extends Model
{
    use BelongsToOrganization;

    /** @use HasFactory<DeploymentFactory> */
    use HasFactory;

    protected $casts = [
        'metadata' => 'array',
        'output' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * @return BelongsTo<DeploymentStepGroup, $this>
     */
    public function stepGroup(): BelongsTo
    {
        return $this->belongsTo(DeploymentStepGroup::class, 'deployment_step_group_id');
    }
}
