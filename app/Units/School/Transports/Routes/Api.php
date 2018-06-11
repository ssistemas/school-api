<?php

namespace Emtudo\Units\School\Transports\Routes;

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
        $this->router->apiResource('routes', 'RouteController');
        $this->router->apiResource('stops', 'StopController');
        $this->router->apiResource('vehicles', 'VehicleController');
    }
}
