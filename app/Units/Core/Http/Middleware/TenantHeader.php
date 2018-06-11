<?php

namespace Emtudo\Units\Core\Http\Middleware;

use Closure;
use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Domains\Users\User;
use Illuminate\Http\Response;

class TenantHeader
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var User $user */
        $user = $request->user();

        if (!$user) {
            return $next($request);
        }

        $tenant = Tenant::currentTenant();

        /** @var Response $response */
        $response = $next($request);

        // sets the tenant public id header.
        $response->header('X-Emtudo-Tenant', $tenant->publicId());

        return $response;
    }
}
