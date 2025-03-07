<?php

declare(strict_types=1);

namespace App\Actions\Hetzner;

use App\Services\Hetzner\Hetzner;
use App\Services\Hetzner\Networks\CreateNetworkRequest;
use App\ValueObjects\Hetzner\Network;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Response;

final readonly class CreateNetworkAction
{
    private Hetzner $hetzner;

    public function __construct()
    {
        $this->hetzner = new Hetzner();
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function handle(Network $network): Response
    {

        return $this->hetzner->send(
            new CreateNetworkRequest($network)
        );

    }
}
