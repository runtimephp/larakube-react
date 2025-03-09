<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\Organization\CurrentOrganizationAction;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

use function assert;
use function organization_route;

/** @codeCoverageIgnore  */
final class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request, CurrentOrganizationAction $currentOrganizationAction): RedirectResponse
    {
        $user = $request->user();

        if ($user?->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        if ($user?->markEmailAsVerified()) {
            /** @var MustVerifyEmail $user */
            event(new Verified($user));
        }

        assert($user instanceof User);

        return redirect()->intended(organization_route(
            name: 'dashboard',
            absolute: false
        ).'?verified=1');
    }
}
