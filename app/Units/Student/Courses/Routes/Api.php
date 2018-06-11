<?php

namespace Emtudo\Units\Student\Courses\Routes;

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
        route_index_show($this->router, 'courses');
        route_index_show($this->router, 'enrollments');
        route_index_show($this->router, 'groups');
        route_index_show($this->router, 'questions');
        route_index_show($this->router, 'quizzes');
        route_index_show($this->router, 'schedules');
    }
}
