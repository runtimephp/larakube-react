<?php

declare(strict_types=1);

namespace App\Console\Hetzner;

use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Console\Command\Command as CommandAlias;

use function config;
use function is_string;

/**
 * @codeCoverageIgnore
 */
final class CreateNetworkCommand extends Command
{
    protected $signature = 'hetzner:create-network';

    protected $description = 'Command description';

    /**
     * @throws ConnectionException
     *
     * @codeCoverageIgnore
     */
    public function handle(): int
    {

        $this->info('Creating network...');

        $url = config('services.hetzner.api_url');
        $token = config('services.hetzner.api_key');

        $response = Http::baseUrl(is_string($url) ? $url : '')
            ->withToken(is_string($token) ? $token : '')
            ->asJson()
            ->post('networks', $this->payload());

        if ($response->successful()) {
            $this->info('Network created successfully');

            return CommandAlias::SUCCESS;
        }
        $this->error('Failed to create network');

        return CommandAlias::FAILURE;

    }

    /**
     * @return array<string, mixed>
     */
    private function payload(): array
    {
        return [
            'name' => 'mynet',
            'ip_range' => '10.0.0.0/16',
            'labels' => [
                'environment' => 'prod',
                'domain' => 'larakube.com',
            ],
            'subnets' => [
                [
                    'type' => 'cloud',
                    'ip_range' => '10.0.1.0/24',
                    'network_zone' => 'eu-central',
                    'vswitch_id' => 1000,
                ],
            ],
            'routes' => [
                [
                    'destination' => '10.100.1.0/24',
                    'gateway' => '10.0.1.1',
                ],
            ],
            'expose_routes_to_vswitch' => false,
        ];
    }
}
