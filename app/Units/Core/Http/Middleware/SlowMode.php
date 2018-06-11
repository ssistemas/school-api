<?php

namespace Emtudo\Units\Core\Http\Middleware;

use Closure;

class SlowMode
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
        $slowModel = config('app.slow_mode');

        if ($slowModel) {
            sleep(2);
        }

        return $next($request);
    }
}
