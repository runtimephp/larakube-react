<?php

declare(strict_types=1);

namespace App\Console\Hetzner;

use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Console\Command\Command as CommandAlias;

use function is_string;

/**
 * @codeCoverageIgnore
 */
final class CreateServerCommand extends Command
{
    protected $signature = 'hetzner:create-server';

    protected $description = 'Command description';

    /**
     * @throws ConnectionException
     */
    public function handle(): int
    {

        $this->info('Creating network...');

        $url = config('services.hetzner.api_url');
        $token = config('services.hetzner.api_key');

        $response = Http::baseUrl(is_string($url) ? $url : '')
            ->withToken(is_string($token) ? $token : '')
            ->asJson()
            ->post('servers', $this->payload('dc', 'dcd'));

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
    private function payload(string $name, string $serverType): array
    {
        return [
            'name' => $name,
            'datacenter' => 'nbg1-dc3',
            'server_type' => $serverType,
            'start_after_create' => true,
            'image' => 'ubuntu-24.04',
            'ssh_keys' => [
                'Default Key',
            ],
            'labels' => [
                'environment' => 'prod',
                'domain' => 'larakube.com',
            ],
            'automount' => false,
            'user_data' => "#cloud-config\nruncmd:\n- [touch, /root/cloud-init-worked]\n",
            'networks' => [
                10752197,
            ],
            'public_net' => [
                'enable_ipv4' => true,
                'enable_ipv6' => false,
                'ipv4' => '10.0.1.0',
                'ipv6' => null,
            ],

        ];
    }
}
