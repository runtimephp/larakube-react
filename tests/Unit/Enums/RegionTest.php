<?php

declare(strict_types=1);

use App\Enums\CloudProvider;
use App\Enums\Region;

test('provider regions options returns correct regions for hetzner', function (): void {
    // Act
    $regions = Region::providerRegionsOptions(CloudProvider::HetznerCloud);

    // Assert
    expect($regions)
        ->toBeArray()
        ->toHaveCount(6)
        ->toHaveKeys([
            Region::HetznerNuremberg->value,
            Region::HetznerFalkenstein->value,
            Region::HetznerHelsinki->value,
            Region::HetznerSingapore->value,
            Region::HetznerHillsboro->value,
            Region::HetznerAshburn->value,
        ]);

    // Verify each region name is correct
    expect($regions[Region::HetznerNuremberg->value])->toBe('EU Central (Nuremberg)');
    expect($regions[Region::HetznerFalkenstein->value])->toBe('EU Central (Falkenstein)');
    expect($regions[Region::HetznerHelsinki->value])->toBe('EU Central (Helsinki)');
    expect($regions[Region::HetznerSingapore->value])->toBe('AP South East (Singapore)');
    expect($regions[Region::HetznerHillsboro->value])->toBe('US West (Hillsboro, OR)');
    expect($regions[Region::HetznerAshburn->value])->toBe('US East (Ashburn, VA)');
});

test('provider regions options returns correct regions for digital ocean', function (): void {
    // Act
    $regions = Region::providerRegionsOptions(CloudProvider::DigitalOcean);

    // Assert
    expect($regions)
        ->toBeArray()
        ->toHaveCount(2)
        ->toHaveKeys([
            Region::DigitalOceanAmsterdam1->value,
            Region::DigitalOceanAmsterdam2->value,
        ]);

    // Verify each region name is correct
    expect($regions[Region::DigitalOceanAmsterdam1->value])->toBe('EU Central (Amsterdam AMS2)');
    expect($regions[Region::DigitalOceanAmsterdam2->value])->toBe('EU Central (Amsterdam AMS3)');
});

test('provider regions options returns empty array for aws', function (): void {
    // Act
    $regions = Region::providerRegionsOptions(CloudProvider::AWS);

    // Assert
    expect($regions)
        ->toBeArray()
        ->toBeEmpty();
});

test('region name returns correct display name', function (): void {
    // Test all Hetzner regions
    expect(Region::HetznerNuremberg->name())->toBe('EU Central (Nuremberg)');
    expect(Region::HetznerFalkenstein->name())->toBe('EU Central (Falkenstein)');
    expect(Region::HetznerHelsinki->name())->toBe('EU Central (Helsinki)');
    expect(Region::HetznerSingapore->name())->toBe('AP South East (Singapore)');
    expect(Region::HetznerHillsboro->name())->toBe('US West (Hillsboro, OR)');
    expect(Region::HetznerAshburn->name())->toBe('US East (Ashburn, VA)');

    // Test all Digital Ocean regions
    expect(Region::DigitalOceanAmsterdam1->name())->toBe('EU Central (Amsterdam AMS2)');
    expect(Region::DigitalOceanAmsterdam2->name())->toBe('EU Central (Amsterdam AMS3)');
});
