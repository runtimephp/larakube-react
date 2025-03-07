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
final class CreateSSHKeyCommand extends Command
{
    protected $signature = 'hetzner:create-ssh-key';

    protected $description = 'Command description';

    /**
     * @throws ConnectionException
     */
    public function handle(): int
    {

        $this->info('Creating ssh key...');

        $url = config('services.hetzner.api_url');
        $token = config('services.hetzner.api_key');

        $response = Http::baseUrl(is_string($url) ? $url : '')
            ->withToken(is_string($token) ? $token : '')
            ->asJson()
            ->post('ssh_keys', $this->payload());

        if ($response->successful()) {
            $this->info('SSH Key created successfully');

            return CommandAlias::SUCCESS;
        }
        $this->error('Failed to create SSH Key');

        return CommandAlias::FAILURE;

    }

    /**
     * @return array<string, mixed>
     */
    private function payload(): array
    {
        return [
            'name' => 'Default Key',
            'public_key' => 'ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAACAQCt+z3vL6r+4g74MWR1dBFGa8XaghT1CKN9/ZZGRHy5TOY17bhpnp0UaNOM+wzJWvL5vXEY32xFEgiTIuO+DNek77uS8ZmCT0JI/QoGKpG1FiOh0SLRwiBkaMMlr/e8EdPl1/tiBmUEwsHzfQCwz8b8N7LnRCCD16MpKWEsgenLXRfyaIPe3b9mpHnTFv0nYmzDxwNhCM36tUvnexYP74yAPijXC/3JcZkhedOB6TPTZyXhz3+0p4vDUkd+7ICtWQ+u8TGh8VNtCirh0EZ7wKBz572Jynnztdlx0qili4ekicuWukmavdnZN3o1yzl+pK4DyD9hq5RKK042vtBLaIJISRCzdWircpFE+CepWr3zA2BIiCVs+oeu1d6qXYfiuliGAn2rqIPRmd7wUjBvA5Tlnfvmt0t9RbPUGOq1fx5L4AiZ1kB3y5u5+gteimoLGFBa6VkSIv3GI0KeCXNopiC0oTa4G+OlAljsTaDcjtTici9C2XVbELK3v4zzzEb4jqJCNwqCQWNq+AHvV88r5Zr0FQnbMDEQC37QtljEPtiZCJNW/9J6xtaq3OwpyIcp78mY50D9kLfGXMVYxz85/yMuTanWmee7q8iCPJBSM24Kpss4l1/Axl7+sU4Mx7PK0TKvWRDjE2gPKOy9rvduWb3JbvphdZDEIg+6KlEri0nuOQ== franc@DESKTOP-98LUDU9',
            'labels' => [
                'environment' => 'prod',
                'larakube.com' => 'label',
            ],
        ];
    }
}
