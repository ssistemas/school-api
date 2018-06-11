<?php

namespace Emtudo\Units\School\Calendars\Routes;

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
        $this->router->apiResource('calendars', 'CalendarController');
        $this->router->apiResource('events', 'EventController');
        $this->schoolDayRoutes();
        $this->twoMonthRoutes();
    }

    public function schoolDayRoutes()
    {
        $this->router->get('school_days/holidays_from_year/{year}', 'SchoolDayController@holidaysFromYear');
        $this->router->get('school_days/holidays_in_current_year', 'SchoolDayController@holidaysInCurrentYear');
        $this->router->put('school_days/toggle', 'SchoolDayController@toggle');
    }

    public function twoMonthRoutes()
    {
        $this->router->get('two_months', 'TwoMonthController@index')
            ->name('index');
        $this->router->get('two_months/{two_month}', 'TwoMonthController@show')
            ->name('show');
        $this->router->put('two_months/{two_month}', 'TwoMonthController@update')
            ->name('update');
        $this->router->post('two_months', 'TwoMonthController@store')
            ->name('store');
    }
}
