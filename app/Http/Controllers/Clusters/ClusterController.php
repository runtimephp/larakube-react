<?php

declare(strict_types=1);

namespace App\Http\Controllers\Clusters;

use App\Http\Requests\Clusters\StoreClusterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

final class ClusterController
{
    public function index(): Response
    {
        return Inertia::render('clusters/index');
    }

    public function store(StoreClusterRequest $request, string $organization): RedirectResponse
    {

        $slug = Str::slug($request->string('name')->toString());
        $filePath = "clusters/{$slug}.txt";

        if (! Storage::disk('local')->exists('clusters')) {
            Storage::disk('local')->makeDirectory('clusters');
        }

        Storage::disk('local')
            ->put($filePath, "Name: {$request->string('name')->toString()}\nSlug: {$slug}\nRegion: {$request->string('region')->toString()}");

        return redirect()
            ->route('clusters.index', ['organization' => $organization]);

    }
}
