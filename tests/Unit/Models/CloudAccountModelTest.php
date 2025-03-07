<?php

declare(strict_types=1);

use App\Models\CloudAccount;

test('to array', function (): void {

    $cloudAccount = CloudAccount::factory()
        ->createQuietly()
        ->fresh();

    expect(array_keys($cloudAccount->toArray()))
        ->toBe([
            'id',
            'organization_id',
            'provider',
            'name',
            'config',
            'created_at',
            'updated_at',
        ]);

});
