<?php

declare(strict_types=1);

namespace App\Services\Hetzner\Networks;

use App\ValueObjects\Hetzner\Network;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

final class CreateNetworkRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private Network $network,
    ) {

        $this->body()->setJsonFlags(JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);

    }

    /**
     * {@inheritDoc}
     */
    public function resolveEndpoint(): string
    {
        return 'networks';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->network->toArray();
    }
}
