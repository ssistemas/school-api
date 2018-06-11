<?php

namespace Emtudo\Units\Teacher\Courses\Routes;

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
        $this->router->post('frequencies/several', 'FrequencyController@storeSeveral')->name('several');
        $this->router->apiResource('frequencies', 'FrequencyController');
        $this->router->post('grades/several', 'GradeController@storeSeveral')->name('several');
        $this->router->apiResource('grades', 'GradeController');
        $this->router->apiResource('groups', 'GroupController');
        $this->router->apiResource('quizzes', 'QuizController');
        $this->router->apiResource('subjects', 'SubjectController');
    }
}
