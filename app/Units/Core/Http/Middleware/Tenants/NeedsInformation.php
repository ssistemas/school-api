<?php

namespace Emtudo\Units\Core\Http\Middleware\Tenants;

use Closure;
use Emtudo\Domains\Tenants\Tenant;

class NeedsInformation
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
        if (true === $this->skipRoute($request) || false === $this->tenantNeedsRevision()) {
            return $next($request);
        }

        return response()->json('Os dados da empresa precisam ser preenchidos', 403);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    private function skipRoute($request)
    {
        if (!auth()->check()) {
            return true;
        }

        return $request->is('admin*') || $request->is('settings*') || $request->is('logout') || $request->is('change') || $request->is('invite*');
    }

    /**
     * @return bool
     */
    private function tenantNeedsRevision()
    {
        $tenant = Tenant::currentTenant();

        if ($tenant) {
            return $tenant->needsRevision();
        }

        return false;
    }
}
