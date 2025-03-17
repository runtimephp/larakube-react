<?php

declare(strict_types=1);

namespace App\Http\Controllers\Clusters;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClusterResource;
use App\Models\Cluster;
use App\Models\Organization;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class ShowClusterInfrastructureController extends Controller
{
    public function index(Request $request, Organization $organization, Cluster $cluster): Response
    {
        return Inertia::render('clusters/show/infrastructure', [
            'cluster' => ClusterResource::make($cluster),
        ]);
    }
}
