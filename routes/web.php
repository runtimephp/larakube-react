<?php

declare(strict_types=1);

use App\Jobs\CreateKubernetesClusterJob;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

require __DIR__.'/auth.php';

Route::get('/', function () {
    CreateKubernetesClusterJob::dispatch();

    return Inertia::render('welcome');
})->name('home');

require __DIR__.'/settings.php';
