<?php

declare(strict_types=1);

use App\Actions\Hetzner\GetNetworksAction;
use App\Services\Hetzner\Networks\GetAllNetworksRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

test('it returns the networks list', function (): void {
    MockClient::global([
        GetAllNetworksRequest::class => MockResponse::fixture('hetzner.networks.list'),
    ]);

    $action = new GetNetworksAction();

    $networks = $action->handle();

    expect($networks)->toHaveCount(1);

});
