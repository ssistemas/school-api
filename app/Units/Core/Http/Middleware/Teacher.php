<?php

namespace Emtudo\Units\Core\Http\Middleware;

use Closure;
use Emtudo\Domains\Users\User;
use Illuminate\Auth\Access\AuthorizationException;

class Teacher
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @throws AuthorizationException
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->isTeacher() || $user->getProfile('teacher')) {
            return $next($request);
        }

        throw new AuthorizationException();
    }
}
