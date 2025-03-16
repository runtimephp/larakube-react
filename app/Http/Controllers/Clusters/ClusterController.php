<?php

declare(strict_types=1);

namespace App\Http\Controllers\Clusters;

use App\Actions\CloudAccount\GetCloudAccountsAction;
use App\Http\Requests\Clusters\StoreClusterRequest;
use App\Http\Resources\CloudAccountResource;
use App\Http\Resources\OrganizationResource;
use App\Models\Cluster;
use App\Models\Organization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

final class ClusterController
{
    public function index(Request $request, Organization $organization, GetCloudAccountsAction $action): Response
    {

        $cloudAccounts = $action->handle($organization);

        return Inertia::render('clusters/index', [
            'organization' => OrganizationResource::make($organization),
            'cloudAccounts' => CloudAccountResource::collection($cloudAccounts),
        ]);
    }

    public function store(StoreClusterRequest $request, Organization $organization): RedirectResponse
    {

        Cluster::query()->create([
            'name' => $request->string('name')->toString(),
            'slug' => Str::slug($request->string('name')->toString()),
            'region' => $request->integer('region'),
            'config' => [],
            'cloud_account_id' => $request->integer('cloudAccountId'),
            'organization_id' => $organization->id,
        ]);

        return redirect()
            ->route('clusters.index', ['organization' => $organization]);

    }
}
