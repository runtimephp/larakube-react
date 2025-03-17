<?php

declare(strict_types=1);

namespace App\Enums;

enum CloudProvider: string
{
    case AWS = 'aws';
    case GoogleCloud = 'google';
    case DigitalOcean = 'digitalocean';
    case HetznerCloud = 'hetzner';

    public function name(): string
    {
        return match ($this) {
            self::AWS => 'Amazon Web Services',
            self::GoogleCloud => 'Google Cloud',
            self::DigitalOcean => 'DigitalOcean',
            self::HetznerCloud => 'Hetzner Cloud',
        };
    }

    public function logo(): string
    {
        return match ($this) {
            self::AWS => 'AWSLogo',
            self::GoogleCloud => 'GoogleCloudLogo',
            self::DigitalOcean => 'DigitalOceanLogo',
            self::HetznerCloud => 'HetznerLogo',
        };
    }

    /**
     * @return array<int, string>
     */
    public function supportedRegions(): array
    {
        return match ($this) {
            self::HetznerCloud => [
                Region::HetznerNuremberg->value => Region::HetznerNuremberg->name(),
                Region::HetznerFalkenstein->value => Region::HetznerFalkenstein->name(),
                Region::HetznerHelsinki->value => Region::HetznerHelsinki->name(),
                Region::HetznerSingapore->value => Region::HetznerSingapore->name(),
                Region::HetznerHillsboro->value => Region::HetznerHillsboro->name(),
                Region::HetznerAshburn->value => Region::HetznerAshburn->name(),
            ],
            self::DigitalOcean => [
                Region::DigitalOceanAmsterdam1->value => Region::DigitalOceanAmsterdam1->name(),
                Region::DigitalOceanAmsterdam2->value => Region::DigitalOceanAmsterdam2->name(),
            ],
            default => []
        };
    }
}
