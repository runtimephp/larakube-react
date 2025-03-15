<?php

declare(strict_types=1);

use App\Http\Controllers\CloudAccountController;
use App\Http\Controllers\Clusters\ClusterController;
use App\Http\Controllers\Organizations\OrganizationController;
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

Route::prefix('cloud-accounts')->as('cloud-accounts.')->group(function () {

    Route::get('/', [CloudAccountController::class, 'index'])
        ->name('index');

    Route::post('/', [CloudAccountController::class, 'store'])
        ->name('store');

    Route::patch('/{cloudAccount}', [CloudAccountController::class, 'update'])
        ->name('update');

    Route::delete('/{cloudAccount}', [CloudAccountController::class, 'destroy'])
        ->name('destroy');

});

Route::group(['prefix' => 'organizations', 'as' => 'organizations.'], function () {

    Route::post('/', [OrganizationController::class, 'store'])
        ->name('store');

    Route::post('/switch', [SwitchOrganizationController::class, 'store'])
        ->name('switch');
});
