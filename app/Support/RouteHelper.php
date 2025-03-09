<?php

declare(strict_types=1);

use Illuminate\Http\RedirectResponse;

use function App\Support\Organization\organization;

if (! function_exists('organization_route')) {

    /**
     * @param  array<string, mixed>  $parameters
     */
    function organization_route(string $name, array $parameters = [], bool $absolute = true): string
    {

        $parameters = [
            'organization' => organization()?->slug,
            ...$parameters,
        ];

        return route($name, $parameters, $absolute);
    }
}

if (! function_exists('to_organization_route')) {

    /**
     * @param  array<string, mixed>  $parameters
     * @param  array<string, mixed>  $headers
     */
    function to_organization_route(string $name, array $parameters = [], int $status = 302, array $headers = []): RedirectResponse
    {

        $parameters = [
            'organization' => organization()?->slug,
            ...$parameters,
        ];

        return to_route($name, $parameters, $status, $headers);
    }
}
