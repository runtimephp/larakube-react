<?php

declare(strict_types=1);

namespace App\ValueObjects\Hetzner;

final readonly class Label
{
    public function __construct(
        public string $key,
        public string $value
    ) {}

    /**
     * @return array<int, string>
     */
    public function toArray(): array
    {
        return [$this->key, $this->value];
    }
}
