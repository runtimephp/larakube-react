<?php

declare(strict_types=1);

use App\Actions\Hetzner\CreateNetworkAction;
use App\Services\Hetzner\Networks\CreateNetworkRequest;
use App\ValueObjects\Hetzner\Label;
use App\ValueObjects\Hetzner\Network;
use App\ValueObjects\Hetzner\Route;
use App\ValueObjects\Hetzner\Subnet;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

test('it creates a network', function (): void {

    MockClient::global([
        CreateNetworkRequest::class => MockResponse::fixture('hetzner.networks.create'),
    ]);

    $action = new CreateNetworkAction();

    $response = $action->handle(
        new Network(
            name: 'test-network',
            ip_range: '172.16.0.0/16',
            labels: [
                new Label('environment', 'production'),
                new Label('network', 'test-network'),
                new Label('team', 'devops'),
            ],
            routes: [
                new Route(
                    '10.100.1.0/24',
                    '172.16.1.1'
                ),
            ],
            subnets: [
                new Subnet(
                    ip_range: '172.16.1.0/24',
                    network_zone: 'eu-central',
                    type: 'cloud',
                ),
            ]
        )
    );

    $network = $response->json('network');

    expect($network['name'])->toBe('test-network');

});
