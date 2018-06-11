<?php

namespace Emtudo\Units\Core\Http\Middleware;

use Closure;
use Emtudo\Domains\Users\User;
use Illuminate\Auth\Access\AuthorizationException;

class ResponsibleOfStudent
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

        $studentId = decode_id($request->route('student'));

        if ($user->userIsResponsibleOfStudent($studentId)) {
            return $next($request);
        }

        throw new AuthorizationException();
    }
}
