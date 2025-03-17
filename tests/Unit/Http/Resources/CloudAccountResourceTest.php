<?php

declare(strict_types=1);

use App\Http\Resources\CloudAccountResource;
use App\Models\CloudAccount;
use App\Models\Organization;

test('to array', function (): void {

    // Arrange
    $organization = Organization::factory()
        ->createQuietly();

    $cloudAccount = CloudAccount::factory()
        ->createQuietly([
            'config' => [
                'key' => 'value',
            ],
        ]);

    // Act

    $resource = new CloudAccountResource($cloudAccount);

    // Assert
    expect(array_keys($resource->response()->getData(true)))
        ->toBe([
            'id',
            'provider',
            'providerName',
            'providerLogo',
            'regions',
            'name',
            'config',
        ]);

});
