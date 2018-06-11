<?php

namespace Emtudo\Units\Core\Http\Middleware;

use Closure;
use Emtudo\Domains\Users\User;
use Illuminate\Auth\Access\AuthorizationException;

class StaffRole
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

        if (!$user->staff) {
            throw new AuthorizationException();
        }

        if (!$user->hasStaffRole($role)) {
            throw new AuthorizationException();
        }

        return $next($request);
    }
}
