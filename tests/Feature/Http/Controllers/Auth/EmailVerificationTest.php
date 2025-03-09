<?php

declare(strict_types=1);

use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

use function App\Support\Organization\useOrganization;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('email verification screen can be rendered', function (): void {
    $user = User::factory()
        ->unverified()
        ->create()
        ->fresh();

    $organization = Organization::factory()->for($user, 'owner')->create();
    $user->organizations()->save($organization, ['role' => 'owner']);
    useOrganization($organization);

    $response = $this->actingAs($user)->get('/verify-email');

    $response->assertStatus(200);
});

test('email can be verified', function (): void {
    $user = User::factory()->unverified()->create();

    $organization = Organization::factory()
        ->for($user, 'owner')
        ->create();
    $user->organizations()
        ->save($organization, ['role' => 'owner']);

    useOrganization($organization, $user);

    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1((string) $user->email)]
    );

    $response = $this->actingAs($user)->get($verificationUrl);

    Event::assertDispatched(Verified::class);
    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
    $response->assertRedirect(organization_route(
        name: 'dashboard',
        absolute: false).'?verified=1'
    );
});

test('email is not verified with invalid hash', function (): void {
    $user = User::factory()->unverified()->create();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1('wrong-email')]
    );

    $this->actingAs($user)->get($verificationUrl);

    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});
