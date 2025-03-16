<?php

declare(strict_types=1);

use App\Models\CloudAccount;

test('it deletes a cloud account', function (): void {
    // Arrange
    $user = $this->createUserWithOrganization();

    /** @var CloudAccount $cloudAccount */
    $cloudAccount = $user->currentOrganization->cloudAccounts()->create([
        'name' => 'AWS Account',
        'provider' => 'aws',
        'config' => [
            'key' => 'aws_key',
            'secret' => 'aws_secret',
        ],
    ]);

    $response = $this->actingAs($user)
        ->delete(organization_route('cloud-accounts.update', [
            'cloudAccount' => $cloudAccount->id,
        ]));

    expect($response->getStatusCode())->toBe(302);

    expect(CloudAccount::query()->where('id', $cloudAccount->id)->exists())
        ->toBeFalse();
});

test('it updates a cloud account', function (): void {
    // Arrange
    $user = $this->createUserWithOrganization();

    /** @var CloudAccount $cloudAccount */
    $cloudAccount = $user->currentOrganization->cloudAccounts()->create([
        'name' => 'AWS Account',
        'provider' => 'aws',
        'config' => [
            'key' => 'aws_key',
            'secret' => 'aws_secret',
        ],
    ]);

    $response = $this->actingAs($user)
        ->patch(organization_route('cloud-accounts.update', [
            'cloudAccount' => $cloudAccount->id,
        ]), [
            'name' => 'AWS Account Updated',
            'provider' => 'aws',
            'key' => 'aws_key',
        ]);

    expect($response->getStatusCode())->toBe(302);

    $cloudAccount->refresh();

    expect($cloudAccount->name)->toBe('AWS Account Updated');
});

test('it creates a new cloud account', function (): void {
    // Arrange
    $user = $this->createUserWithOrganization();

    $response = $this->actingAs($user)
        ->post(organization_route('cloud-accounts.store'), [
            'name' => 'AWS Account',
            'provider' => 'aws',
            'key' => 'aws_key',
        ]);

    expect($response->getStatusCode())
        ->toBe(302);

});

test('list cloud accounts', function (): void {

    // Arrange
    $user = $this->createUserWithOrganization();

    $response = $this->actingAs($user)
        ->get(organization_route('cloud-accounts.index'));

    expect($response->getStatusCode())->toBe(200);
})->group('cloud-accounts');
