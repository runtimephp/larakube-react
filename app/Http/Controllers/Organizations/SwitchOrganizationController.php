<?php

declare(strict_types=1);

namespace App\Http\Controllers\Organizations;

use App\Actions\Organization\OrganizationBySlugAction;
use App\Actions\Organization\SwitchOrganizationAction;
use App\Http\Requests\Organizations\SwitchOrganizationRequest;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

use function assert;

final class SwitchOrganizationController
{
    public function store(
        SwitchOrganizationRequest $request,
        SwitchOrganizationAction $switchOrganization,
        OrganizationBySlugAction $organizationBySlug,
    ): RedirectResponse {

        $user = $request->user();
        assert($user instanceof User);

        $organization = $organizationBySlug->handle(
            $request->string('slug')->toString()
        );

        assert($organization instanceof Organization);

        $switchOrganization->handle(
            user: $user,
            organization: $organization
        );

        return redirect()->route($request->string('routeName')->toString(), [
            'organization' => $organization->slug,
        ]);

    }
}
