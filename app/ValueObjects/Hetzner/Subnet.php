<?php

declare(strict_types=1);

namespace App\ValueObjects\Hetzner;

final readonly class Subnet
{
    public function __construct(
        public string $ip_range,
        public string $network_zone,
        public string $type,
        public ?int $vswitch_id = null,
        public ?string $gateway = null,
    ) {}

    /**
     * @return array<string, string|int|null>
     */
    public function toArray(): array
    {
        $data = [
            'gateway' => $this->gateway,
            'ip_range' => $this->ip_range,
            'network_zone' => $this->network_zone,
            'type' => $this->type,
            'vswitch_id' => $this->vswitch_id,
        ];

        if ($this->gateway === null || $this->gateway === '' || $this->gateway === '0') {
            unset($data['gateway']);
        }

        if ($this->vswitch_id === null || $this->vswitch_id === 0) {
            unset($data['vswitch_id']);
        }

        return $data;
    }
}
