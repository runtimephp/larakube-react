<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\Organization\CurrentOrganizationAction;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

use function organization_route;

final class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password page.
     */
    public function show(): Response
    {
        return Inertia::render('auth/confirm-password');
    }

    /**
     * Confirm the user's password.
     */
    public function store(Request $request, CurrentOrganizationAction $currentOrganizationAction): RedirectResponse
    {
        if (! Auth::guard('web')->validate([
            'email' => $request->user()?->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());
        $user = $request->user();
        assert($user instanceof User);

        return redirect()->intended(organization_route(
            name: 'dashboard',
            absolute: false
        ));
    }
}
