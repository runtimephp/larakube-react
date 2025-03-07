<?php

declare(strict_types=1);

namespace App\Services\Hetzner;

use JsonException;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\PagedPaginator;

use function is_null;

/**
 * @codeCoverageIgnore
 */
final class HetznerPaginator extends PagedPaginator
{
    /**
     * @throws JsonException
     */
    protected function isLastPage(Response $response): bool
    {
        return is_null($response->json('meta.pagination.next_page'));
    }

    /**
     * {@inheritdoc}
     *
     *
     * @throws JsonException
     */
    protected function getPageItems(Response $response, Request $request): array
    {
        $networks = $response->json('networks');

        return is_array($networks) ? $networks : [];
    }
}
