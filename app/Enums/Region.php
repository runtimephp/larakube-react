<?php

declare(strict_types=1);

namespace App\Enums;

enum Region: int
{
    case HetznerNuremberg = 0;
    case HetznerFalkenstein = 1;
    case HetznerHelsinki = 2;
    case HetznerSingapore = 3;
    case HetznerHillsboro = 4;
    case HetznerAshburn = 5;

    /**
     * @return array|string[]
     */
    public static function providerRegionsOptions(CloudProvider $provider): array
    {
        return match ($provider) {

            CloudProvider::HetznerCloud => [
                self::HetznerNuremberg->value => self::HetznerNuremberg->name(),
                self::HetznerFalkenstein->value => self::HetznerFalkenstein->name(),
                self::HetznerHelsinki->value => self::HetznerHelsinki->name(),
                self::HetznerSingapore->value => self::HetznerSingapore->name(),
                self::HetznerHillsboro->value => self::HetznerHillsboro->name(),
                self::HetznerAshburn->value => self::HetznerAshburn->name(),
            ],
            default => []

        };
    }

    /**
     * @codeCoverageIgnore
     */
    public function code(): string
    {
        return match ($this) {
            self::HetznerNuremberg => 'eu-central-ng',
            self::HetznerFalkenstein => 'eu-central-fs',
            self::HetznerHelsinki => 'eu-north-hel',
            self::HetznerSingapore => 'ap-southeast-sg',
            self::HetznerHillsboro => 'us-west-hb',
            self::HetznerAshburn => 'us-east-va',
        };
    }

    public function name(): string
    {
        return match ($this) {
            self::HetznerNuremberg => 'EU Central (Nuremberg)',
            self::HetznerFalkenstein => 'EU Central (Falkenstein)',
            self::HetznerHelsinki => 'EU Central (Helsinki)',
            self::HetznerSingapore => 'AP South East (Singapore)',
            self::HetznerHillsboro => 'US West (Hillsboro, OR)',
            self::HetznerAshburn => 'US East (Ashburn, VA)',
        };
    }
}
