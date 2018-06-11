<?php

namespace Emtudo\Units\Core\Http\Middleware;

use Closure;
use Emtudo\Domains\Users\User;
use Illuminate\Auth\Access\AuthorizationException;

class Role
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
    public function handle($request, Closure $next, $role)
    {
        /** @var User $user */
        $user = $request->user();

        if (!$user->hasRole($role)) {
            throw new AuthorizationException();
        }

        return $next($request);
    }
}
