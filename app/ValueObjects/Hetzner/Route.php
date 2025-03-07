<?php

declare(strict_types=1);

namespace App\ValueObjects\Hetzner;

final readonly class Route
{
    public function __construct(
        public string $destination,
        public string $gateway,
    ) {}

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return [
            'destination' => $this->destination,
            'gateway' => $this->gateway,
        ];
    }
}
