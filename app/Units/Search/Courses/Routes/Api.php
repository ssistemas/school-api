<?php

namespace Emtudo\Units\Search\Courses\Routes;

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
        \route_search($this->router, 'courses');
        \route_search($this->router, 'enrollments');
        \route_search($this->router, 'frequencies');
        \route_search($this->router, 'grades');
        \route_search($this->router, 'groups');
        \route_search($this->router, 'questions');
        \route_search($this->router, 'quizzes');
        \route_search($this->router, 'schedules');
        \route_search($this->router, 'skills');
        \route_search($this->router, 'subjects');
    }
}
