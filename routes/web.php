<?php

declare(strict_types=1);

use App\Jobs\CreateKubernetesClusterJob;
use App\Services\Hetzner\Hetzner;
use App\Services\Hetzner\Networks\GetAllNetworksRequest;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    CreateKubernetesClusterJob::dispatch();

    return Inertia::render('welcome');
})->name('home');

Route::get('/networks', function () {

    $hetzner = new Hetzner();
    $response = $hetzner->send(new GetAllNetworksRequest());

    return $response->json('networks');

})->name('networks');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
