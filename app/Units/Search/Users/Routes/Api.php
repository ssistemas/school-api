<?php

namespace Emtudo\Units\Search\Users\Routes;

use Emtudo\Support\Http\Routing\RouteFile;

/**
 * Api Routes.
 *
 * This file is where you may define all of the routes that are handled
 * by your application. Just tell Laravel the URIs it should respond
 * to using a Closure or controller method. Build something great!
 */
class Api extends RouteFile
{
    /**
     * Declare Api Routes.
     */
    public function routes()
    {
        route_search($this->router, 'managers');
        route_search($this->router, 'responsibles');
        route_search($this->router, 'students');
        route_search($this->router, 'teachers');
        route_search($this->router, 'users');
        route_search($this->router, 'managers');
        route_search($this->router, 'managers');
        route_search($this->router, 'managers');
        route_search($this->router, 'managers');
    }
}
