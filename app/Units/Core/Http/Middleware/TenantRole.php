<?php

namespace Emtudo\Units\Core\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;

class TenantRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param string                   $role
     *
     * @throws AuthorizationException
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null)
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->staff) {
            return $next($request);
        }

        $currentRole = $user->getCurrentRole();

        if (!$currentRole) {
            throw new AuthorizationException();
        }

        if (!in_array($currentRole, [
            'admin', // Admin
            'manager', // Diretores
            'user', // Funcionários
        ], true)) {
            throw new AuthorizationException();
        }

        if ($role && !$this->checkPermission($currentRole, $role)) {
            throw new AuthorizationException();
        }

        return $next($request);
    }

    /**
     * @param string $currentRole
     * @param string $role
     *
     * @return bool
     */
    protected function checkPermission($currentRole, $role)
    {
        if ('admin' === $currentRole) {
            return true;
        }
        if ('manager' === $currentRole) {
            return in_array($role, ['manager', 'user'], true);
        }
        if ('user' === $currentRole) {
            return 'user' === $role;
        }

        return false;
    }
}
