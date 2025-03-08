<?php

declare(strict_types=1);

namespace App\Http\Controllers\Organizations;

use App\Actions\Organization\GetCurrentOrganizationAction;
use App\Actions\Organization\SetCurrentOrganizationAction;
use App\Http\Requests\Organizations\SwitchOrganizationRequest;
use Illuminate\Http\RedirectResponse;

use function assert;

final class SwitchOrganizationController
{
    public function store(
        SwitchOrganizationRequest $request,
        SetCurrentOrganizationAction $setCurrentOrganizationAction,
        GetCurrentOrganizationAction $getCurrentOrganizationAction
    ): RedirectResponse {

        assert($request->user() !== null);

        $setCurrentOrganizationAction->handle(
            organizationId: $request->integer('organizationId'),
            userId: $request->user()->id
        );

        $organization = $getCurrentOrganizationAction
            ->handle($request->user());

        return redirect()->route($request->string('routeName')->toString(), [
            'organization' => $organization?->slug,
        ]);

    }
}
