<?php

declare(strict_types=1);

use App\Enums\CloudProvider;

test('it returns the name of the provider', function (CloudProvider $cloudProvider, string $name): void {
    expect($cloudProvider->name())
        ->toBe($name);
})
    ->with([
        [CloudProvider::AWS, 'Amazon Web Services'],
        [CloudProvider::GoogleCloud, 'Google Cloud'],
        [CloudProvider::DigitalOcean, 'DigitalOcean'],
        [CloudProvider::HetznerCloud, 'Hetzner Cloud'],
    ]);

test('it returns the logo of the provider', function (CloudProvider $cloudProvider, string $logo): void {

    expect($cloudProvider->logo())
        ->toBe($logo);

})->with([
    [CloudProvider::AWS, 'AWSLogo'],
    [CloudProvider::GoogleCloud, 'GoogleCloudLogo'],
    [CloudProvider::DigitalOcean, 'DigitalOceanLogo'],
    [CloudProvider::HetznerCloud, 'HetznerLogo'],
]);
