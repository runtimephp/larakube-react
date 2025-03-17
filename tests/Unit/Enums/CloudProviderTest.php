<?php

declare(strict_types=1);

use App\Enums\CloudProvider;
use App\Enums\Region;

test('supportedRegions returns correct regions for DigitalOcean', function (): void {
    expect(CloudProvider::DigitalOcean->supportedRegions())->toBe([
        Region::DigitalOceanAmsterdam1->value => Region::DigitalOceanAmsterdam1->name(),
        Region::DigitalOceanAmsterdam2->value => Region::DigitalOceanAmsterdam2->name(),
    ]);
});

test('supportedRegions returns correct regions for Hetzner Cloud', function (): void {
    // Test Hetzner Cloud
    expect(CloudProvider::HetznerCloud->supportedRegions())->toBe([
        Region::HetznerNuremberg->value => Region::HetznerNuremberg->name(),
        Region::HetznerFalkenstein->value => Region::HetznerFalkenstein->name(),
        Region::HetznerHelsinki->value => Region::HetznerHelsinki->name(),
        Region::HetznerSingapore->value => Region::HetznerSingapore->name(),
        Region::HetznerHillsboro->value => Region::HetznerHillsboro->name(),
        Region::HetznerAshburn->value => Region::HetznerAshburn->name(),
    ]);
});

test('name returns correct display name', function (): void {
    // Test all providers
    expect(CloudProvider::AWS->name())->toBe('Amazon Web Services');
    expect(CloudProvider::GoogleCloud->name())->toBe('Google Cloud');
    expect(CloudProvider::DigitalOcean->name())->toBe('DigitalOcean');
    expect(CloudProvider::HetznerCloud->name())->toBe('Hetzner Cloud');
});

test('logo returns correct logo name', function (): void {
    // Test all providers
    expect(CloudProvider::AWS->logo())->toBe('AWSLogo');
    expect(CloudProvider::GoogleCloud->logo())->toBe('GoogleCloudLogo');
    expect(CloudProvider::DigitalOcean->logo())->toBe('DigitalOceanLogo');
    expect(CloudProvider::HetznerCloud->logo())->toBe('HetznerLogo');
});
