<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Actions\Organization\GetCurrentOrganizationAction;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final readonly class HandleOrganizationRequest
{
    public function __construct(
        private GetCurrentOrganizationAction $getCurrentOrganizationAction,
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

        $this->getCurrentOrganizationAction->handle(
            user: $user,
        );

        return $next($request);
    }
}
