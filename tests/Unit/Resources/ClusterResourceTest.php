<?php

declare(strict_types=1);

use App\Http\Resources\ClusterResource;
use App\Models\Cluster;

test('to array', function (): void {

    // Arrange
    $cluster = Cluster::factory()
        ->createQuietly()
        ->fresh();

    // Act
    $resource = ClusterResource::make($cluster);

    // Assert
    expect(array_keys($resource->response()->getData(true)))
        ->toBe([
            'id',
            'name',
            'slug',
            'region',
            'regionName',
            'config',
            'created_at',
            'updated_at',
        ]);

});
