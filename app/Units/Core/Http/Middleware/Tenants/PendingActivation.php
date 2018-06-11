<?php

namespace Emtudo\Units\Core\Http\Middleware\Tenants;

use Closure;
use Emtudo\Domains\Tenants\Tenant;

/**
 * Class PendingActivation.
 *
 * Only allows a Tenant to use some resources until manually activated by staff
 */
class PendingActivation
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
        if ($this->skipRoute($request) || $this->hasBeenActivated()) {
            return $next($request);
        }

        return response()->json('Essa empresa está manualmente ativada ou revisada pela Emtudo, e estará disponível em breve.', 403);
    }

    /**
     * Checks a rotation to be prepared for the license selection.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function skipRoute($request)
    {
        if (!auth()->check()) {
            return true;
        }

        return $request->request->is('settings*') ||
        $request->is('logout') ||
        $request->is('admin*');
    }

    /**
     * Verify if tenant has valid license.
     *
     * @return bool
     */
    protected function hasBeenActivated()
    {
        $tenant = Tenant::currentTenant();

        return $tenant->activated();
    }
}
