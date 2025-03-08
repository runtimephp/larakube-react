<?php

declare(strict_types=1);

use App\Http\Controllers\Clusters\ClusterController;
use App\Http\Controllers\Organizations\SwitchOrganizationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('dashboard');
})->name('dashboard');

Route::prefix('clusters')->as('clusters.')->group(function () {

    Route::get('/', [ClusterController::class, 'index'])
        ->name('index');

    Route::post('/', [ClusterController::class, 'store'])
        ->name('store');

});

Route::group(['prefix' => 'organizations', 'as' => 'organizations.'], function () {

    Route::post('/switch', [SwitchOrganizationController::class, 'store'])
        ->name('switch');
});
