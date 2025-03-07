<?php

declare(strict_types=1);

namespace App\Services\Hetzner;

use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Saloon\PaginationPlugin\PagedPaginator;

use function assert;
use function config;

final class Hetzner extends Connector implements HasPagination
{
    public function resolveBaseUrl(): string
    {

        $baseUrl = config('services.hetzner.api_url');
        assert(is_string($baseUrl));

        return $baseUrl;
    }

    /**
     * @codeCoverageIgnore
     */
    public function paginate(Request $request): PagedPaginator
    {
        return new HetznerPaginator($this, $request);
    }

    /**
     * @return array<string, string>
     */
    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        $token = config('services.hetzner.api_key');
        assert(is_string($token));

        return new TokenAuthenticator($token);
    }
}
