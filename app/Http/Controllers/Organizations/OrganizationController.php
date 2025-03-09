<?php

declare(strict_types=1);

namespace App\Http\Controllers\Organizations;

use App\Actions\Organization\CreateOrganizationAction;
use App\Http\Requests\Organizations\CreateOrganizationRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

use function assert;
use function to_organization_route;

final class OrganizationController
{
    public function store(CreateOrganizationRequest $request, CreateOrganizationAction $createOrganization): RedirectResponse
    {

        $user = $request->user();

        assert($user instanceof User);

        $createOrganization->handle(
            user: $user,
            name: $request->string('name')->toString()
        );

        return to_organization_route(
            'dashboard',
        );

    }
}
