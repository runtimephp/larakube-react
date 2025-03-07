<?php

declare(strict_types=1);

namespace App\Actions\Hetzner;

use App\Services\Hetzner\Hetzner;
use App\Services\Hetzner\Networks\GetAllNetworksRequest;
use JsonException;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

final readonly class GetNetworksAction
{
    private Hetzner $hetzner;

    public function __construct()
    {
        $this->hetzner = new Hetzner();
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    public function handle(): mixed
    {
        $request = new GetAllNetworksRequest();
        $response = $this->hetzner->send($request);

        return $response->json('networks');
    }
}
