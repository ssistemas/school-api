<?php

namespace Emtudo\Units\Student\Users\Routes;

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
        $this->router->get('me/groups/{group}/grades', 'GradeController@getByGroupFromMe');
        $this->router->get('me/groups/{group}/frequencies/month/{month}', 'FrequencyController@getByGroupFromMe');
        $this->router->get('{student}/groups/{group}/grades', 'GradeController@getByGroup')
            ->middleware('responsible_of_student');
        $this->router->get('{student}/groups/{group}/frequencies/month/{month}', 'FrequencyController@getByGroup')
            ->middleware('responsible_of_student');
        $this->router->get('users/me', 'UserController@showMe');
        $this->router->put('users/me', 'UserController@updateMe');
        $this->router->get('users/{user}/documents/{kind}', 'UserController@getDocumetByKind');
        $this->router->delete('users/{user}/documents/{kind}', 'UserController@destroyDocument');
    }
}
