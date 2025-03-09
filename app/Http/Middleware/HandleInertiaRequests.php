<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Actions\Organization\CurrentOrganizationAction;
use App\Actions\Organization\UserOrganizationsAction;
use App\Http\Resources\OrganizationResource;
use Exception;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Inertia\Middleware;

final class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    public function __construct(
        private readonly CurrentOrganizationAction $currentOrganizationAction,
        private UserOrganizationsAction $userOrganizationsAction,
    ) {}

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     *
     * @throws Exception
     */
    public function share(Request $request): array
    {

        $quote = Inspiring::quotes()->random();

        assert(is_string($quote));

        [$message, $author] = str($quote)->explode('-');

        $payload = [
            ...parent::share($request),
            'name' => config('app.name'),
            'quote' => ['message' => mb_trim((string) $message), 'author' => mb_trim((string) $author)],

            'auth' => [
                'user' => $request->user(),
            ],
        ];

        if ($request->user()) {
            return [
                ...$payload,
                'organizations' => OrganizationResource::collection(
                    $this->userOrganizationsAction->handle($request->user())
                ),

                'organization' => OrganizationResource::make(
                    $this->currentOrganizationAction->handle($request->user())
                ),
            ];
        }

        return $payload;

    }
}
