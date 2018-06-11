<?php

namespace Emtudo\Units\School\Users\Routes;

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
        $this->router->apiResource('managers', 'ManagerController');
        $this->router->apiResource('responsibles', 'ResponsibleController');
        $this->router->apiResource('students', 'StudentController');
        $this->router->apiResource('teachers', 'TeacherController');
        $this->router->get('users/me', 'UserController@showMe');
        $this->router->put('users/me', 'UserController@updateMe');
        $this->router->get('users/{user}/documents/{kind}', 'UserController@getDocumetByKind');
        $this->router->delete('users/{user}/documents/{kind}', 'UserController@destroyDocument');
        $this->router->apiResource('users', 'UserController');
    }
}
