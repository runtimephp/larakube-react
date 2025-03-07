<?php

declare(strict_types=1);

namespace App\Services\Hetzner\Networks;

use Saloon\Enums\Method;
use Saloon\Http\Request;

final class GetAllNetworksRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'networks';
    }
}
