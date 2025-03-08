<?php

declare(strict_types=1);

use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\HandleOrganizationRequest;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
        then: function (Application $app): void {
            $router = $app->make('router');
            $router->middleware(['web', 'auth', 'verified', 'organization'])
                ->prefix('{organization}')
                ->group(function (): void {
                    require base_path('routes/organization.php');
                });
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(
            append: [
                HandleInertiaRequests::class,
                AddLinkHeadersForPreloadedAssets::class,
            ]
        );

        $middleware->alias(['organization' => HandleOrganizationRequest::class]);

        $middleware->redirectUsersTo(function (Request $request): string {
            $user = $request->user();
            assert($user instanceof User);

            return route('dashboard', ['organization' => $request->user()?->organizations()->first()->slug]);
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
