<?php

namespace Emtudo\Units\Core\Http\Middleware\Tenants;

use Closure;
use Emtudo\Domains\Tenants\Tenant;

class DetectTenant
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
        $user = $request->user();

        if ($user) {
            // trigger the tenant detection
            Tenant::currentTenant();
        }

        return $next($request);
    }
}
