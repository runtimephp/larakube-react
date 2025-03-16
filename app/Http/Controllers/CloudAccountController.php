<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CloudAccounts\StoreCloudAccountRequest;
use App\Http\Requests\CloudAccounts\UpdateCloudAccountRequest;
use App\Http\Resources\CloudAccountResource;
use App\Models\CloudAccount;
use App\Models\Organization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

use function to_organization_route;

final class CloudAccountController
{
    public function index(Request $request, Organization $organization): Response
    {

        $cloudAccounts = CloudAccount::query()
            ->where('organization_id', $organization->id)
            ->get();

        return Inertia::render(
            'organization/cloud-accounts', [
                'cloudAccounts' => CloudAccountResource::collection($cloudAccounts),
            ]);
    }

    public function store(
        StoreCloudAccountRequest $request,
        Organization $organization
    ): RedirectResponse {

        $data = [
            'organization_id' => $organization->id,
            'provider' => $request->string('provider')->toString(),
            'name' => $request->string('name')->toString(),
            'config' => [
                'key' => $request->string('key')->toString(),
            ],
        ];

        CloudAccount::query()
            ->create($data);

        return to_organization_route('cloud-accounts.index');

    }

    public function update(
        UpdateCloudAccountRequest $request,
        Organization $organization,
        CloudAccount $cloudAccount
    ): RedirectResponse {

        $cloudAccount->update([
            'organization_id' => $organization->id,
            'provider' => $request->string('provider')->toString(),
            'name' => $request->string('name')->toString(),
            'config' => [
                'key' => $request->string('key')->toString(),
            ],
        ]);

        return to_organization_route('cloud-accounts.index');
    }

    public function destroy(Organization $organization, CloudAccount $cloudAccount): RedirectResponse
    {
        $cloudAccount->delete();

        return to_organization_route('cloud-accounts.index');
    }
}
