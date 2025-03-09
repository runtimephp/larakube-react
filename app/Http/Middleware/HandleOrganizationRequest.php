<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Actions\Organization\OrganizationBySlugAction;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use function abort;
use function App\Support\Organization\useOrganization;
use function is_string;

final readonly class HandleOrganizationRequest
{
    public function __construct(
        private OrganizationBySlugAction $getOrganizationBySlugAction,
    ) {
        //
    }

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = $request->user();
        assert($user instanceof User);

        $organizationSlug = $request->route('organization');

        if ($organizationSlug && is_string($organizationSlug) && $user->belongsToOrganization($organizationSlug)) {
            $organization = $this->getOrganizationBySlugAction->handle(
                $organizationSlug
            );

            if ($organization instanceof \App\Models\Organization) {
                useOrganization($organization);

                return $next($request);
            }

        }

        abort(Response::HTTP_NOT_FOUND);
    }
}
